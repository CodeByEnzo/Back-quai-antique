<?php

require_once "./models/back/diag.manager.php";
require_once "./controllers/back/Security.class.php";
require_once "./controllers/back/utile.php";

class DiagController
{
    private $diagManager;

    public function __construct()
    {
        $this->diagManager = new DiagManager();
    }

    public function visualisation()
    {
        if (security::verifAccessSession()) {
            $questions = $this->diagManager->getQuestions();
            foreach ($questions as $index => $question) {
                $questions[$index]['answers'] = $this->diagManager->getAnswersForQuestion($question['id']);
            }
            require_once "views/diagVisualisation.view.php";
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

                $this->diagManager->deleteQuestion($id);
                header('Location: ' . URL . 'back/diag/visualisation');
            } else {
                $_SESSION['alert'] = [
                    "message" => "Erreur lors de la suppression de la question",
                    "type" => "alert-danger"
                ];
                header('Location: ' . URL . 'back/diag/visualisation');
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

            $this->diagManager->updateDiag($id, $answers, $question, $multipleAnswers);
            $_SESSION['alert'] = [
                "message" => "Le diagnostic a été modifié",
                "type" => "alert-success"
            ];
            header("Location: " . URL . "back/diag/visualisation");
        } else {
            throw new Exception("Les données envoyées sont incorrectes : question_id, question_text et answers doivent être définis.");
        }
    }



    public function creationTemplate()
    {
        if (security::verifAccessSession()) {
            $questions = $this->diagManager->getQuestions();
            require_once "views/diagCreation.view.php";
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
            $questionId = $this->diagManager->createQuestion($questionText, $multipleAnswers);

            if (!$questionId) {
                throw new Exception("La création de la question a échoué.");
            }

            $answers = $_POST['answers'];

            if (!empty($answers) && is_array($answers)) {
                $answerKey = 'A';

                foreach ($answers as $answer) {
                    $answerText = security::secureHTML($answer['answer_text']);

                    $this->diagManager->createAnswer($questionId, $answerKey, $answerText);

                    $answerKey++;
                }

                $_SESSION['alert'] = [
                    "message" => "La question et ses réponses ont été créées avec succès.",
                    "type" => "alert-success"
                ];
                header("Location: " . URL . "back/diag/visualisation");
            } else {
                throw new Exception("Aucune réponse valide n'a été fournie.");
            }
        } else {
            throw new Exception("Les données envoyées sont incorrectes : question_text et answers doivent être définis.");
        }
    }

    public function getDiagData()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json");
        header('Access-Control-Max-Age: 86400');

        $questions = $this->diagManager->getQuestions();

        // Pour chaque question, récupérez les réponses correspondantes
        foreach ($questions as &$question) {
            $question['answers'] = $this->diagManager->getAnswersForQuestion($question['id']);
        }

        Model::sendJSON($questions);
    }
}
