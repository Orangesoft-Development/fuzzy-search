<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

use function Symfony\Component\String\u;

final class FuzzySearch implements FuzzySearchInterface
{
    /**
     * @param AlgorithmInterface $algorithm
     * @param float $threshold
     * @param int $limit
     * @param string[]|\Transliterator[]|\Closure[] $rules
     */
    public function __construct(
        private AlgorithmInterface $algorithm,
        private float $threshold = 0.7,
        private int $limit = 5,
        private array $rules = [],
    ) {
    }

    /**
     * @param string $needle
     * @param iterable $haystack
     * @param callable|null $accessor
     *
     * @return Suggestion[]
     */
    public function search(string $needle, iterable $haystack, ?callable $accessor = null): array
    {
        $accessor ??= fn(string $data): string => $data;

        $suggestions = [];

        $a = u($needle)->ascii($this->rules)->toString();

        foreach ($haystack as $data) {
            $b = u($accessor($data))->ascii($this->rules)->toString();

            $similarity = $this->algorithm->similar($a, $b);

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
