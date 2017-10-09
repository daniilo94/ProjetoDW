<?php
class SaleValidator implements ISaleValidator {
    
    public function isTotalPriceValid($totalPrice, $saleItems) {
        $total = 0;
        foreach ($saleItems as $item) {
            $total = $total + $item['totalvalue'];
        }
        
        if ($totalPrice != $total)
            return false;

        return true;
    }
    
    public function isFormOfPaymentValid($formOfPayment){
        if($formOfPayment != "Crédito" && $formOfPayment != "Débito" && $formOfPayment != "Dinheiro"){
            return false;
        }
        
        return true;
    }

}