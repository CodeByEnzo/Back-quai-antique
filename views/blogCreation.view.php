<?php ob_start(); ?>

<form method="post" action="<?= URL ?>back/blog/creationValidation" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="blog_content" class="form-label bg-warning p-2 rounded">Nouvelle question :</label>
        <textarea class="form-control" id="blog_content" name="question_text"></textarea>
    </div>
    <div>
        <label for="multipleAnswers" class="form-label bg-warning p-2 rounded">Est-ce une question à choix multiples ?</label>
        <input type="checkbox" name="multipleAnswers" <?= isset($_POST['multipleAnswers']) && $_POST['multipleAnswers'] === 'on' ? 'checked' : '' ?> />
        <p class="d-inline">(Cochez la case si la question possède plusieurs réponses)</p>
    </div>
    <div class="mb-3" id="answersContainer">
        <label for="blog_content" class="form-label bg-warning p-2 rounded">Nouvelle(s) réponse(s) :</label>
        <div class="answer mb-3">
            <label for="answer_text" class="form-label">Réponse A</label>
            <textarea class="form-control" name="answers[0][answer_text]"></textarea>
            <input type="hidden" name="answers[0][question_id]" value="">
        </div>
    </div>
    <div class="d-grid gap-2">
        <button type="button" class="btn btn-success add-answer fs-3 p-0 fw-bold">+</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const answersContainer = document.getElementById("answersContainer");
        const addAnswerButton = document.querySelector(".add-answer");
        let answerCount = 1;

        addAnswerButton.addEventListener("click", function() {
            const newAnswerDiv = document.querySelector(".answer").cloneNode(true);

            // Clear the input value
            newAnswerDiv.querySelector("textarea").value = "";

            // Update the label for the new answer
            newAnswerDiv.querySelector("label").textContent = `Réponse ${String.fromCharCode(65 + answerCount)}`;

            // Update the name attribute to include the answer index
            const textarea = newAnswerDiv.querySelector("textarea");
            textarea.name = `answers[${answerCount}][answer_text]`;

            answersContainer.appendChild(newAnswerDiv);

            answerCount++;
        });
    });
</script>

<?php
$content = ob_get_clean();
$title = "Ajouter un article";
require "views/commons/template.php";
