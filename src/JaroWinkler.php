<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

use function Symfony\Component\String\u;

final class JaroWinkler implements AlgorithmInterface
{
    private Jaro $jaro;

    /**
     * @param string[]|\Transliterator[]|\Closure[] $asciiUnicodeRules
     */
    public function __construct(
        private array $asciiUnicodeRules = [],
    ) {
        $this->jaro = new Jaro($this->asciiUnicodeRules);
    }

    public function similar(string $a, string $b): float
    {
        $a = u($a)->ascii($this->asciiUnicodeRules);
        $b = u($b)->ascii($this->asciiUnicodeRules);

        $aAsciiString = $a->toString();
        $bAsciiString = $b->toString();

        $aLength = $a->length();
        $bLength = $b->length();

        $similarity = $this->jaro->similar($aAsciiString, $bAsciiString);

        $min = min($aLength, $bLength);
        $max = max($aLength, $bLength);

        $lengthOfCommonPrefix = 0;

        for ($i = 0; $i < $min; $i++) {
            if ($aAsciiString[$i] === $bAsciiString[$i]) {
                $lengthOfCommonPrefix++;
            } else {
                break;
            }
        }

        return $similarity + (min(0.1, 1 / $max * $lengthOfCommonPrefix) * (1 - $similarity));
    }
}
