<?php

class PurchaseItem {

    private $purchaseId;
    private $productId;
    private $quantity;
    private $totalValue;

    public function __construct($purchaseId, $productId, $quantity, $totalValue) {
        //$this->uv = new UserValidator();
        $this->purchaseId = $purchaseId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->totalValue = $totalValue;
    }

    public function getPurchaseId() {
        return $this->purchaseId;
    }

    public function setPurchaseId($purchaseId) {
        $this->purchaseId = $purchaseId;
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
