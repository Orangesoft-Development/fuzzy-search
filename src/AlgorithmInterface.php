<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

interface AlgorithmInterface
{
    public function similar(string $a, string $b): float;
}
