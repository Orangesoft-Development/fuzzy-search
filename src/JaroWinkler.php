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
        $similarity = $this->jaro->similar($a, $b);

        $aLength = strlen($a);
        $bLength = strlen($b);

        $min = min($aLength, $bLength);
        $max = max($aLength, $bLength);

        $lengthOfCommonPrefix = 0;

        for ($i = 0; $i < $min; $i++) {
            if ($a[$i] === $b[$i]) {
                $lengthOfCommonPrefix++;
            } else {
                break;
            }
        }

        return $similarity + (min(0.1, 1 / $max * $lengthOfCommonPrefix) * (1 - $similarity));
    }
}
