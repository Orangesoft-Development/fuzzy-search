<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch\Benchmarks;

use Orangesoft\FuzzySearch\JaroWinkler;

class JaroWinklerBench
{
    private JaroWinkler $jaroWinkler;

    public function __construct()
    {
        $this->jaroWinkler = new JaroWinkler();
    }

    /**
     * @Revs(1000)
     * @Iterations(5)
     */
    public function benchJaroWinkler(): void
    {
        $this->jaroWinkler->similar('carrrot', 'carrot');
    }
}
