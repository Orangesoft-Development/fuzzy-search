<?php

declare(strict_types=1);

namespace Orangesoft\FuzzySearch;

final class JaroWinkler implements AlgorithmInterface
{
    private Jaro $jaro;

    public function __construct()
    {
        $this->jaro = new Jaro();
    }

    public function similar(string $a, string $b): float
    {
        $aLength = grapheme_strlen($a);
        $bLength = grapheme_strlen($b);

        $similarity = $this->jaro->similar($a, $b);

        $min = min($aLength, $bLength);
        $max = max($aLength, $bLength);

        $commonPrefixLength = 0;

        for ($i = 0; $i < $min; $i++) {
            if ($a[$i] === $b[$i]) {
                $commonPrefixLength++;
            } else {
                break;
            }
        }

        return $similarity + (min(0.1, 1 / $max * $commonPrefixLength) * (1 - $similarity));
    }
}
