<?php

class Purchase {

    private $timestamp;
    private $totalPrice;
    private $providerId;
    private $finished;

    public function __construct($timestamp, $totalPrice, $providerId, $finished) {
        //$this->uv = new UserValidator();
        $this->timestamp = $timestamp;
        $this->totalPrice = $totalPrice;
        $this->providerId = $providerId;
        $this->finished = $finished;
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

    public function getProviderId() {
        return $this->providerId;
    }

    public function setProviderId($providerId) {
        $this->providerId = $providerId;
    }

    public function getFinished() {
        return $this->finished;
    }

    public function setFinished($finished) {
        $this->finished = $finished;
    }

}
