<?php

require_once "models/Model.php";

class ProductsManager extends Model
{
    public function getProducts()
    {
        $req = "SELECT * from products";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $products;
    }

    public function deleteDBProduct($product_id)
    {
        $req = "DELETE FROM products WHERE product_id= :product_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":product_id", $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function updateProduct($product_id, $title, $content, $prix, $category_id)
    {
        try {

                $req = "UPDATE products SET title = :title, content = :content, prix = :prix, category_id = :category_id 
            WHERE product_id= :product_id";
                $stmt = $this->getBdd()->prepare($req);
                $stmt->bindValue(":product_id", $product_id, PDO::PARAM_INT);
                $stmt->bindValue(":title", $title, PDO::PARAM_STR);
                $stmt->bindValue(":content", $content, PDO::PARAM_STR);
                $stmt->bindValue(":prix", $prix, PDO::PARAM_INT);
                $stmt->bindValue(":category_id", $category_id, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->closeCursor();
            
                throw new Exception("Les valeurs fournies pour la mise à jour de produit ne sont pas valides");
            
        } catch (Exception $e) {
            // Enregistrer des informations sur l'erreur
            error_log($e->getMessage());

            // Notifier les utilisateurs
            echo "Une erreur est survenue lors de la mise à jour de l'entrée, veuillez réessayer plus tard.";
            // ou avec un message d'erreur personnalisé
            echo $e->getMessage();
        }
    }
    
    public function createProduct($title, $content, $prix, $category_id)
    {
        $req = "INSERT INTO products (title, content, prix, category_id, product_image)
        VALUES (:title, :content, :prix, :category_id, :product_image)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":content", $content, PDO::PARAM_STR);
        $stmt->bindValue(":prix", $prix, PDO::PARAM_INT);
        $stmt->bindValue(":category_id", $category_id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        return $this->getBdd()->lastInsertId();
    }
}
