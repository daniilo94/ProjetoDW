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

    function getTimestamp() {
        return $this->timestamp;
    }

    function getPurchaseItems() {
        return $this->purchaseItems;
    }

    function getTotalPrice() {
        return $this->totalPrice;
    }

    function getProvider() {
        return $this->provider;
    }

    function setTimestamp() {
        $this->timestamp = (new DateTime)->getTimestamp();
    }

    function setPurchaseItems($purchaseItems) {
        foreach ($purchaseItems as $item) {
            new Item('purchase', $item['product'], $item['quantity'], $item['totalvalue']);
        }
        $this->purchaseItems = $purchaseItems;
    }

    function setTotalPrice($totalPrice) {
        if (!$this->pv->isTotalPriceValid($totalPrice, $this->purchaseItems))
            throw new RequestException("400", "Bad request");

        $this->totalPrice = $totalPrice;
    }

    function setProvider($provider) {
        $this->provider = new Provider($provider['name'], $provider['cnpj'], $provider['phones'], $provider['email'], $provider['description']);
    }

}
