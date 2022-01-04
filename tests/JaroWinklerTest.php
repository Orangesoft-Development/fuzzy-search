<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch\Tests;

use Orangesoft\FuzzySearch\JaroWinkler;
use PHPUnit\Framework\TestCase;

class JaroWinklerTest extends TestCase
{
    /**
     * @dataProvider jaroWinklerDataset
     */
    public function testSimilar(string $a, string $b, float $expectedSimilarity): void
    {
        $jaro = new JaroWinkler();

        $similarity = $jaro->similar($a, $b);

        $this->assertEquals($expectedSimilarity, round($similarity, 2));
    }

    public function jaroWinklerDataset(): array
    {
        return [
            ['carrrot', 'apple',     0.45],
            ['carrrot', 'pineapple', 0.42],
            ['carrrot', 'banana',    0.44],
            ['carrrot', 'orange',    0.37],
            ['carrrot', 'radish',    0.37],
            ['carrrot', 'carrot',    0.96],
            ['carrrot', 'pea',       0.49],
            ['carrrot', 'bean',      0.46],
            ['carrrot', 'potato',    0.53],
        ];
    }
}
