<?php
require_once "models/Model.php";


class companyInfoManager extends Model
{
    public function getCompanyInfo()
    {
        $req = "SELECT * from company_info";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $companyInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $companyInfo;
    }


    public function updateCompanyInfo($id, $name, $adress, $phone, $email)
    {
        try {
            $req = "SELECT * FROM company_info WHERE id = :id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $companyInfo = $stmt->fetch(PDO::FETCH_ASSOC);

            $req = "UPDATE company_info
                SET id = :id, 
                name = :name, 
                adress = :adress, 
                phone = :phone, 
                email = :email
                WHERE id= :id";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindValue(":name", $name, PDO::PARAM_STR);
            $stmt->bindValue(":adress", $adress, PDO::PARAM_STR);
            $stmt->bindValue(":phone", $phone, PDO::PARAM_STR);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);

            $stmt->execute();
            $stmt->closeCursor();
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "Une erreur est survenue lors de la mise à jour de l'entrée, veuillez réessayer plus tard.";
            echo $e->getMessage();
        }
    }
}
