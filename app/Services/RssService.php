<?php

namespace App\Services;

use App\LastUpdated;
use GuzzleHttp\Client;
use App\Services\WordSortService;

class RssService
{
    public $updated;
    private $feed_url = 'https://www.theregister.co.uk/software/headlines.atom';

    public function returnRss()
    {
        $read_url_service = new ReadUrlService();
        $unsanitized_feed = $read_url_service->returnContentFromUrl($this->feed_url);

        if ($unsanitized_feed == null || !$this->wasChanged($unsanitized_feed)) {
            return null;
        }

        $sort_array = new WordSortService();
        $sorted_feed = $sort_array->returnSortedArray($unsanitized_feed);

        return $sorted_feed;
    }

    /**
     * Check if feed has been updated since last request
     *
     * @param string $feed RSS feed as string
     * @return boolean returns true or false
     */
    private function wasChanged($feed = null)
    {
        if ($feed == null) {
            return true;
        }

        $last_saved_update = LastUpdated::orderBy('id', 'DESC')->first();

        if (empty($last_saved_update)) {
            return true;
        }

        $feed = simplexml_load_string($feed);
        $this->updated = (string) $feed->updated;

        if ($last_saved_update->rss_updated == $this->updated) {
            return false;
        }

        return true;
    }
}
