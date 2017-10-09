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

    public function getProduct() {
        return $this->product;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getTotalValue() {
        return $this->totalValue;
    }

    private function setProduct($product) {
        $this->product = new Product($product['name'], $product['description'], $product['purchaseprice'], 
                $product['saleprice'], $product['measure'], $product['section'], $product['provider'], $product['currentstock']);
    }

    private function setQuantity($quantity) {
        if (!$this->iv->isQuantityValid($quantity))
            throw new RequestException("400", "Bad request");

        $this->quantity = $quantity;
    }

    private function setTotalValue($totalValue) {
        $price = ($this->itemType == 'purchase') ? $this->product->getPurchasePrice() : $this->product->getSalePrice();
        
        if (!$this->iv->isTotalValueValid($totalValue, $this->quantity, $price))
            throw new RequestException("400", "Bad request");

        $this->totalValue = $totalValue;
    }

}
