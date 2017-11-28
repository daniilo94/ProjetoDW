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

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getSaleItems() {
        return $this->saleItems;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }

    public function getFormOfPayment() {
        return $this->formOfPayment;
    }

    public function getCashier() {
        return $this->cashier;
    }

    private function setFormOfPayment($formOfPayment) {
        if (!$this->sv->isFormOfPaymentValid($formOfPayment))
            throw new RequestException("400", "Invalid form of payment");

        $this->formOfPayment = $formOfPayment;
    }

    private function setCashier($cashier) {
        $this->cashier = new Employee($cashier['name'], $cashier['cpf'], $cashier['phones'], $cashier['email'], $cashier['birthdate'], $cashier['role']);
    }

    private function setTimestamp() {
        $this->timestamp = (new DateTime)->getTimestamp();
    }

    private function setSaleItems($saleItems) {
        foreach ($saleItems as $item) {
            new Item('sale', $item['product'], $item['quantity'], $item['totalvalue']);
        }
        $this->saleItems = $saleItems;
    }

    private function setTotalPrice($totalPrice) {
        if (!$this->sv->isTotalPriceValid($totalPrice, $this->saleItems))
            throw new RequestException("400", "Invalid price");

        $this->totalPrice = $totalPrice;
    }

}
