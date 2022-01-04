<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch\Tests;

use Orangesoft\FuzzySearch\SimilarText;
use PHPUnit\Framework\TestCase;

class SimilarTextTest extends TestCase
{
    /**
     * @dataProvider similarTextDataset
     */
    public function testSimilar(string $a, string $b, float $expectedSimilarity): void
    {
        $similarText = new SimilarText();

        $similarity = $similarText->similar($a, $b);

        $this->assertEquals($expectedSimilarity, round($similarity, 2));
    }

    public function similarTextDataset(): array
    {
        return [
            ['carrrot', 'apple',     0.17],
            ['carrrot', 'pineapple', 0.13],
            ['carrrot', 'banana',    0.15],
            ['carrrot', 'orange',    0.15],
            ['carrrot', 'radish',    0.15],
            ['carrrot', 'carrot',    0.92],
            ['carrrot', 'pea',       0.20],
            ['carrrot', 'bean',      0.18],
            ['carrrot', 'potato',    0.31],
        ];
    }
}
