<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

use function Symfony\Component\String\u;

final class Jaro implements AlgorithmInterface
{
    /**
     * @param string[]|\Transliterator[]|\Closure[] $asciiUnicodeRules
     */
    public function __construct(
        private array $asciiUnicodeRules = [],
    ) {
    }

    public function similar(string $a, string $b): float
    {
        $a = u($a)->ascii($this->asciiUnicodeRules);
        $b = u($b)->ascii($this->asciiUnicodeRules);

        $aAsciiString = $a->toString();
        $bAsciiString = $b->toString();

        $aLength = $a->length();
        $bLength = $b->length();

        $distance = max($aLength, $bLength) / 2 - 1;

        $matrix = [
            array_fill(0, $aLength, 0),
            array_fill(0, $bLength, 0),
        ];

        $matches = 0;
        $transpositions = 0;

        for ($i = 0; $i < $aLength; $i++) {
            $start = (int) max(0, $i - $distance);
            $end = (int) min($i + $distance + 1, $bLength);

            for ($k = $start; $k < $end; $k++) {
                if ($matrix[1][$k]) {
                    continue;
                }

                if ($aAsciiString[$i] !== $bAsciiString[$k]) {
                    continue;
                }

                $matrix[0][$i] = 1;
                $matrix[1][$k] = 1;

                $matches++;

                break;
            }
        }

        if (0 === $matches) {
            return 0;
        }

        $k = 0;

        for ($i = 0; $i < $aLength; $i++) {
            if (!$matrix[0][$i]) {
                continue;
            }

            while (!$matrix[1][$k]) {
                $k++;
            }

            if ($aAsciiString[$i] !== $bAsciiString[$k]) {
                $transpositions++;
            }

            $k++;
        }

        return (($matches / $aLength) + ($matches / $bLength) + (($matches - $transpositions / 2) / $matches)) / 3;
    }
}
