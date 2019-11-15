<?php

namespace App\Factories;

use App\Services\PopularWordListService;
use App\Services\RssService;
use App\WordList;
use App\LastUpdated;
use \Carbon\Carbon;

class ListFacade
{
    private $list_from_feed;
    private $most_popular_names;
    private $feed_last_updated;

    public function returnWordList()
    {
        $cleared_list = $this->removePopularNamesFromFeed();

        if ($cleared_list == null) {
            return WordList::all()->take(10);
        }

        $this->insertListToDb($cleared_list);

        return WordList::all()->take(10);
    }

    /**
     * Get's the Rss list and popular word list to compare them and removes
     * the popular words from Rss list
     *
     *  @return array $spliced_list sorted and sanitized feed as array
     */
    private function removePopularNamesFromFeed()
    {
        $rss_service = new RssService();
        $this->list_from_feed = $rss_service->returnRss();
        if ($this->list_from_feed == null) {
            return null;
        }

        if ($rss_service->updated != null) {
            $this->feed_last_updated = $rss_service->updated;
        } else {
            $this->feed_last_updated = Carbon::now()->toDateTimeString();
        }

        $popular_word_service = new PopularWordListService();
        $this->most_popular_names = $popular_word_service->returnPopularWordList();
        if ($this->most_popular_names == null) {
            return null;
        }

        $list = array_diff_key($this->list_from_feed, $this->most_popular_names);
        $spliced_list = array_splice($list, 0, 10);

        return $spliced_list;
    }

    /**
     * Saves the sorted and sliced data to DB that later will be displayed for user
     */
    private function insertListToDb($spliced_list = null)
    {
        if ($spliced_list == null) {
            return null;
        }

        $list_to_db = [];
        $time = Carbon::now()->toDateTimeString();
        foreach ($spliced_list as $key => $count) {
            array_push($list_to_db, [
                'word' => $key,
                'count' => $count,
                'created_at' => $time,
                'updated_at' => $time
            ]);
        }

        WordList::truncate();
        WordList::insert(array_values($list_to_db));
        LastUpdated::insert([
            'rss_updated' => $this->feed_last_updated,
            'created_at' => $time,
            'updated_at' => $time
        ]);
    }
}
