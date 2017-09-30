<?php

interface IRequestValidator {


	public function isMethodValid($method);

	public function isProtocolValid($protocol);

	public function isUriValid($uri, $method);

	public function isQueryStringValid($queryString);

    public function isBodyValid($body, $operation, $resource);
}