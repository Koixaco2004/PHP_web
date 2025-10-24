<?php

use Illuminate\Support\Str;

if (!function_exists('highlightSearchTerm')) {
    /**
     * Highlight search terms in text.
     */
    function highlightSearchTerm($text, $term)
    {
        if (!$term || empty(trim($term))) {
            return $text;
        }

        $terms = array_filter(explode(' ', trim($term)));
        $highlightedText = $text;

        foreach ($terms as $searchTerm) {
            $searchTerm = trim($searchTerm);
            if (strlen($searchTerm) > 1) {
                $highlightedText = preg_replace(
                    '/(' . preg_quote($searchTerm, '/') . ')/i',
                    '<mark class="bg-yellow-200 text-secondary-900 px-1 rounded">$1</mark>',
                    $highlightedText
                );
            }
        }

        return $highlightedText;
    }
}

if (!function_exists('formatSearchResults')) {
    /**
     * Format search results with proper highlighting.
     */
    function formatSearchResults($posts, $query)
    {
        if (method_exists($posts, 'getCollection')) {
            $collection = $posts->getCollection();
            $formattedCollection = $collection->map(function ($post) use ($query) {
                $post->highlighted_title = highlightSearchTerm($post->title, $query);
                $post->highlighted_excerpt = highlightSearchTerm($post->excerpt ?? Str::limit(strip_tags($post->content_html), 150), $query);
                return $post;
            });

            $posts->setCollection($formattedCollection);
            return $posts;
        }

        return $posts->map(function ($post) use ($query) {
            $post->highlighted_title = highlightSearchTerm($post->title, $query);
            $post->highlighted_excerpt = highlightSearchTerm($post->excerpt ?? Str::limit(strip_tags($post->content_html), 150), $query);
            return $post;
        });
    }
}
