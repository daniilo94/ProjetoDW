<?php

class ItemValidator implements IItemValidator {

    public function isQuantityValid($quantity) {
        if (empty($quantity) || !is_numeric($quantity))
            return false;

        return true;
    }

    public function isTotalValueValid($totalValue, $quantity, $price) {
        $total = $quantity * $price;
        if ($totalValue != $total)
            return false;

        return true;
    }

}
