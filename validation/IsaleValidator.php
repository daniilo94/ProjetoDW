<?php

interface ISaleValidator {

    public function isTotalPriceValid($totalPrice, $saleItems);

    public function isFormOfPaymentValid($formOfPayment);
}