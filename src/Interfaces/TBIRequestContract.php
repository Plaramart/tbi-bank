<?php

namespace Plaramart\TbiBank\Interfaces;

interface TBIRequestContract {
    public function getRequestDataFormatted (): array;

    public function getMethod (): string;

    public function getAction (): string;
}