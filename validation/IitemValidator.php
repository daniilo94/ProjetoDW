<?php

interface IItemValidator {

    public function isQuantityValid($quantity);

    public function isTotalValueValid($totalValue, $quantity, $price);
}