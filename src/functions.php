<?php declare(strict_types=1);

namespace Biera;

use ArrayAccess;
use InvalidArgumentException;
use RuntimeException;

/**
 * @param ArrayAccess|array $graph
 * @param array $path
 * @return array|mixed
 */
function retrieveByPath($graph, array $path)
{
    if (!implementsArrayAccess($graph)) {
        throw new InvalidArgumentException(
            'Parameter "graph" must be of array|\ArrayAccess type'
        );
    }

    $current = $graph;

    foreach ($path as $pathSegment) {
        $pathSegment = urldecode($pathSegment);

        if (!(implementsArrayAccess($current) && array_key_exists($pathSegment, $current))) {
            throw new RuntimeException(
                sprintf('Path "%s" does not exist', join(' -> ', $path))
            );
        }

        $current = $current[$pathSegment];
    }

    return $current;
}

/**
 * @param string|int $needle
 * @param array|ArrayAccess $haystack
 * @return bool
 */
function array_key_exists($needle, $haystack): bool
{
    return $haystack instanceof ArrayAccess
        ? isset($haystack[$needle])
        : \array_key_exists($needle, $haystack);
}

function pathSegments(string $path, string $segmentSeparator = DIRECTORY_SEPARATOR): array
{
    return array_values(
        array_filter(
            explode($segmentSeparator, $path), fn ($pathSegment) => '' !== $pathSegment
        )
    );
}

function implementsArrayAccess($value): bool
{
    return is_array($value) || $value instanceof ArrayAccess;
}
