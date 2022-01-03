<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

final class FuzzySearch implements FuzzySearchInterface
{
    public function __construct(
        private AlgorithmInterface $algorithm,
        private float $threshold = 0.7,
        private int $limit = 5,
    ) {
    }

    /**
     * @param string $needle
     * @param iterable $haystack
     * @param callable|null $accessor
     *
     * @return Suggestion[]
     */
    public function search(string $needle, iterable $haystack, callable $accessor = null): array
    {
        $accessor ??= fn(string $data): string => $data;

        $suggestions = [];

        foreach ($haystack as $data) {
            $similarity = $this->algorithm->similar($needle, $accessor($data));

            if ($this->threshold <= $similarity) {
                $suggestions[] = new Suggestion($similarity, $data);

                uasort($suggestions, fn(Suggestion $a, Suggestion $b): int => $a->similarity <=> $b->similarity);

                if ($this->limit < count($suggestions)) {
                    $suggestions = array_slice($suggestions, 0, $this->limit);
                }
            }
        }

        return $suggestions;
    }
}
