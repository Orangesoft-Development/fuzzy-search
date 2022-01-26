<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

use function Symfony\Component\String\u;

final class DamerauLevenshtein implements AlgorithmInterface
{
    /**
     * @param int $insertionCost
     * @param int $replacementCost
     * @param int $deletionCost
     * @param int $transpositionCost
     * @param string[]|\Transliterator[]|\Closure[] $asciiUnicodeRules
     */
    public function __construct(
        private int $insertionCost = 1,
        private int $replacementCost = 1,
        private int $deletionCost = 1,
        private int $transpositionCost = 1,
        private array $asciiUnicodeRules = [],
    ) {
    }

    public function similar(string $a, string $b): float
    {
        $a = u($a)->ascii($this->asciiUnicodeRules);
        $b = u($b)->ascii($this->asciiUnicodeRules);

        $aLength = $a->length();
        $bLength = $b->length();

        $matrix = [];

        for ($i = 0; $i <= $bLength; $i++) {
            $matrix[0][$i] = $i > 0 ? $matrix[0][$i - 1] + $this->insertionCost : 0;
        }

        for ($i = 0; $i <= $aLength; $i++) {
            $matrix[$i][0] = $i > 0 ? $matrix[$i - 1][0] + $this->deletionCost : 0;
        }

        for ($i = 1; $i <= $aLength; $i++) {
            $aChar = $a->slice($i - 1, 1)->toString();

            for ($j = 1; $j <= $bLength; $j++) {
                $bChar = $b->slice($j - 1, 1)->toString();

                if (0 === strcmp($aChar, $bChar)) {
                    $replacementCost = 0;
                    $transpositionCost = 0;
                } else {
                    $replacementCost = $this->replacementCost;
                    $transpositionCost = $this->transpositionCost;
                }

                $insertionCost = $matrix[$i][$j - 1] + $this->insertionCost;
                $replacementCost = $matrix[$i - 1][$j - 1] + $replacementCost;
                $deletionCost = $matrix[$i - 1][$j] + $this->deletionCost;

                $matrix[$i][$j] = min($insertionCost, $replacementCost, $deletionCost);

                if (1 < $i && 1 < $j) {
                    $aNextChar = $a->slice($i - 2, 1)->toString();
                    $bNextChar = $b->slice($j - 2, 1)->toString();

                    if (0 === strcmp($aChar, $bNextChar) && 0 === strcmp($aNextChar, $bChar)) {
                        $matrix[$i][$j] = min($matrix[$i][$j], $matrix[$i - 2][$j - 2] + $transpositionCost);
                    }
                }
            }
        }

        $min = min($aLength, $bLength);
        $max = max($aLength, $bLength);

        $operationPerformance = min($this->insertionCost + $this->deletionCost, $this->replacementCost);
        $operationCost = $aLength < $bLength ? $this->insertionCost : $this->deletionCost;

        $distance = ($operationPerformance * $min) + (($max - $min) * $operationCost);

        return 1 - $matrix[$aLength][$bLength] / $distance;
    }
}
