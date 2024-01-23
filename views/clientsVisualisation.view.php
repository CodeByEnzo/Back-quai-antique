<?php
ob_start();
echo "<table class='table table-striped'>";
echo "<thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Number</th>
            <th colspan='2'>Actions</th>
        </tr>
      </thead>
      <tbody>";

function generateClientRow($client, $isEditing)
{
    if ($isEditing) {
        return "
                     <form method='post' action='" . URL . "back/clients/validationModification'>
                <tr>
                    <td>{$client['client_id']}</td>
                    <td><input type='text' name='username' class='form-control' value='{$client['username']}' /></td>
                    <td><input type='text' name='email' class='form-control' rows='3' value='{$client['email']}' /></td>
                    <td><input type='text' name='number' class='form-control' rows='3' value='{$client['number']}' /></td>
                    <input type='hidden' name='client_id' value='{$client['client_id']}' />
                    <td colspan='2'>
                        <button class='btn btn-success' type='submit'>Valider</button>
                    </td>
                </tr>
            </form>
        ";
    } else {
        return "
            <tr>
                <td class='bg-primary-subtle'>{$client['client_id']}</td>
                <td class='bg-info-subtle'>{$client['username']}</td>
                <td class='bg-primary-subtle'>{$client['email']}</td>
                <td class='bg-info-subtle'>{$client['number']}</td>
                <td class='bg-primary-subtle'>
                    <form method='post' action=''>
                        <input type='hidden' name='client_id' value='{$client['client_id']}' />
                        <button class='btn btn-warning' type='submit'>Modifier</button>
                    </form>
                </td>
                <td class='bg-primary-subtle'>
                    <form method='post' action='" . URL . "back/clients/validationDelete' onSubmit='return confirm(\"Voulez-vous vraiment supprimer ?\");'>
                        <input type='hidden' name='client_id' value='{$client['client_id']}' />
                        <button class='btn btn-danger' type='submit'>Supprimer</button>
                    </form>
                </td>
            </tr>
        ";
    }
}

foreach ($clients as $client) {
    $isEditing = isset($_POST['client_id']) && $_POST['client_id'] == $client['client_id'];
    echo generateClientRow($client, $isEditing);
}
echo "</tbody></table>";

$content = ob_get_clean();
$title = "Administration des clients";
require "views/commons/template.php";
