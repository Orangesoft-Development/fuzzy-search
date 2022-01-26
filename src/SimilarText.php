<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

use function Symfony\Component\String\u;

final class SimilarText implements AlgorithmInterface
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

        similar_text($a->toString(), $b->toString(), $percent);

        return $percent / 100;
    }
}
