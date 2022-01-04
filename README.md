# FuzzySearch

[![Build Status](https://img.shields.io/github/workflow/status/Orangesoft-Development/fuzzy-search/build/master?style=plastic)](https://github.com/Orangesoft-Development/fuzzy-search/actions/workflows/continuous-integration.yml)
[![Latest Stable Version](https://img.shields.io/packagist/v/orangesoft/fuzzy-search?style=plastic)](https://packagist.org/packages/orangesoft/fuzzy-search)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/orangesoft/fuzzy-search?style=plastic&color=8892BF)](https://packagist.org/packages/orangesoft/fuzzy-search)
[![Total Downloads](https://img.shields.io/packagist/dt/orangesoft/fuzzy-search?style=plastic)](https://packagist.org/packages/orangesoft/fuzzy-search)
[![License](https://img.shields.io/packagist/l/orangesoft/fuzzy-search?style=plastic&color=428F7E)](https://packagist.org/packages/orangesoft/fuzzy-search)

Fuzzy string search.

## Installation

You can install the latest version via [Composer](https://getcomposer.org/):

```text
composer require orangesoft/fuzzy-search
```

This package requires PHP 8.1 or later.

## Quick usage

Configure FuzzySearch with options:

```php
<?php

use Orangesoft\FuzzySearch\FuzzySearch;
use Orangesoft\FuzzySearch\JaroWinkler;
use Orangesoft\FuzzySearch\Suggestion;

$fuzzySearch = new FuzzySearch(
    algorithm: new JaroWinkler(),
    threshold: 0.7,
    limit: 5,
);

/** @var Suggestion[] $suggestions */
$suggestions = $fuzzySearch->search('carrrot', [
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
```

As a result, only one `carrot` clause with a similarity of `0.96` will be returned.

## Iterate elements

Pass any iterator as a haystack for performance optimization. If you need specific logic to extract the string from the elements of the iterator use accessor:

```php
/** @var Suggestion[] $suggestions */
$suggestions = $fuzzySearch->search(
    needle: 'carrrot',
    haystack: new \ArrayIterator(['apple', 'carrot', 'potato']),
    accessor: fn(string $data): string => $data,
);
```

Accessor must return string, but you can get original element of the iterator in [Suggestion](src/Suggestion.php).

## Benchmarks

Run `composer bench` to check out benchmarks:

```text
+-------------------------+------+-----+----------+----------+----------+---------+
| benchmark               | revs | its | mean     | best     | worst    | stdev   |
+-------------------------+------+-----+----------+----------+----------+---------+
| JaroBench               | 1000 | 5   | 4.287μs  | 4.074μs  | 4.658μs  | 0.201μs |
| JaroWinklerBench        | 1000 | 5   | 5.254μs  | 4.831μs  | 5.754μs  | 0.349μs |
| LevenshteinBench        | 1000 | 5   | 0.963μs  | 0.882μs  | 1.099μs  | 0.080μs |
| DamerauLevenshteinBench | 1000 | 5   | 21.544μs | 18.734μs | 24.855μs | 2.464μs |
| SimilarTextBench        | 1000 | 5   | 0.633μs  | 0.303μs  | 0.916μs  | 0.243μs |
+-------------------------+------+-----+----------+----------+----------+---------+
```

The following algorithms are available:

- [Jaro](src/Jaro.php)
- [JaroWinkler](src/JaroWinkler.php)
- [Levenshtein](src/Levenshtein.php)
- [DamerauLevenshtein](src/DamerauLevenshtein.php)
- [SimilarText](src/SimilarText.php)

Read more about approximate string matching on [Wikipedia](https://en.wikipedia.org/wiki/Approximate_string_matching).
