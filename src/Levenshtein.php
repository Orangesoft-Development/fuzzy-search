<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

use function Symfony\Component\String\u;

final class Levenshtein implements AlgorithmInterface
{
    /**
     * @param int $insertionCost
     * @param int $replacementCost
     * @param int $deletionCost
     * @param string[]|\Transliterator[]|\Closure[] $asciiUnicodeRules
     */
    public function __construct(
        private int $insertionCost = 1,
        private int $replacementCost = 1,
        private int $deletionCost = 1,
        private array $asciiUnicodeRules = [],
    ) {
    }

    public function similar(string $a, string $b): float
    {
        $a = u($a)->ascii($this->asciiUnicodeRules);
        $b = u($b)->ascii($this->asciiUnicodeRules);

        $levenshtein = levenshtein($a->toString(), $b->toString(), $this->insertionCost, $this->replacementCost, $this->deletionCost);

        $max = max($a->length(), $b->length());

        return 1 - $levenshtein / $max;
    }
}
