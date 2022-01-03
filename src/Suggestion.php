<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

final class Suggestion
{
    public function __construct(
        public readonly float $similarity,
        public readonly mixed $data,
    ) {
    }
}
