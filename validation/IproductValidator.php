<?php

interface IProductValidator {

    public function isNameValid($name);

    public function isDescriptionValid($description);

    public function isPurchasePriceValid($purchasePrice);

    public function isSalePriceValid($salePrice);

    public function isMeasureValid($measure);

    public function isCurrentStockValid($currentStock);
}