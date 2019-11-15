<?php

namespace App\Services;

use KubAT\PhpSimple\HtmlDomParser;
use GuzzleHttp\Client;
use App\Services\ReadUrlService;

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

        $word_list = array_flip($this->parseListToArray($page_html));

        return $word_list;
    }


    /**
     * Generates array of top 50 most popular words in english from wikipedia
     *
     * @param string $page_html Wikipedia page as string
     * @return array $sanitized_feed sorted and sanitized feed as array
     */
    private function parseListToArray($page_html)
    {
        $html = HtmlDomParser::str_get_html($page_html);
        $word_list = [];
        $i = 0;

        foreach ($html->find('a[class=extiw]') as $key => $row) {
            if ($i == 50) {
                break;
            }
            array_push($word_list, $row->plaintext);
            $i++;
        }

        return $word_list;
    }
}
