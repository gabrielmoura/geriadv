<?php

namespace App\Actions\Payment\PagHiper;

class Item
{

    /**
     * @var array
     */
    protected $item;

    /**
     *
     */
    public function __construct()
    {
        $this->item = [];
    }

    /**
     * @param string $description
     * @param int $price
     * @param $quantity
     * @param $id
     * @return $this
     */
    public function add(string $description, int $price, $quantity, $id=1)
    {
        $item = [
            'description' => $description,
            'quantity' => $quantity ?? 1,
            'item_id' => $id ?? 1,
            'price_cents' => $price
        ];
        array_push($this->item, $item);
        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->item;
    }

}
