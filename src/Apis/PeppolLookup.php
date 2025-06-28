<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class PeppolLookup
{
    const PEPPOL_DIRECTORY_API_BASE = 'https://directory.peppol.eu/search/1.0/';
    const PEPPOL_HELGER_API_BASE = 'https://peppol.helger.com/api/';
    
    private $client;
    
    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
            'verify' => true,
        ]);
    }
    
    /**
     * Check if a participant is registered in Peppol using VAT number
     * 
     * @param string $vatNumber VAT number (e.g., BE0789207539)
     * @return array
     */
    public function checkParticipantByVat(string $vatNumber): array
    {
        // Convert VAT to Peppol participant ID format
        // Belgian VAT numbers use scheme 9956
        try {
            $participantId = $this->vatToPeppolId($vatNumber);
        } catch (\Exception $e) {
            return [
                'vat_number' => $vatNumber,
                'participant_id' => null,
                'is_registered' => false,
                'lookup_results' => [],
                'errors' => ['participant_id' => $e->getMessage()],
                'rate_limited' => false
            ];
        }
        
        // Try multiple lookup methods
        $results = [
            'vat_number' => $vatNumber,
            'participant_id' => $participantId,
            'is_registered' => false,
            'lookup_results' => [],
            'errors' => [],
            'rate_limited' => false
        ];
        
        // Method 1: Try Peppol Directory API
        try {
            $directoryResult = $this->lookupInDirectory($participantId);
            $results['lookup_results']['directory'] = $directoryResult;
            if (!empty($directoryResult['matches'])) {
                $results['is_registered'] = true;
            }
        } catch (ClientException $e) {
            if ($e->getResponse() && $e->getResponse()->getStatusCode() === 429) {
                $results['rate_limited'] = true;
                $results['errors']['directory'] = 'Rate limit exceeded. Please try again later.';
            } else {
                $results['errors']['directory'] = $e->getMessage();
            }
        } catch (\Exception $e) {
            $results['errors']['directory'] = $e->getMessage();
        }
        
        // Method 2: Try Helger API (only if not rate limited on first method)
        if (!$results['rate_limited']) {
            try {
                $helgerResult = $this->lookupInHelger($participantId);
                $results['lookup_results']['helger'] = $helgerResult;
                if (!empty($helgerResult['smpExists']) && $helgerResult['smpExists'] === true) {
                    $results['is_registered'] = true;
                }
            } catch (ClientException $e) {
                if ($e->getResponse() && $e->getResponse()->getStatusCode() === 429) {
                    $results['rate_limited'] = true;
                    $results['errors']['helger'] = 'Rate limit exceeded. Please try again later.';
                } else {
                    $results['errors']['helger'] = $e->getMessage();
                }
            } catch (\Exception $e) {
                $results['errors']['helger'] = $e->getMessage();
            }
        }
        
        return $results;
    }
    
    /**
     * Convert VAT number to Peppol participant ID
     * 
     * @param string $vatNumber
     * @return string
     */
    private function vatToPeppolId(string $vatNumber): string
    {
        // Remove spaces and convert to uppercase
        $vatNumber = strtoupper(preg_replace('/\s+/', '', $vatNumber));
        
        // Extract country code and number
        preg_match('/^([A-Z]{2})(.+)$/', $vatNumber, $matches);
        if (count($matches) !== 3) {
            throw new \Exception("Invalid VAT number format: $vatNumber");
        }
        
        $countryCode = $matches[1];
        $number = $matches[2];
        
        // Map country codes to Peppol schemes
        // Source: https://docs.peppol.eu/poacc/billing/3.0/codelist/ICD/
        $schemeMap = [
            'AT' => '9915',  // Austria - Österreichische Umsatzsteuer-Identifikationsnummer
            'BE' => '0208',  // Belgium - Numero d'entreprise / Ondernemingsnummer
            'BG' => '9926',  // Bulgaria - National identifier
            'CH' => '0183',  // Switzerland - Swiss Unique Business Identification Number (UID)
            'CY' => '9927',  // Cyprus - National identifier
            'CZ' => '9928',  // Czech Republic - National identifier
            'DE' => '9930',  // Germany - Leitweg-ID
            'DK' => '0184',  // Denmark - Danish CVR number
            'EE' => '9929',  // Estonia - National identifier  
            'ES' => '9920',  // Spain - Agencia Española de Administración Tributaria
            'FI' => '0213',  // Finland - Finnish Organization Identifier
            'FR' => '0009',  // France - SIRET code
            'GB' => '9932',  // United Kingdom - National identifier
            'GR' => '9933',  // Greece - National identifier
            'HR' => '9934',  // Croatia - National identifier
            'HU' => '9945',  // Hungary - National identifier
            'IE' => '9935',  // Ireland - National identifier
            'IS' => '0196',  // Iceland - Icelandic National Registry
            'IT' => '0211',  // Italy - Partita IVA
            'LI' => '9936',  // Liechtenstein - National identifier
            'LT' => '9937',  // Lithuania - National identifier
            'LU' => '0199',  // Luxembourg - Centre de Recherches Public
            'LV' => '9938',  // Latvia - National identifier
            'MT' => '9939',  // Malta - National identifier
            'NL' => '0106',  // Netherlands - Btw-identificatienummer
            'NO' => '0192',  // Norway - Organisasjonsnummer
            'PL' => '9946',  // Poland - National identifier
            'PT' => '9925',  // Portugal - National identifier
            'RO' => '9947',  // Romania - National identifier
            'SE' => '0007',  // Sweden - Organisationsnummer
            'SI' => '9948',  // Slovenia - National identifier
            'SK' => '9949',  // Slovakia - National identifier
        ];
        
        if (!isset($schemeMap[$countryCode])) {
            throw new \Exception("Unsupported country code for Peppol: $countryCode");
        }
        
        $scheme = $schemeMap[$countryCode];
        
        // For Belgian VAT numbers, we need to format it correctly
        // Belgian VAT is BE + 10 digits, but Peppol uses only the 10 digits
        if ($countryCode === 'BE') {
            // Ensure we have exactly 10 digits (add leading zeros if needed)
            $number = str_pad($number, 10, '0', STR_PAD_LEFT);
        }
        
        return "iso6523-actorid-upis::$scheme:$number";
    }
    
    /**
     * Lookup participant in Peppol Directory
     * 
     * @param string $participantId
     * @return array
     */
    private function lookupInDirectory(string $participantId): array
    {
        try {
            $response = $this->client->get(self::PEPPOL_DIRECTORY_API_BASE . 'json', [
                'query' => [
                    'participant' => $participantId
                ]
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            return $data ?? [];
        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() === 404) {
                return ['matches' => []];
            }
            throw $e;
        }
    }
    
    /**
     * Lookup participant using Helger API
     * 
     * @param string $participantId
     * @return array
     */
    private function lookupInHelger(string $participantId): array
    {
        try {
            // Helger API expects URL-encoded participant ID
            $encodedId = urlencode($participantId);
            $response = $this->client->get(self::PEPPOL_HELGER_API_BASE . "smpquery/$encodedId");
            
            $data = json_decode($response->getBody()->getContents(), true);
            return $data ?? [];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                $data = json_decode($responseBody, true);
                if (isset($data['smpExists']) && $data['smpExists'] === false) {
                    return $data;
                }
            }
            throw $e;
        }
    }
    
    /**
     * Check if a participant is registered in Peppol using Peppol participant ID
     * 
     * @param string $participantId Peppol participant ID (e.g., iso6523-actorid-upis::0208:0679893388)
     * @return array
     */
    public function checkParticipantById(string $participantId): array
    {
        $results = [
            'participant_id' => $participantId,
            'is_registered' => false,
            'lookup_results' => [],
            'errors' => [],
            'rate_limited' => false
        ];
        
        // Method 1: Try Peppol Directory API
        try {
            $directoryResult = $this->lookupInDirectory($participantId);
            $results['lookup_results']['directory'] = $directoryResult;
            if (!empty($directoryResult['matches'])) {
                $results['is_registered'] = true;
            }
        } catch (ClientException $e) {
            if ($e->getResponse() && $e->getResponse()->getStatusCode() === 429) {
                $results['rate_limited'] = true;
                $results['errors']['directory'] = 'Rate limit exceeded. Please try again later.';
            } else {
                $results['errors']['directory'] = $e->getMessage();
            }
        } catch (\Exception $e) {
            $results['errors']['directory'] = $e->getMessage();
        }
        
        // Method 2: Try Helger API (only if not rate limited on first method)
        if (!$results['rate_limited']) {
            try {
                $helgerResult = $this->lookupInHelger($participantId);
                $results['lookup_results']['helger'] = $helgerResult;
                if (!empty($helgerResult['smpExists']) && $helgerResult['smpExists'] === true) {
                    $results['is_registered'] = true;
                }
            } catch (ClientException $e) {
                if ($e->getResponse() && $e->getResponse()->getStatusCode() === 429) {
                    $results['rate_limited'] = true;
                    $results['errors']['helger'] = 'Rate limit exceeded. Please try again later.';
                } else {
                    $results['errors']['helger'] = $e->getMessage();
                }
            } catch (\Exception $e) {
                $results['errors']['helger'] = $e->getMessage();
            }
        }
        
        return $results;
    }
    
    /**
     * Get supported document types for a participant
     * 
     * @param string $participantId
     * @return array
     */
    public function getParticipantDocumentTypes(string $participantId): array
    {
        try {
            $encodedId = urlencode($participantId);
            $response = $this->client->get(self::PEPPOL_HELGER_API_BASE . "smpdoctypes/$encodedId");
            
            $data = json_decode($response->getBody()->getContents(), true);
            return $data ?? [];
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}