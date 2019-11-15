<?php

namespace App\Services;

use App\LastUpdated;
use GuzzleHttp\Client;
use App\Services\WordSortService;
use App\Services\HasChangedService;

class RssService
{
    public $updated;
    private $feed_url = 'https://www.theregister.co.uk/software/headlines.atom';

    public function returnRss()
    {
        $read_url_service = new ReadUrlService();
        $unsanitized_feed = $read_url_service->returnContentFromUrl($this->feed_url);

        $changed_service = new HasChangedService();

        if ($unsanitized_feed == null || !$changed_service->hasFeedChanged($unsanitized_feed)) {
            return null;
        }

        $sort_array = new WordSortService();
        $sorted_feed = $sort_array->returnSortedArray($unsanitized_feed);

        return $sorted_feed;
    }
}
