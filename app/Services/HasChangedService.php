<?php

namespace App\Services;

use App\LastUpdated;

class HasChangedService
{
 /**
     * Check if feed has been updated since last request
     *
     * @param string $feed RSS feed as string
     * @return boolean returns true or false
     */
    public function hasFeedChanged($feed = null)
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
