<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch\Benchmarks;

use Orangesoft\FuzzySearch\DamerauLevenshtein;

class DamerauLevenshteinBench
{
    private DamerauLevenshtein $damerauLevenshtein;

    public function __construct()
    {
        $this->damerauLevenshtein = new DamerauLevenshtein(
            insertionCost: 1,
            replacementCost: 1,
            deletionCost: 1,
            transpositionCost: 1,
        );
    }

    /**
     * @Revs(1000)
     * @Iterations(5)
     */
    public function benchDamerauLevenshtein(): void
    {
        $this->damerauLevenshtein->similar('carrrot', 'carrot');
    }
}
