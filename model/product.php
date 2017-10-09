<?php

class Product {

    private $name;
    private $description;
    private $purchasePrice;
    private $salePrice;
    private $measure;
    private $section;
    private $provider;
    private $currentStock;
    private $pv;

    public function __construct($name, $description, $purchasePrice, $salePrice, $measure, $section, $provider, $currentStock) {
        $this->pv = new ProductValidator();

        $this->setName($name);
        $this->setDescription($description);
        $this->setPurchasePrice($purchasePrice);
        $this->setSalePrice($salePrice);
        $this->setMeasure($measure);
        $this->setSection($section);
        $this->setProvider($provider);
        $this->setCurrentStock($currentStock);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (!$this->pv->isNameValid($name))
            throw new RequestException("400", "Bad request");

        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        if (!$this->pv->isDescriptionValid($description))
            throw new RequestException("400", "Bad request");

        $this->description = $description;
    }

    public function getPurchasePrice() {
        return $this->purchasePrice;
    }

    public function setPurchasePrice($purchasePrice) {
        if (!$this->pv->isPurchasePriceValid($purchasePrice))
            throw new RequestException("400", "Bad request");

        $this->purchasePrice = $purchasePrice;
    }

    public function getSalePrice() {
        return $this->salePrice;
    }

    public function setSalePrice($salePrice) {
        if (!$this->pv->isSalePriceValid($salePrice))
            throw new RequestException("400", "Bad request");

        $this->salePrice = $salePrice;
    }

    public function getMeasure() {
        return $this->measure;
    }

    public function setMeasure($measure) {
        if (!$this->pv->isMeasureValid($measure))
            throw new RequestException("400", "Bad request");

        $this->measure = $measure;
    }

    public function getSection() {
        return $this->section;
    }

    public function setSection($section) {
        $this->section = new Section($section['name'], $section['description']);
    }

    public function getProvider() {
        return $this->provider;
    }

    public function setProvider($provider) {
        $this->provider = new Provider($provider['name'], $provider['cnpj'], $provider['phones'],
            $provider['email'], $provider['description']);
    }

    public function getCurrentStock() {
        return $this->currentStock;
    }

    public function setCurrentStock($currentStock) {
        if (!$this->pv->isCurrentStockValid($currentStock))
            throw new RequestException("400", "Bad request");

        $this->currentStock = $currentStock;
    }

}
