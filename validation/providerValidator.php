<?php

class ProviderValidator {

public function isValidEmail($email) {
	if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		return false;
	return true;
}

}