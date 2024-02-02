<?php
require_once "models/Model.php";


class bannerManager extends Model
{
    public function getBanner()
    {
        $req = "SELECT * from banner";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $banner = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $banner;
    }
    public function deleteDBBanner($banner_id)
    {
        $req = "DELETE FROM banner WHERE banner_id= :banner_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":banner_id", $banner_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function updateBanner($ID, $Name, $AltText, $file)
    {
        try {
            $req = "SELECT * FROM banner WHERE ID = :ID";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":ID", $ID, PDO::PARAM_INT);
            $stmt->execute();
            $banner = $stmt->fetch(PDO::FETCH_ASSOC);

            // If a new file have been upload, Use addPic() to handle it
            if (!empty($file['name'])) {
                $dir = "public/images/";
                $Image = addPic($file, $dir);
                // Delete older file
                unlink($dir . $banner['Image']);
            } else {
                $Image = $banner['Image'];
            }

            $req = "UPDATE banner 
                SET Name = :Name, AltText = :AltText, Image = :Image 
                WHERE ID= :ID";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":ID", $ID, PDO::PARAM_INT);
            $stmt->bindValue(":Name", $Name, PDO::PARAM_STR);
            $stmt->bindValue(":AltText", $AltText, PDO::PARAM_STR);
            $stmt->bindValue(":Image", $Image, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "Une erreur est survenue lors de la mise à jour de l'entrée, veuillez réessayer plus tard.";
            echo $e->getMessage();
        }
    }

    public function createBanner($Name, $AltText, $Image)
    {
        $this->getBdd()->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8mb4");
        $req = "INSERT INTO banner (Name, AltText, Image)
        VALUES (:Name, :AltText, :Image)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":Name", $Name, PDO::PARAM_STR);
        $stmt->bindValue(":AltText", $AltText, PDO::PARAM_STR);
        $stmt->bindValue(":Image", $Image, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        return $this->getBdd()->lastInsertId();
    }
}
