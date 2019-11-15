<?php

namespace App\Services;

use KubAT\PhpSimple\HtmlDomParser;

class TableToArrayService
{
    /**
     * Makes a request to passed in url and returns the body content as string
     *
     * @return string $content most common word list page as string
     */
    public function returnList($content = null)
    {
        $html = HtmlDomParser::str_get_html($content);
        $word_list = [];
        $i = 0;

        foreach ($html->find('a[class=extiw]') as $key => $row) {
            if ($i == 50) {
                break;
            }
            array_push($word_list, $row->plaintext);
            $i++;
        }

        return array_flip($word_list);
    }

}
