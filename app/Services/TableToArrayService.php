<?php

namespace App\Services;

use KubAT\PhpSimple\HtmlDomParser;

class TableToArrayService
{
    /**
     * Takes wiki page content as string and converts it's table into list
     *
     * @param string $content Wikipedia page as string
     * 
     * @return array $word_list Top50 words from table
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
