<?php
require_once "models/Model.php";

class DiagManager extends Model
{
    public function getQuestions()
    {
        $query = "SELECT id, question_text, multipleAnswers FROM questions";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $questions;
    }
    public function getAnswersForQuestion($questionId)
    {
        $query = "SELECT answer_key, answer_text FROM answers WHERE question_id = :id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id", $questionId, PDO::PARAM_INT);
        $stmt->execute();
        $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $answers;
    }

    public function createQuestion($questionText, $multipleAnswers)
    {
        $query = "INSERT INTO questions (question_text, multipleAnswers) VALUES (:question_text, :multipleAnswers)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':question_text', $questionText, PDO::PARAM_STR);
        $stmt->bindValue(':multipleAnswers', $multipleAnswers, PDO::PARAM_BOOL);

        if ($stmt->execute()) {
            // Récupérez l'ID généré automatiquement
            $questionId = $this->getBdd()->lastInsertId();
            $stmt->closeCursor();

            return $questionId;
        } else {
            return false;
        }
    }


    public function updateDiag($id, $answers, $questionText, $multipleAnswers)
    {
        try {
            //START
            $this->getBdd()->beginTransaction();
            // UPDATE QUESTION
            $query = "UPDATE questions SET question_text = :questionText, multipleAnswers = :multipleAnswers WHERE id = :id";
            $stmt = $this->getBdd()->prepare($query);
            $stmt->bindValue(':questionText', $questionText, PDO::PARAM_STR);
            $stmt->bindValue(':multipleAnswers', $multipleAnswers, PDO::PARAM_BOOL);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            // UPDATE ANSWER
            foreach ($answers as $answerKey => $answerText) {
                $query = "UPDATE answers SET answer_text = :answerText WHERE question_id = :questionId AND answer_key = :answerKey";
                $stmt = $this->getBdd()->prepare($query);
                $stmt->bindValue(':answerText', urldecode($answerText), PDO::PARAM_STR); // Décodez les données URL
                $stmt->bindValue(':questionId', $id, PDO::PARAM_INT);
                $stmt->bindValue(':answerKey', $answerKey, PDO::PARAM_STR);
                $stmt->execute();
            }
            // CHECKING
            $this->getBdd()->commit();
        } catch (PDOException $e) {
            // If error, cancel
            $this->getBdd()->rollBack();
            throw new Exception("La mise à jour du diagnostic a échoué.");
        }
    }




    public function deleteQuestion($questionId)
    {
        try {
            $this->getBdd()->beginTransaction();

            // Delete answer first
            $query = "DELETE FROM answers WHERE question_id = :id";
            $stmt = $this->getBdd()->prepare($query);
            $stmt->bindValue(':id', $questionId, PDO::PARAM_INT);
            $stmt->execute();

            // Then delete question
            $query = "DELETE FROM questions WHERE id = :question_id";
            $stmt = $this->getBdd()->prepare($query);
            $stmt->bindValue(':question_id', $questionId, PDO::PARAM_INT);
            $stmt->execute();

            // Validation
            $this->getBdd()->commit();
        } catch (PDOException $e) {
            // If error, cancel
            $this->getBdd()->rollBack();
            throw new Exception("La suppression de la question et de ses réponses a échoué.");
        }
    }


    public function createAnswer($questionId, $answerKey, $answerText)
    {
        $query = "INSERT INTO answers (question_id, answer_key, answer_text) VALUES (:question_id, :answer_key, :answer_text)";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(':question_id', $questionId, PDO::PARAM_INT);
        $stmt->bindValue(':answer_key', $answerKey, PDO::PARAM_STR);
        $stmt->bindValue(':answer_text', $answerText, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
