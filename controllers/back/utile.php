<?php

function ajoutImage($file, $dir)
{
    //Verification si une saisie à bien été faite
    if (!isset($file['name']) || empty($file['name']))
        throw new Exception("Vous devez indiquer une image");
    //Evite les doublons
    if (!file_exists($dir)) mkdir($dir, 0777);
    // Gère les extension, vérifie que le nom n'existe pas et oui rajoute un chiffe
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $random = rand(0, 99999);
    $target_file = $dir . $random . "_" . $file['name'];
    //Vérifie que le fichier est une image, l'extension, s'il n'existe pas déjà, que le fichier n'est pas trop volumineux,
    //on place le fichier a l'endroit que l'on défini
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
