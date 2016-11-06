<?php

/*
 * This file is part of the "elao/enum" package.
 *
 * Copyright (C) 2016 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Enum;

use Elao\Enum\Exception\InvalidValueException;

abstract class Enum implements EnumInterface
{
    /** @var mixed */
    protected $value;

    /**
     * The constructor is protected: use the static create method instead.
     *
     * @param mixed $value The raw value of an enumeration
     */
    protected function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return static A new instance of an enum
     */
    public static function create($value): EnumInterface
    {
        if (!static::accepts($value)) {
            throw new InvalidValueException($value, static::class);
        }

        return new static($value);
    }

    /**
     * {@inheritdoc}
     */
    public static function accepts($value): bool
    {
        return in_array($value, static::values(), true);
    }

    /**
     * {@inheritdoc}
     */
    public static function instances(): array
    {
        return array_map(function ($value) {
            return static::create($value);
        }, static::values());
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(EnumInterface $enum): bool
    {
        return get_class($this) === get_class($enum) && $this->value === $enum->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function is($value): bool
    {
        return $this->getValue() === $value;
    }
}