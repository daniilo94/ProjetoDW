<?php

class ProductValidator implements IProductValidator {

    public function isNameValid($name) {
        if (empty($name) || strlen($name) < 3) {
            return false;
        }

        return true;
    }

    public function isDescriptionValid($description) {
        if (empty($description)) {
            return false;
        }

        return true;
    }

    public function isPurchasePriceValid($purchasePrice) {
        if (empty($purchasePrice)) {
            return false;
        }

        return true;
    }

    public function isSalePriceValid($salePrice) {
        if (empty($salePrice)) {
            return false;
        }

        return true;
    }

    public function isMeasureValid($measure) {
        if ($measure != "Quilo" && $measure != "Unidade" && $measure != "Litro") {
            return false;
        }

        return true;
    }

    public function isCurrentStockValid($currentStock) {
        if (!is_numeric($currentStock)) {
            return false;
        }

        return true;
    }

}