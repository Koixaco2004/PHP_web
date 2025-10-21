<?php

if (!function_exists('highlightSearchTerm')) {
    /**
     * Highlight search term in text
     *
     * @param string $text
     * @param string $searchTerm
     * @return string
     */
    function highlightSearchTerm($text, $searchTerm)
    {
        if (empty($searchTerm)) {
            return $text;
        }
        
        return preg_replace(
            '/(' . preg_quote($searchTerm, '/') . ')/i',
            '<mark class="bg-yellow-200 px-1 rounded">$1</mark>',
            $text
        );
    }
}