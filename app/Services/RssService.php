<?php

namespace App\Services;

use App\LastUpdated;
use GuzzleHttp\Client;

class RssService
{
    public $updated;
    private $feed_url = 'https://www.theregister.co.uk/software/headlines.atom';

    public function returnRss()
    {
        $rss_feed = $this->prepareFeed();
        return $rss_feed;
    }

    /**
     * Prepares feed for returnRss function
     *
     * @return array $sorted_feed array with words as keys and occurrence as value
     */
    private function prepareFeed()
    {
        $read_url_service = new ReadUrlService();
        $unsanitized_feed = $read_url_service->returnContentFromUrl($this->feed_url);

        if ($unsanitized_feed == null || !$this->wasChanged($unsanitized_feed)) {
            return null;
        }

        $sorted_feed = $this->sanitizeAndSortFeed($unsanitized_feed);
        return $sorted_feed;
    }

    /**
     * Sanitizes and sorts the given string
     *
     * @param string $unsanitized_feed Unsanitized rss feed
     * @return array $sanitized_feed sorted and sanitized feed as array
     */
    private function sanitizeAndSortFeed($unsanitized_feed = null)
    {
        $sanitized_feed = preg_replace('/(?=[^ ]*[^A-Za-z \'-])([^ ]*)(?:\\s+|$)/', '', $unsanitized_feed);
        $sanitized_feed = strtolower($sanitized_feed);

        $sorted_feed = array_count_values(str_word_count($sanitized_feed, 1));
        arsort($sorted_feed);

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
