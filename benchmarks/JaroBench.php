<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch\Benchmarks;

use Orangesoft\FuzzySearch\Jaro;

class JaroBench
{
    private Jaro $jaro;

    public function __construct()
    {
        $this->jaro = new Jaro();
    }

    /**
     * @Revs(1000)
     * @Iterations(5)
     */
    public function benchJaro(): void
    {
        $this->jaro->similar('carrrot', 'carrot');
    }
}
