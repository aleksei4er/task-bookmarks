<?php

namespace Aleksei4er\TaskBookmarks;

use DOMDocument;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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

        $data = ['title' => Str::limit(optional($titleTags->item(0))->nodeValue, 255)];

        $data += $this->getTagAttributes($domDocument, 'meta', [
            'description' => [
                'name' => 'name',
                'index' => 'description',
                'limit' => 255,
            ],
            'keywords' => [
                'name' => 'name',
                'index' => 'keywords',
                'limit' => 255,
            ],
        ], 'content');

        $data += $this->getTagAttributes($domDocument, 'link', [
            'icon' => [
                'name' => 'rel',
                'index' => 'favicon',
                'limit' => 255,
            ],
            'shortcut icon' => [
                'name' => 'rel',
                'index' => 'favicon',
                'limit' => 255,
            ],
        ], 'href');

        $urlInfo = parse_url($url);
        if (!empty($data['favicon']) && strpos($data['favicon'], 'http') !== 0) {
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
                if ($tag->getAttribute($attribute['name']) == $attributeValue) {
                    $attributes[$attribute['index']] = Str::limit($tag->getAttribute($neededAttributeName), $attribute['limit']);
                }
            }
        }

        return $attributes ?? [];
    }
}
