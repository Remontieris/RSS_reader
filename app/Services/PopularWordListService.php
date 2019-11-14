<?php

namespace App\Services;

use KubAT\PhpSimple\HtmlDomParser;

class PopularWordListService
{
    public function returnPopularWordList()
    {
        $page_html = $this->getListAsHtml();

        if ($page_html == null) {
            return null;
        }

        $word_list = array_flip($this->parseListToArray($page_html));

        return $word_list;
    }

    /**
     * Requests most commot word list page from Wikipedia API and return
     * the page content as string
     *
     * @return string $list_as_html most common word list page as string
     */
    private function getListAsHtml()
    {
        $feed_url = 'https://en.wikipedia.org/w/api.php?action=parse&page=Most_common_words_in_English&format=json';
        $raw_feed = file_get_contents($feed_url);
        $feed = json_decode($raw_feed);

        if (!empty($feed->error)) {
            return null;
        }

        $feed_array = (array) $feed->parse->text;
        $list_as_html = strtolower($feed_array['*']);

        return $list_as_html;
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
