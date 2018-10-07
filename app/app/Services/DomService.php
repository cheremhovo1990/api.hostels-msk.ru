<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo1990
 * Date: 25.09.18
 * Time: 19:53
 */

namespace App\Services;


class DomService
{
    /**
     * @param string $response
     * @return \DOMXPath
     */
    public function createXpath(string $response): \DOMXPath
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->resolveExternals = false;
        $dom->validateOnParse = true;
        $dom->loadHTML($response);
        $xpath = new \DOMXPath($dom);
        return $xpath;
    }
}