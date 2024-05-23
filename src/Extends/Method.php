<?php namespace OnChainPay\Extends;

use OnChainPay\Instance;

class Method
{
    protected Instance $instance;

    public function __construct(Instance $instance)
    {
        $this->instance = $instance;
        return $this;
    }
}
