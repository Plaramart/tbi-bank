<?php

namespace Plaramart\TbiBank\Requests;

use Plaramart\TbiBank\Interfaces\TBIRequestContract;

class CreateOrderRequest extends TBIRequest implements TBIRequestContract
{

    public float  $total;
    public float  $initialPayment;
    public int    $months;
    public string $name;
    public int    $id;
    public string $address;
    public string $phone;
    public string $email;
    public array  $products;

    public function __construct (float $total, int $months, float $initialPayment)
    {
        $this->action = 'sendOrder';
        $this->method = 'POST';

        $this->total = $total;
        $this->months = $months;
        $this->initialPayment = $initialPayment;
        $this->products = [];
    }

    public function setUser (string $name, int $id, string $address, string $phone, string $email)
    {
        $this->name = $name;
        $this->id = $id;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function addProduct ($id, $name, $qty, $price)
    {
        $this->products += [
            'products_id'   => $id,
            'products_name' => $name,
            'products_q'    => $qty,
            'products_p'    => $price,
        ];
    }

    public function getRequestDataFormatted (): array
    {
        return [
            'name'             => (string)$this->name,
            'phone'            => (string)$this->phone,
            'email'            => (string)$this->email,
            'address_delivery' => (string)$this->address,
            'price'            => (string)$this->total,
            'insurance'        => 'n',
            'taksa'            => '0',
            'installment'      => '0',
            'gpr'              => '0',
            'egn'              => (string)$this->id,
            'address_id_card'  => 'address-document',
            'comment'          => '',
            'scheme'           => (string)$this->months,
            'initial_payment'  => (string)$this->initialPayment,
            'type_client'      => 'НАСТОЛЕН КОМПЮТЪР',
            'pisma'            => 'No',
            'items'            => $this->products,
        ];
    }
}