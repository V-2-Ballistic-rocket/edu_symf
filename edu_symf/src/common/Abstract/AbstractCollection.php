<?php

namespace App\common\Abstract;

use Traversable;

class AbstractCollection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    protected array $collection;

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->collection[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->collection[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if($offset === null) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->collection[$offset]);
    }

    public function count(): int
    {
        return count($this->collection);
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->collection);
    }
}