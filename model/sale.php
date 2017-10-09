<?php

class Sale {

    private $timestamp;
    private $saleItems;
    private $totalPrice;
    private $formOfPayment;
    private $cashier;
    private $sv;

    public function __construct($saleItems, $totalPrice, $formOfPayment, $cashier) {
        $this->sv = new SaleValidator();

        $this->setTimestamp();
        $this->setSaleItems($saleItems);
        $this->setTotalPrice($totalPrice);
        $this->setFormOfPayment($formOfPayment);
        $this->setCashier($cashier);
    }

    function getTimestamp() {
        return $this->timestamp;
    }

    function getSaleItems() {
        return $this->saleItems;
    }

    function getTotalPrice() {
        return $this->totalPrice;
    }

    function getFormOfPayment() {
        return $this->formOfPayment;
    }

    function getCashier() {
        return $this->cashier;
    }

    function setFormOfPayment($formOfPayment) {
        if (!$this->sv->isFormOfPaymentValid($formOfPayment))
            throw new RequestException("400", "Bad request");

        $this->formOfPayment = $formOfPayment;
    }

    function setCashier($cashier) {
        $this->cashier = new Employee($cashier['name'], $cashier['cpf'], $cashier['phones'], $cashier['email'], $cashier['birthdate'], $cashier['role']);
    }

    function setTimestamp() {
        $this->timestamp = (new DateTime)->getTimestamp();
    }

    function setSaleItems($saleItems) {
        foreach ($saleItems as $item) {
            new Item('sale', $item['product'], $item['quantity'], $item['totalvalue']);
        }
        $this->saleItems = $saleItems;
    }

    function setTotalPrice($totalPrice) {
        if (!$this->sv->isTotalPriceValid($totalPrice, $this->saleItems))
            throw new RequestException("400", "Bad request");

        $this->totalPrice = $totalPrice;
    }

}
