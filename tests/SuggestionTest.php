<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch\Tests;

use Orangesoft\FuzzySearch\Suggestion;
use PHPUnit\Framework\TestCase;

class SuggestionTest extends TestCase
{
    public function testSuggestion(): void
    {
        $suggestion = new Suggestion(0.7, 'carrot');

        $this->assertEquals(0.7, $suggestion->similarity);
        $this->assertSame('carrot', $suggestion->data);
    }
}
