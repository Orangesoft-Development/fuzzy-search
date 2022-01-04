<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch\Tests;

use Orangesoft\FuzzySearch\DamerauLevenshtein;
use PHPUnit\Framework\TestCase;

class DamerauLevenshteinTest extends TestCase
{
    /**
     * @dataProvider damerauLevenshteinDataset
     */
    public function testSimilar(string $a, string $b, float $expectedSimilarity): void
    {
        $damerauLevenshtein = new DamerauLevenshtein(
            insertionCost: 1,
            replacementCost: 1,
            deletionCost: 1,
            transpositionCost: 1,
        );

        $similarity = $damerauLevenshtein->similar($a, $b);

        $this->assertEquals($expectedSimilarity, round($similarity, 2));
    }

    public function damerauLevenshteinDataset(): array
    {
        return [
            ['carrrot', 'apple',     0.14],
            ['carrrot', 'pineapple', 0.00],
            ['carrrot', 'banana',    0.14],
            ['carrrot', 'orange',    0.14],
            ['carrrot', 'radish',    0.14],
            ['carrrot', 'carrot',    0.86],
            ['carrrot', 'pea',       0.00],
            ['carrrot', 'bean',      0.00],
            ['carrrot', 'potato',    0.14],
        ];
    }
}
