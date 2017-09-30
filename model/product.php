<?php

class Product {

    private $name;
    private $description;
    private $purchasePrice;
    private $salePrice;
    private $sectionId;
    private $providerId;
    private $stock;

    public function __construct($name, $description, $purchasePrice, $salePrice, $sectionId, $providerId, $stock) {
        $this->pv = new ProductValidator();
        $this->name = $name;
        $this->description = $description;
        $this->purchasePrice = $purchasePrice;
        $this->salePrice = $salePrice;
        $this->sectionId = $sectionId;
        $this->providerId = $providerId;
        $this->stock = $stock;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPurchasePrice() {
        return $this->purchasePrice;
    }

    public function getSalePrice() {
        return $this->salePrice;
    }

    public function getSectionId() {
        return $this->sectionId;
    }

    public function getProviderId() {
        return $this->providerId;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPurchasePrice($purchasePrice) {
        $this->purchasePrice = $purchasePrice;
    }

    public function setSalePrice($salePrice) {
        $this->salePrice = $salePrice;
    }

    public function setSectionId($salePrice) {
        $this->salePrice = $salePrice;
    }

    public function setProviderId($providerId) {
        $this->providerId = $providerId;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

}
