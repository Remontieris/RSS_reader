<?php

namespace App\Services;

class WordSortService
{
    /**
     * Sanitizes and sorts the given string
     *
     * @param string $unsorted_feed Unsanitized rss feed
     * @return array $sanitized_feed sorted and sanitized feed as array
     */
    public function returnSortedArray($unsorted_feed = null)
    {
        $sanitized_feed = preg_replace('/(?=[^ ]*[^A-Za-z \'-])([^ ]*)(?:\\s+|$)/', '', $unsorted_feed);
        $sanitized_feed = strtolower($sanitized_feed);

        $sorted_feed = array_count_values(str_word_count($sanitized_feed, 1));
        arsort($sorted_feed);

        return $sorted_feed;
    }

}
