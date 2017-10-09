<?php

class Item {

    private $itemType;
    private $product;
    private $quantity;
    private $totalValue;
    private $iv;

    public function __construct($itemType, $product, $quantity, $totalValue) {
        $this->iv = new ItemValidator();
        
        $this->itemType = $itemType;
        $this->setProduct($product);
        $this->setQuantity($quantity);
        $this->setTotalValue($totalValue);
    }

    function getProduct() {
        return $this->product;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function getTotalValue() {
        return $this->totalValue;
    }

    function setProduct($product) {
        $this->product = new Product($product['name'], $product['description'], $product['purchaseprice'], 
                $product['saleprice'], $product['measure'], $product['section'], $product['provider'], $product['currentstock']);
    }

    function setQuantity($quantity) {
        if (!$this->iv->isQuantityValid($quantity))
            throw new RequestException("400", "Bad request");

        $this->quantity = $quantity;
    }

    function setTotalValue($totalValue) {
        $price = ($this->itemType == 'purchase') ? $this->product->getPurchasePrice() : $this->product->getSalePrice();
        
        if (!$this->iv->isTotalValueValid($totalValue, $this->quantity, $price))
            throw new RequestException("400", "Bad request");

        $this->totalValue = $totalValue;
    }

}
