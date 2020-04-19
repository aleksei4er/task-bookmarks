<?php

namespace Aleksei4er\TaskBookmarks;

use DOMDocument;
use Illuminate\Support\Facades\Http;

class TaskBookmarks
{
    /**
     * Get data for bookmark
     *
     * @param string $url
     * @return array
     * 
     */
    public function getData(string $url): array
    {
        $response = Http::get($url);

        $domDocument = new DOMDocument();
        @$domDocument->loadHTML($response->body());

        $titleTags = $domDocument->getElementsByTagName('title');

        $data = ['title' => optional($titleTags->item(0))->nodeValue];

        $data += $this->getTagAttributes($domDocument, 'meta', [
            'description' => [
                'name' => 'name',
                'index' => 'description'
            ],
            'keywords' => [
                'name' => 'name',
                'index' => 'keywords'
            ],
        ], 'content');

        $data += $this->getTagAttributes($domDocument, 'link', [
            'icon' => [
                'name' => 'rel',
                'index' => 'favicon'
            ],
        ], 'href');

        $urlInfo = parse_url($url);
        if (!empty($data['favicon']) && strpos($data['favicon'], 'http') === false) {
            $data['favicon'] = $urlInfo['scheme'] . '://' . $urlInfo['host'] . $data['favicon'];
        }

        return $data;
    }

    /**
     * Get attributes from DOMDocument object
     *
     * @param DOMDocument $domDocument
     * @param string $tagName
     * @param array $targetAttributes
     * @param string $neededAttributeName
     * @return array
     */
    private function getTagAttributes(
        DOMDocument $domDocument,
        string $tagName,
        array $targetAttributes,
        string $neededAttributeName
    ): array {
        $tags = $domDocument->getElementsByTagName($tagName);
        for ($i = 0; $i < $tags->length; $i++) {
            $tag = $tags->item($i);
            foreach ($targetAttributes as $attributeValue => $attribute) {
                if (strpos($tag->getAttribute($attribute['name']), $attributeValue) !== false) {
                    $attributes[$attribute['index']] = $tag->getAttribute($neededAttributeName);
                }
            }
        }

        return $attributes ?? [];
    }
}
