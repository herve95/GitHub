<?php
function upload($index,$destination,$maxsize=FALSE,$extensions=FALSE)
{
   //Test1: fichier correctement uploadé
     if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0){ echo "upload nok";return FALSE;}
   //Test2: taille limite
     if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) { echo "taille nok";return FALSE;}
   //Test3: extension
     $ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
     if ($extensions !== FALSE AND !in_array($ext,$extensions)) { echo "extension nok";return FALSE;}
   //Déplacement
     return move_uploaded_file($_FILES[$index]['tmp_name'],$destination);
}


?>


