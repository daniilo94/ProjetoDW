<?php

//TODO: implementar auto requirimento de classes  
require_once ("autoload.php");

//Externaliza o resultado do processamento da API em formato JSON, sempre.
echo ((new RequestTreater())->start());
