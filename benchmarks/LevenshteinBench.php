<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch\Benchmarks;

use Orangesoft\FuzzySearch\Levenshtein;

class LevenshteinBench
{
    private Levenshtein $levenshtein;

    public function __construct()
    {
        $this->levenshtein = new Levenshtein(
            insertionCost: 1,
            replacementCost: 1,
            deletionCost: 1,
        );
    }

    /**
     * @Revs(1000)
     * @Iterations(5)
     */
    public function benchLevenshtein(): void
    {
        $this->levenshtein->similar('carrrot', 'carrot');
    }
}
