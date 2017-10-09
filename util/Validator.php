<?php

class Validator {

    public function isPhoneValid($phone) {
        if (!preg_match("/^\([0-9]{2}\)[0-9]{5}-[0-9]{4}$/", $phone))
            return false;

        return true;
    }

    public function isCnpjValid($c) {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $c);
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        return ($this->isFisrtCnpjDigitValid($cnpj) && $this->isSecondCnpjDigitValid($cnpj));
    }

    private function isFisrtCnpjDigitValid($cnpj) {
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        return true;
    }

    private function isSecondCnpjDigitValid($cnpj) {
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto2 = $soma % 11;
        return $cnpj{13} == ($resto2 < 2 ? 0 : 11 - $resto2);
    }

    public function isCpfValid($c) {

        $cpf = str_replace([".", "-"], "", $c);
        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
            return FALSE;
        } else {
            // Calcula os números para verificar se o CPF é verdadeiro
            return $this->calculateCpfNumbers($cpf);
        }
    }

    private function calculateCpfNumbers($cpf) {
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }

}
