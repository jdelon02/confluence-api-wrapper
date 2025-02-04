<?php

namespace jdelon02\ConfluenceApiWrapper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ConfluenceApiClient {
  protected $client;
  protected $baseUri;
  protected $authToken;
  protected $cache;

  public function __construct($baseUri, $email, $apiToken, $cache = null) {
    $this->client = new Client();
    $this->baseUri = rtrim($baseUri, '/');
    $this->authToken = base64_encode("$email:$apiToken");
    $this->cache = $cache;
  }

  public function getSpaceContent($spaceKey, $limit = 25, $start = 0) {
    $cacheKey = "confluence_space_content_{$spaceKey}_{$start}_{$limit}";
    if ($this->cache && $cachedData = $this->cache->get($cacheKey)) {
      return $cachedData;
    }

    $url = $this->baseUri . '/rest/api/content?spaceKey=' . $spaceKey . "&limit=$limit&start=$start";
    try {
      $response = $this->client->get($url, [
        'headers' => [
          'Authorization' => 'Basic ' . $this->authToken,
          'Accept' => 'application/json',
        ],
      ]);
      $data = json_decode($response->getBody(), true);

      if ($this->cache) {
        $this->cache->set($cacheKey, $data);
      }

      return $data;
    } catch (RequestException $e) {
      throw new \Exception('Error fetching Confluence content: ' . $e->getMessage());
    }
  }
}
