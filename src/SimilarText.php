<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

final class SimilarText implements AlgorithmInterface
{
    public function similar(string $a, string $b): float
    {
        similar_text($a, $b, $percent);

        return $percent / 100;
    }
}
