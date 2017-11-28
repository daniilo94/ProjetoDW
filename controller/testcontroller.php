<?php

//include_once ("httpful.phar");

class TestController {

    public function routeOperation() {

        $providerTeste = new ProviderTest();
        $productTeste = new ProductTest();
        $sectionTeste = new SectionTest();
        $userTeste = new UserTest();

        echo $providerTeste->testAll();
        echo $productTeste->testAll();
        echo $sectionTeste->testAll();
        echo $userTeste->testAll();
    }

}
