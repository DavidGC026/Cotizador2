<?php

$formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);

$numero = 123456;
$texto = $formatterES->format($numero);

echo "$numero en texto es: $texto";

?>
