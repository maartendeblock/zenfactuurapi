<?php

namespace MaartenDeBlock\ZenFactuurApi\Apis;

use GuzzleHttp\Exception\GuzzleException;
use MaartenDeBlock\ZenFactuurApi\ZenFactuurApi;

class Project extends ZenFactuurApi
{
    const GET_LIST_OF_PROJECT_URL = '/api/v2/projects.json';
    const SEARCH_ALL_PROJECT_URL = '/api/v2/projects/search.json';
    const SPECIFIC_PROJECT_URL = '/api/v2/projects/:id.json';

    /**
     * @param int|null $page
     * @param int|null $perPage
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getAllProjects(int $page = null, int $perPage = null): array
    {
        $response = $this->makeGetRequest(self::GET_LIST_OF_PROJECT_URL, [
            'page' => $page,
            'per_page' => $perPage
        ]);

        return $this->returnBody($response);
    }

    /**
     * @param string $q
     * @param int|null $page
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function searchAllProjects(string $q = '', int $page = null): array
    {
        $response = $this->makeGetRequest(self::SEARCH_ALL_PROJECT_URL, [
            'q' => $q,
            'page' => $page
        ]);

        return $this->returnBody($response);
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function getProject(int $id): array
    {
        $response = $this->makeGetRequest(str_replace(':id', $id, self::SPECIFIC_PROJECT_URL));

        return $this->returnBody($response);
    }

    /**
     *
     * usage:
     * $postData = ['project' => ['name' => 'New project']]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/projects/create.en.html
     *
     * @param array $postData
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function createProject(array $postData): array
    {
        $response = $this->makePostRequest(self::GET_LIST_OF_PROJECT_URL, $postData);

        return $this->returnBody($response);
    }

    /**
     *
     * usage:
     * $updatedData = ['project' => ['name' => 'New project']]
     *
     * For complete list of available fields visit - https://app.zenfactuur.be/api_docs/v2/projects/update.en.html
     *
     * @param int $id
     * @param array $updatedData
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function modifyProject(int $id, array $updatedData): array
    {
        $response = $this->makePutRequest(str_replace(':id', $id, self::SPECIFIC_PROJECT_URL), $updatedData);

        return $this->returnBody($response);
    }
}