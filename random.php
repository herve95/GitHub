<?php
function random()
{
    //genere un nb aléatoire et le converti en hexa
    $nb = mt_rand ( 10 , 10000000 );
    return dechex ( int $nb );
}
?>


