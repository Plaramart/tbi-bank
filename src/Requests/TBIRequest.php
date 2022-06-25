<?php

namespace Plaramart\TbiBank\Requests;

abstract class TBIRequest {

    protected string $action;
    protected string $method;

    public function getAction (): string
    {
        return $this->action;
    }

    public function getMethod (): string
    {
        return $this->method;
    }
}