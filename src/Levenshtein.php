<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

final class Levenshtein implements AlgorithmInterface
{
    public function __construct(
        private int $insertionCost = 1,
        private int $replacementCost = 1,
        private int $deletionCost = 1,
    ) {
    }

    public function similar(string $a, string $b): float
    {
        $levenshtein = levenshtein($a, $b, $this->insertionCost, $this->replacementCost, $this->deletionCost);

        $aLength = strlen($a);
        $bLength = strlen($b);

        $max = max($aLength, $bLength);

        return 1 - $levenshtein / $max;
    }
}
