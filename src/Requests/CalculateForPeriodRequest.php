<?php

namespace Plaramart\TbiBank\Requests;

use Plaramart\TbiBank\Interfaces\TBIRequestContract;

class CalculateForPeriodRequest extends TBIRequest implements TBIRequestContract
{

    public int    $period;
    public float  $price;
    public float  $initialPayment;
    public int    $category;
    public string $insurance;

    public function __construct (float $price, int $period = 3, float $initialPayment = 0, int $category = 10, $insurance = 'n')
    {
        $this->action = 'getCalculation';
        $this->method = 'POST';

        $this->period = $period;
        $this->price = $price;
        $this->initialPayment = $initialPayment;
        $this->category = $category;
        $this->insurance = $insurance;
    }

    public function getRequestDataFormatted (): array
    {
        return [
            'price'            => (string)$this->price,
            'product_category' => (string)$this->category,
            'insurance'        => (string)$this->insurance,
            'scheme'           => (string)$this->period,
            'initial_payment'  => (string)$this->initialPayment,
        ];
    }
}