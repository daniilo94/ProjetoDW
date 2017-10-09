<?php

class PurchaseValidator implements IPurchaseValidator {

    public function isTotalPriceValid($totalPrice, $purchaseItems) {
        $total = 0;
        foreach ($purchaseItems as $item) {
            $total = $total + $item['totalvalue'];
        }
        
        if ($totalPrice != $total)
            return false;

        return true;
    }

}
