<?php

namespace MaartenDeBlock\ZenFactuurApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

abstract class ZenFactuurApi
{
    const BASE_URI = 'https://app.zenfactuur.be';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiToken;

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
        $this->client = new Client(['base_uri' => self::BASE_URI]);
    }

    /**
     * usage:
     * $urlParameters = ['key' => 'value','key2' => 'value2']
     *
     * @param string $partialUrl
     * @param array $urlParams
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function makeGetRequest(string $partialUrl, array $urlParams = []): ResponseInterface
    {
        return $this->client->get($partialUrl, [
            'query' => ['token' => $this->apiToken] + $urlParams
        ]);
    }

    /**
     * usage:
     * $urlParams = ['key' => 'value','key2' => 'value2']
     *
     * $formParams = ['key' => 'value','key2' => 'value2']
     *
     * @param string $partialUrl
     * @param array $formParams
     * @param array $urlParams
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function makePostRequest(string $partialUrl, array $formParams = [], array $urlParams = []): ResponseInterface
    {
        return $this->client->post($partialUrl, [
            RequestOptions::JSON => $formParams,
            'query' => ['token' => $this->apiToken] + $urlParams
        ]);
    }

    /**
     * usage:
     * $urlParams = ['key' => 'value','key2' => 'value2']
     *
     * $formParams = ['key' => 'value','key2' => 'value2']
     *
     * @param string $partialUrl
     * @param array $formParams
     * @param array $urlParams
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function makePutRequest(string $partialUrl, array $formParams = [], array $urlParams = []): ResponseInterface
    {
        return $this->client->put($partialUrl, [
            RequestOptions::JSON => $formParams,
            'query' => ['token' => $this->apiToken] + $urlParams
        ]);
    }

  /**
   *
   * @param ResponseInterface\ $response
   * @return array
   */
    protected function returnBody($response){
      return json_decode($response->getBody(), TRUE);
    }
}