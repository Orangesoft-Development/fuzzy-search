<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch\Benchmarks;

use Orangesoft\FuzzySearch\SimilarText;

class SimilarTextBench
{
    private SimilarText $similarText;

    public function __construct()
    {
        $this->similarText = new SimilarText();
    }

    /**
     * @Revs(1000)
     * @Iterations(5)
     */
    public function benchSimilarText(): void
    {
        $this->similarText->similar('carrrot', 'carrot');
    }
}
