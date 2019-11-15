<?php

namespace App\Services;

use App\Services\TableToArrayService;

class PopularWordListService
{
    private $word_list_url = 'https://en.wikipedia.org/wiki/Most_common_words_in_English';

    public function returnPopularWordList()
    {
        $read_url_service = new ReadUrlService();
        $page_html = $read_url_service->returnContentFromUrl($this->word_list_url);

        if ($page_html == null) {
            return null;
        }

        $table_to_array =  new TableToArrayService();
        $word_list = $table_to_array->returnList($page_html);

        return $word_list;
    }
}
