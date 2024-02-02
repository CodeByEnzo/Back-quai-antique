<?php
session_start();

require_once "controllers/front/API.controller.php";
require_once "controllers/back/admin.controller.php";
require_once "controllers/back/products.controller.php";
require_once "controllers/back/gallerys.controller.php";
require_once "controllers/back/clients.controller.php";
require_once "controllers/front/Login.controller.php";
require_once "controllers/front/user.controller.php";
require_once "controllers/back/banner.controller.php";
require_once "controllers/back/reservations.controller.php";
require_once "controllers/back/hours.controller.php";
require_once "controllers/back/companyInfo.controller.php";
require_once "controllers/back/diag.controller.php";

$companyInfoController = new companyInfoController;
$hoursController = new hoursController();
$UserController = new UserController();
$reservationsController = new reservationsController();
$LoginController = new LoginController();
$apiController = new APIController();
$adminController = new AdminController();
$productsController = new ProductsController();
$gallerysController = new GallerysController();
$bannerController = new bannerController();
$clientsController = new clientsController();
$diagController = new diagController();

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

try {
    if (empty($_GET['page'])) {
        throw new Exception("La page n'éxiste pas");
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        if (empty($url[0]) || empty($url[1])) {
            throw new Exception("La page demandé n'éxiste pas");
        }

        switch ($url[0]) {
            case "front":
                switch ($url[1]) {
                        // REACT**********************************
                    case "register":
                        $UserController->register();
                        break;
                    case "userLogin":
                        $LoginController->login();
                        break;
                    case "userUpdateInfo":
                        $UserController->userUpdateInfo();
                        break;
                    case "authenticate":
                        $UserController->getUserInfo();
                        break;
                    case "products":
                        $apiController->getProducts();
                        break;
                    case "banner":
                        $apiController->getBanner();
                        break;
                    case "companyInfo":
                        $apiController->getCompanyInfo();
                        break;
                    case "hours":
                        $apiController->getHours();
                        break;
                    case "isRestaurantFull":
                        $apiController->isRestaurantFull();
                        break;
                    case "gallerys":
                        $apiController->getGallerys();
                        break;
                    case "sendMessage":
                        $apiController->sendMessage();
                        break;
                    case "forgotPW":
                        $UserController->forgotPW();
                        break;
                    case "resetPW":
                        $UserController->resetPW();
                        break;
                    case "reservation":
                        $UserController->makeReservation();
                        break;
                    case "cancelReservation":
                        $UserController->DeleteReservation();
                        break;
                    case "updateReservation":
                        $UserController->UpdateReservation();
                        break;
                        //Gaby-------------------------------------------
                    case "getDiagData":
                        $diagController->getDiagData();
                        break;
                    default:
                        throw new Exception("La page n'éxiste pas");
                }
                break;
            case "back":
                switch ($url[1]) {
                    case "login":
                        $adminController->getPageLogin();
                        break;
                    case "connection":
                        $adminController->connection();
                        break;
                    case "admin":
                        $adminController->getHomeAdmin();
                        break;
                    case "logout":
                        $adminController->logout();
                        break;
                    case "products":
                        switch ($url[2]) {
                            case "visualisation":
                                $productsController->visualisation();
                                break;
                            case "validationModification":
                                $productsController->modification();
                                break;
                            case "validationDelete":
                                $productsController->delete();
                                break;
                            case "creation":
                                $productsController->creationTemplate();
                                break;
                            case "creationValidation":
                                $productsController->creationValidation();
                                break;
                            default:
                                throw new Exception("La page n'existe pas");
                        }
                        break;
                    case "gallerys":
                        switch ($url[2]) {
                            case "visualisation":
                                $gallerysController->visualisation();
                                break;
                            case "validationModification":
                                $gallerysController->modification();
                                break;
                            case "validationDelete":
                                $gallerysController->delete();
                                break;
                            case "creation":
                                $gallerysController->creationTemplate();
                                break;
                            case "creationValidation":
                                $gallerysController->creationValidation();
                                break;
                            default:
                                throw new Exception("La page n'existe pas");
                        }
                        break;
                    case "clients":
                        switch ($url[2]) {
                            case "visualisation":
                                $clientsController->visualisation();
                                break;
                            case "validationModification":
                                $clientsController->modification();
                                break;
                            case "validationDelete":
                                $clientsController->delete();
                                break;
                            case "creation":
                                $clientsController->creationTemplate();
                                break;
                            case "creationValidation":
                                $clientsController->creationValidation();
                                break;
                            default:
                                throw new Exception("La page n'existe pas");
                        }
                        break;
                    case "reservations":
                        switch ($url[2]) {
                            case "visualisation":
                                $reservationsController->visualisation();
                                break;
                            case "validationModification":
                                $reservationsController->modification();
                                break;
                            case "validationDelete":
                                $reservationsController->delete();
                                break;
                            case "creation":
                                $reservationsController->creationTemplate();
                                break;
                            case "creationValidation":
                                $reservationsController->creationValidation();
                                break;
                            default:
                                throw new Exception("La page n'existe pas");
                        }
                        break;
                    case "hours":
                        switch ($url[2]) {
                            case "visualisation":
                                $hoursController->visualisation();
                                break;
                            case "validationModification":
                                $hoursController->modification();
                                break;
                            default:
                                throw new Exception("La page n'existe pas");
                        }
                        break;
                    case "companyInfo":
                        switch ($url[2]) {
                            case "visualisation":
                                $companyInfoController->visualisation();
                                break;
                            case "validationModification":
                                $companyInfoController->modification();
                                break;
                            default:
                                throw new Exception("La page n'existe pas");
                        }
                        break;
                    case "diag":
                        switch ($url[2]) {
                            case "visualisation":
                                $diagController->visualisation();
                                break;
                            case "validationModification":
                                $diagController->modification();
                                break;
                            case "creation":
                                $diagController->creationTemplate();
                                break;
                            case "creationValidation":
                                $diagController->creationValidation();
                                break;
                            case "validationDelete":
                                $diagController->delete();
                                break;
                            default:
                                throw new Exception("La page n'existe pas");
                        }
                        break;
                    case "banner":
                        switch ($url[2]) {
                            case "visualisation":
                                $bannerController->visualisation();
                                break;
                            case "validationModification":
                                $bannerController->modification();
                                break;
                            case "creation":
                                $bannerController->creationTemplate();
                                break;
                            case "creationValidation":
                                $bannerController->creationValidation();
                                break;
                            case "validationDelete":
                                $bannerController->delete();
                                break;
                            default:
                                throw new Exception("La page n'existe pas");
                        }
                        break;
                    default:
                        throw new Exception("La page n'éxiste pas");
                }
                break;
            default:
                throw new Exception("La page n'éxiste pas");
        }
    }
} catch (Exception $e) {
    // Check if page doesn't exist
    if ($e->getMessage() === "La page n'éxiste pas" || $e->getMessage() === "La page demandé n'éxiste pas") {
        http_response_code(404);
        include_once "404.php";
    } else {
        echo $e->getMessage();
    }
    exit();
}
