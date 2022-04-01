<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class TimeRegistration extends ZenFactuurApi
{
    const NEW_TIME_REGISTRATION_URL = '/api/v2/time_slots.json';

    /**
     *
     * usage:
     * $postData = ['time_slot' => [
     *    'user_email' => 'example@gmail.com',
     *    'description' => 'crating time slot',
     *    'date' => '31/03/2022',
     *    'started_at_time' => '12:04',
     *    'stopped_at_time' => '12:20',
     *    'project_id' => '1',
     *  ]
     * ]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/time_slots/create.en.html
     *
     * @param array $postData
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function createTimeSlot(array $postData): array
    {
        $response = $this->makePostRequest(self::NEW_TIME_REGISTRATION_URL, $postData);

        return $this->returnBody($response);
    }
}