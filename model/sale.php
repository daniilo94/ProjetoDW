<?php

class Sale {

    private $timestamp;
    private $totalPrice;
    private $formOfPayment;

    public function __construct($timestamp, $totalPrice, $formOfPayment) {
        //$this->uv = new UserValidator();
        $this->timestamp = $timestamp;
        $this->totalPrice = $totalPrice;
        $this->formOfPayment = $formOfPayment;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }

    public function getFormOfPayment() {
        return $this->formOfPayment;
    }

    public function setFormOfPayment($formOfPayment) {
        $this->formOfPayment = $formOfPayment;
    }

}
