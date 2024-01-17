<?php
require_once "models/Model.php";


class gallerysManager extends Model
{
    public function getGallerys()
    {
        $req = "SELECT * from gallerys";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $gallerys = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $gallerys;
    }
    public function deleteDBgallery($gallery_id)
    {
        $req = "DELETE FROM gallerys WHERE gallery_id= :gallery_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":gallery_id", $gallery_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function updateGallery($gallery_id, $gallery_title, $gallery_content, $file)
    {
        try {
            $req = "SELECT * FROM gallerys WHERE gallery_id = :gallery_id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":gallery_id", $gallery_id, PDO::PARAM_INT);
            $stmt->execute();
            $gallery = $stmt->fetch(PDO::FETCH_ASSOC);

            // If a new file have been upload, Use addPic() to handle it
            if (!empty($file['name'])) {
                $dir = "public/images/";
                $gallery_img = addPic($file, $dir);
                // Delete older file
                unlink($dir . $gallery['gallery_img']);
            } else {
                $gallery_img = $gallery['gallery_img'];
            }

            $req = "UPDATE gallerys 
                SET gallery_title = :gallery_title, gallery_content = :gallery_content, gallery_img = :gallery_img 
                WHERE gallery_id= :gallery_id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":gallery_id", $gallery_id, PDO::PARAM_INT);
            $stmt->bindValue(":gallery_title", $gallery_title, PDO::PARAM_STR);
            $stmt->bindValue(":gallery_content", $gallery_content, PDO::PARAM_STR);
            $stmt->bindValue(":gallery_img", $gallery_img, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "Une erreur est survenue lors de la mise à jour de l'entrée, veuillez réessayer plus tard.";
            echo $e->getMessage();
        }
    }

    public function createGallery($gallery_title, $gallery_content, $gallery_img)
    {
        $this->getBdd()->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8mb4");
        $req = "INSERT INTO gallerys (gallery_title, gallery_content, gallery_img)
        VALUES (:gallery_title, :gallery_content, :gallery_img)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":gallery_title", $gallery_title, PDO::PARAM_STR);
        $stmt->bindValue(":gallery_content", $gallery_content, PDO::PARAM_STR);
        $stmt->bindValue(":gallery_img", $gallery_img, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        return $this->getBdd()->lastInsertId();
    }
}
