<?php

interface IPurchaseValidator {

    public function isTotalPriceValid($totalPrice, $purchaseItems);
}