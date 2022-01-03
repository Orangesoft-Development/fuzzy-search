<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

interface FuzzySearchInterface
{
    /**
     * @param string $needle
     * @param iterable $haystack
     * @param callable|null $accessor
     *
     * @return Suggestion[]
     */
    public function search(string $needle, iterable $haystack, callable $accessor = null): array;
}
