<?php declare(strict_types=1);

namespace Biera;

trait ArrayAccessor
{
    private static $reflectedProperties;

    private function getReflectedProperties(): array
    {
        if (is_null(self::$reflectedProperties)) {
            self::$reflectedProperties = $this->filterProperties(
                array_map(
                    function(\ReflectionProperty $property) {
                        return $property->getName();
                    },
                    (new \ReflectionClass($this))
                        ->getProperties()
                )
            );
        }

        return self::$reflectedProperties;
    }

    private function filterProperties(array $properties): array
    {
        return $properties;
    }

    private function retrieve(string $path)
    {
        return retrieveByPath(
            $this, pathSegments($path)
        );
    }

    public function offsetExists($offset)
    {
        return \in_array(
            $offset, $this->getReflectedProperties()
        );
    }

    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    public function offsetSet($offset, $value)
    {
        throw new \LogicException('Read only');
    }

    public function offsetUnset($offset)
    {
        throw new \LogicException('Read only');
    }
}
