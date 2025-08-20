<?php
use Kirby\Cms\Collection;

/**
 * @param Collection $pages    A Kirby pages collection to search in
 * @param array      $filters  An array of filter-keys (strings)
 * @return array               Up to 8 shuffled image URLs from matching children
 */
function filterAndProcess(Collection $pages, array $filters): array
{
    $filtered = $pages->filter(function ($child) use ($filters) {
        $childFilters = $child->filters()->split(', ');
        return count(array_intersect($filters, $childFilters)) > 0;
    });

    $urls = [];
    foreach ($filtered as $p) {
        foreach ($p->images() as $img) {
            $urls[] = $img->url();
        }
    }

    shuffle($urls);
    return array_slice($urls, 0, 8);
}