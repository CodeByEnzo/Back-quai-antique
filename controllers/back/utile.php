<?php

function addPic($file, $dir)
{
    //Verify if not empty
    if (!isset($file['name']) || empty($file['name']))
        throw new Exception("Vous devez indiquer une image");
    //Avoid duplicates
    if (!file_exists($dir)) mkdir($dir, 0777);
    // Handle extensions, verify if name doesnt exist and if add a number
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $random = rand(0, 99999);
    $target_file = $dir . $random . "_" . $file['name'];
    //Check if file is an image, verify extension, if doesnt exist and file not to big
    //Place file in the right folder where defined
    if (!getimagesize($file["tmp_name"]))
        throw new Exception("Le fichier n'est pas une image");
    if ($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
        throw new Exception("L'extension du fichier n'est pas reconnu");
    if (file_exists($target_file))
        throw new Exception("Le fichier existe déjà");
    if ($file['size'] > 500000)
        throw new Exception("Le fichier est trop gros");
    if (!move_uploaded_file($file['tmp_name'], $target_file))
        throw new Exception("l'ajout de l'image n'a pas fonctionné");
    else return ($random . "_" . $file['name']);
    echo $file;
}
