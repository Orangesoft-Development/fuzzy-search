<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

final class Jaro implements AlgorithmInterface
{
    public function similar(string $a, string $b): float
    {
        $aLength = grapheme_strlen($a);
        $bLength = grapheme_strlen($b);

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

                if ($a[$i] !== $b[$k]) {
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

            if ($a[$i] !== $b[$k]) {
                $transpositions++;
            }

            $k++;
        }

        $similarCost = array_sum([
            $matches / $aLength,
            $matches / $bLength,
            ($matches - $transpositions / 2) / $matches,
        ]);

        return $similarCost / 3;
    }
}
