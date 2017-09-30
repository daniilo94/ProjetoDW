<?php

class Bonus {

    private $productId;
    private $timestamp;
    private $reason;
    private $quantity;

    public function __construct($productId, $timestamp, $reason, $quantity) {
        //$this->uv = new UserValidator();
        $this->productId = $productId;
        $this->timestamp = $timestamp;
        $this->reason = $reason;
        $this->quantity = $quantity;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
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

}
