<?php

namespace Fukaeridesui\SuiRpcClient\Options;

abstract class BaseOptions
{
    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function toArray(): array
    {
        $vars = get_object_vars($this);
        return array_filter($vars, fn($v) => $v !== null);
    }
}
