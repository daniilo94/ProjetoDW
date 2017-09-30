<?php

class LostProduct {

    private $productId;
    private $date;
    private $reason;
    private $quantity;
    private $totalPrice;

    public function __construct($productId, $date, $reason, $quantity, $totalPrice) {
        //$this->uv = new UserValidator();
        $this->productId = $productId;
        $this->date = $date;
        $this->reason = $reason;
        $this->quantity = $quantity;
        $this->totalPrice = $totalPrice;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getReason() {
        return $this->reason;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }

}
