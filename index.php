<?php

//TODO: implementar auto requirimento de classes  
require_once ("autoload.php");

//Externaliza o resultado do processamento da API em formato JSON, sempre.
var_dump((new RequestTreater())->start());
