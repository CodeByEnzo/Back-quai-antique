<?php

require_once "./models/back/blog.manager.php";
require_once "./controllers/back/Security.class.php";
require_once "./controllers/back/utile.php";

class blogController
{
    private $blogManager;

    public function __construct()
    {
        $this->blogManager = new blogManager();
    }

    public function visualisation()
    {
        if (security::verifAccessSession()) {
            $articles = $this->blogManager->getArticles();

            // Pour chaque article, récupérez les blocs associés
            foreach ($articles as &$article) {
                $blocs = $this->blogManager->getBlocsOfArticle($article['id']);
                $article['blocs'] = $blocs;
            }

            require_once "views/blogVisualisation.view.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function delete()
    {
        if (security::verifAccessSession()) {
            if (isset($_POST['id'])) {
                $id = intval(security::secureHTML($_POST['id']));

                $_SESSION['alert'] = [
                    "message" => "La question a été supprimée",
                    "type" => "alert-success"
                ];

                $this->blogManager->deleteQuestion($id);
                header('Location: ' . URL . 'back/blog/visualisation');
            } else {
                $_SESSION['alert'] = [
                    "message" => "Erreur lors de la suppression de la question",
                    "type" => "alert-danger"
                ];
                header('Location: ' . URL . 'back/blog/visualisation');
            }
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function modification()
    {
        if (isset($_POST['question_id'], $_POST['question_text'], $_POST['answers'])) {
            $id = filter_input(INPUT_POST, 'question_id', FILTER_VALIDATE_INT);
            $question = htmlspecialchars($_POST['question_text'], ENT_QUOTES, 'UTF-8');
            $answers = $_POST['answers'];
            $multipleAnswers = isset($_POST['multipleAnswers']) && $_POST['multipleAnswers'] === 'on' ? 1 : 0;
            if ($id === false || $question === '') {
                throw new Exception("Les données envoyées sont incorrectes : question_id doit être un entier valide et question ne peut pas être vide.");
            }

            $this->blogManager->updateblog($id, $answers, $question, $multipleAnswers);
            $_SESSION['alert'] = [
                "message" => "Le blognostic a été modifié",
                "type" => "alert-success"
            ];
            header("Location: " . URL . "back/blog/visualisation");
        } else {
            throw new Exception("Les données envoyées sont incorrectes : question_id, question_text et answers doivent être définis.");
        }
    }

    public function creationTemplate()
    {
        if (security::verifAccessSession()) {
            require_once "views/blogCreation.view.php";
        } else {
            throw new Exception("Vous n'avez pas les droits.");
        }
    }

    public function creationValidation()
    {
        if (security::verifAccessSession() && isset($_POST['question_text']) && isset($_POST['answers']) && isset($_POST['multipleAnswers'])) {
            $questionText = security::secureHTML($_POST['question_text']);
            $multipleAnswers = ($_POST['multipleAnswers'] === 'on') ? 1 : 0;

            if (empty($questionText)) {
                throw new Exception("La question ne peut pas être vide.");
            }
            $questionId = $this->blogManager->createQuestion($questionText, $multipleAnswers);

            if (!$questionId) {
                throw new Exception("La création de la question a échoué.");
            }

            $answers = $_POST['answers'];

            if (!empty($answers) && is_array($answers)) {
                $answerKey = 'A';

                foreach ($answers as $answer) {
                    $answerText = security::secureHTML($answer['answer_text']);

                    $this->blogManager->createAnswer($questionId, $answerKey, $answerText);

                    $answerKey++;
                }

                $_SESSION['alert'] = [
                    "message" => "La question et ses réponses ont été créées avec succès.",
                    "type" => "alert-success"
                ];
                header("Location: " . URL . "back/blog/visualisation");
            } else {
                throw new Exception("Aucune réponse valide n'a été fournie.");
            }
        } else {
            throw new Exception("Les données envoyées sont incorrectes : question_text et answers doivent être définis.");
        }
    }

    public function getBlogData()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json");
        header('Access-Control-Max-Age: 86400');
    }
}
