<?php

class Purchase {

    private $timestamp;
    private $purchaseItems;
    private $totalPrice;
    private $provider;
    private $pv;

    public function __construct($purchaseItems, $totalPrice, $provider) {
        $this->pv = new PurchaseValidator();

        $this->setTimestamp();
        $this->setPurchaseItems($purchaseItems);
        $this->setTotalPrice($totalPrice);
        $this->setProvider($provider);
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getPurchaseItems() {
        return $this->purchaseItems;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }

    public function getProvider() {
        return $this->provider;
    }

    private function setTimestamp() {
        $this->timestamp = (new DateTime)->getTimestamp();
    }

    private function setPurchaseItems($purchaseItems) {
        foreach ($purchaseItems as $item) {
            new Item('purchase', $item['product'], $item['quantity'], $item['totalvalue']);
        }
        $this->purchaseItems = $purchaseItems;
    }

    private function setTotalPrice($totalPrice) {
        if (!$this->pv->isTotalPriceValid($totalPrice, $this->purchaseItems))
            throw new RequestException("400", "Bad request");

        $this->totalPrice = $totalPrice;
    }

    private function setProvider($provider) {
        $this->provider = new Provider($provider['name'], $provider['cnpj'], $provider['phones'], $provider['email'], $provider['description']);
    }

}
