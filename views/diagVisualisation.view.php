<?php ob_start(); ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#ID</th>
            <th scope="col">Question</th>
            <th scope="col">Réponses</th>
            <th scope="col">Multiples réponses</th>
            <th scope="col" colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($questions as $question) : ?>
            <?php if (isset($_POST['id']) && $_POST['id'] == $question['id']) : ?>
                <form method="post" action="<?= URL ?>back/diag/validationModification">
                    <tr>
                        <td><?= $question['id'] ?></td>
                        <td>
                            <input type="text" name="question_text" class="form-control" value="<?= $question['question_text'] ?>" />
                        </td>
                        <td>
                            <!-- Input area for updating answers -->
                            <?php foreach ($question['answers'] as $answer) : ?>
                                <div>
                                    <label for="answer_text">Réponse <?= $answer['answer_key'] ?>:</label>
                                    <input type="text" name="answers[<?= $answer['answer_key'] ?>]" class="form-control" value="<?= $answer['answer_text'] ?>" />
                                </div>
                            <?php endforeach; ?>
                        </td>
                        </td>
                        <td>
                            <input type="checkbox" name="multipleAnswers" <?= isset($_POST['multipleAnswers']) && $_POST['multipleAnswers'] === 'on' ? 'checked' : '' ?> />
                        </td>

                        <td colspan="2">
                            <input type="hidden" name="question_id" value="<?= $question['id'] ?>" />
                            <button class="btn btn-primary" type="submit">Valider</button>
                        </td>
                    </tr>
                </form>
            <?php else : ?>
                <tr>
                    <td><?= $question['id'] ?></td>
                    <td><?= $question['question_text'] ?></td>
                    <td>
                        <!-- Display current answers -->
                        <?php foreach ($question['answers'] as $answer) : ?>
                            <div>Réponse <?= $answer['answer_key'] ?>: <?= $answer['answer_text'] ?></div>
                        <?php endforeach; ?>
                    </td>
                    </td>
                    <td><?= $question['multipleAnswers'] ? 'Oui' : 'Non' ?></td>
                    <td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="id" value="<?= $question['id'] ?>" />
                            <button class="btn btn-warning" type="submit">Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?= URL ?>back/diag/validationDelete" onSubmit="return confirm('Voulez-vous vraiment supprimer ?');">
                            <input type="hidden" name="id" value="<?= $question['id'] ?>" />
                            <button class="btn btn-danger" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>



<?php
$content = ob_get_clean();
$title = "Administration des questions";
require "views/commons/template.php";
?>