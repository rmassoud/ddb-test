<?php

namespace AppBundle\Services;

use GuzzleHttp\Client;

/**
 * Class AtlasApiClient
 * @package AppBundle\Services
 */
class AtlasApiClient
{
    const REGIONS_URL = 'regions';
    const AREAS_URL = 'areas';
    const SEARCH_URL = 'products';
    const GET_PRODUCT_URL = 'product';
    const PAGE_SIZE = 25;

    /**
     * @var string
     */
    private $key;

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * AtlasApiClient constructor.
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
        $params = [
            'base_uri' => 'http://atlas.atdw-online.com.au/api/atlas/'
        ];
        $this->client = new Client($params);
    }

    /**
     * @param $productId
     * @return mixed
     * @throws \Exception
     */
    public function getProduct($productId)
    {
        $response = $this->makeRequest(
            self::GET_PRODUCT_URL,
            [
                'productId' => $productId
            ]
        );
        return $response;
    }


    /**
     * Implements Atlas ATDW Regions API call
     * e.g. http://atlas.atdw-online.com.au/api/atlas/regions?key=[apiKey]&st=NSW
     *
     * @return mixed
     * @throws \Exception
     */
    public function getRegions()
    {
        $response = $this->makeRequest(
            self::REGIONS_URL,
            [
                'st' => 'NSW'
            ]
        );
        return $response;
    }

    public function getAreas()
    {
        $response = $this->makeRequest(self::AREAS_URL);
        return $response;
    }

    /**
     * Implements Atlas ATDW search API call
     * e.g. http://atlas.atdw-online.com.au/api/atlas/products?key=[apiKey]&servicear=DWN&servicerg=79000178
     *
     * @param string $region
     * @param string $area
     * @param integer $page
     * @return mixed
     * @throws \Exception
     */
    public function search($region = null, $area = null, $page = 1)
    {
        $response = $this->makeRequest(
            self::SEARCH_URL,
            [
                'size' => self::PAGE_SIZE,
                'servicerg' => !empty($region) ? $region : null,
                'servicear' => !empty($area) ? $area : null,
                'pge' => $page,
            ]
        );
        return $response;
    }


    /**
     * @param $uri
     * @param $params
     * @param string $method
     * @return mixed
     * @throws \Exception
     */
    private function makeRequest($uri, $params = [], $method = 'get')
    {
        $options = [
            'query' => [
                'key' => $this->key,
                'out' => 'json',
            ],
        ];

        if ($method == 'post') {
            $options = array_merge(['body' => json_encode($params)], $options);
        } else {
            $options['query'] = array_merge($options['query'], $params);
        }

        $res = $this->client->$method($uri, $options);

        if ($res->getStatusCode() !== 200) {
            $errorMsg =  sprintf("Response returned with status: %s", $res->getStatusCode());
            throw new \Exception($errorMsg);
        }

        return json_decode(
            mb_convert_encoding(
                $res->getBody()->getContents(),
                'UTF-8',
                'UTF-16LE'
            ),
            true
        );
    }
}