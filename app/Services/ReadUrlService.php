<?php

namespace App\Services;

use GuzzleHttp\Client;

class ReadUrlService
{
    /**
     * Makes a request to passed in url and returns the body content as string
     *
     * @return string $content most common word list page as string
     */
    public function returnContentFromUrl($feed_url = null)
    {
        if ($feed_url == null) {
            return null;
        }

        try {
            $client = new Client();
            $response = $client->request('GET', $feed_url, ['verify' => false]);
            $content = $response->getBody()->getContents();
        } catch (\Exception $e) {
            $content = null;
        }

        return $content;
    }

}
