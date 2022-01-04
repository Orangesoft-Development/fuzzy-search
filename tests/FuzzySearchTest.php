<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch\Tests;

use Orangesoft\FuzzySearch\FuzzySearch;
use Orangesoft\FuzzySearch\JaroWinkler;
use PHPUnit\Framework\TestCase;

class FuzzySearchTest extends TestCase
{
    public function testSearch(): void
    {
        $fuzzySearch = new FuzzySearch(
            algorithm: new JaroWinkler(),
            threshold: 0.7,
            limit: 5,
        );

        $haystack = new \ArrayIterator([
            'apple',
            'pineapple',
            'banana',
            'orange',
            'radish',
            'carrot',
            'pea',
            'bean',
            'potato',
        ]);

        $suggestions = $fuzzySearch->search(
            needle: 'carrrot',
            haystack: $haystack,
            accessor: fn(string $data): string => $data,
        );

        $this->assertCount(1, $suggestions);
        $this->assertEquals(0.96, round($suggestions[0]->similarity, 2));
        $this->assertSame('carrot', $suggestions[0]->data);
    }
}
