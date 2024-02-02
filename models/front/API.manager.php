<?php
require_once "models/Model.php";

// This file is reserved for the rest API of php
class APIManager extends Model
{
    public function getDBProducts()
    {
        $req = "SELECT * FROM products p INNER JOIN categories c ON c.id = p.category_id";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $products;
    }
    public function getDBBanner()
    {
        $req = "SELECT * FROM banner";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $banner = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $banner;
    }
    public function getDBGallery()
    {
        $req = "SELECT * FROM gallerys";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $gallerys = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $gallerys;
    }
    public function getDBClient()
    {
        $req = "SELECT * FROM clients";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $clients;
    }
    public function getDBReservation()
    {
        $req = "SELECT * FROM reservations";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $reservation = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $reservation;
    }
    public function getDBHours()
    {
        $req = "SELECT * FROM opening_hours";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $opening_hours = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $opening_hours;
    }
    public function getIsRestaurantFull($date, $opening_hour, $closing_hour)
    {
        $query = "
        SELECT SUM(number_of_people) AS total_reserved
        FROM reservations
        WHERE 
            date = :date AND 
            time BETWEEN :opening_hour AND :closing_hour;
    ";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":opening_hour", $opening_hour, PDO::PARAM_STR);
        $stmt->bindParam(":closing_hour", $closing_hour, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result['total_reserved'] ?? 0;
    }



    public function getDBCompanyInfo()
    {
        $req = "SELECT * FROM company_info";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $companyInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $companyInfo;
    }
}
