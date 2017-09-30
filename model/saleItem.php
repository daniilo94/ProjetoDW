<?php

class SaleItem {

    private $saleId;
    private $productId;
    private $quantity;
    private $totalValue;

    public function __construct($saleId, $productId, $quantity, $totalValue) {
        //$this->uv = new UserValidator();
        $this->saleId = $saleId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->totalValue = $totalValue;
    }

    public function getSaleId() {
        return $this->saleId;
    }

    public function setSaleId($saleId) {
        $this->saleId = $saleId;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getTotalValue() {
        return $this->totalValue;
    }

    public function setTotalValue($totalValue) {
        $this->totalValue = $totalValue;
    }

}
