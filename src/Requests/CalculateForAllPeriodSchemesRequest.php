<?php

namespace Plaramart\TbiBank\Requests;

use Plaramart\TbiBank\Interfaces\TBIRequestContract;

class CalculateForAllPeriodSchemesRequest extends TBIRequest implements TBIRequestContract
{

    public int    $period;
    public float  $price;
    public float  $initialPayment;
    public int    $category;
    public string $insurance;

    public function __construct (float $price, float $initialPayment = 0, int $category = 10, $insurance = 'n')
    {
        $this->action = 'getCalculationForAllSchemes';
        $this->method = 'POST';

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
            'initial_payment'  => (string)$this->initialPayment,
        ];
    }
}