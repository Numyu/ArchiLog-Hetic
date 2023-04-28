<?php
session_start();
require("../includes/pdo.inc.php");
$submit = filter_input(INPUT_POST, "submit");
$oldPassword = filter_input(INPUT_POST, "oldPassword");
$newPassword = filter_input(INPUT_POST, "newPassword");
$userId = $_SESSION['id'];
$getAllUser = $pdo->query("SELECT * FROM user WHERE id = '$userId'");
$getAllUser = $getAllUser->fetch(PDO::FETCH_ASSOC);
$username = $getAllUser['username'];
$passwordInDb = $getAllUser['password'];

if (isset($submit)) {
    if (!empty($username)) {
        if ($oldPassword == $passwordInDb) {
            $output = shell_exec("/var/www/html/app/script/changePasswd.sh $username $oldPassword $newPassword");
            $updatePassword = $pdo->query("UPDATE user SET password = '$newPassword' WHERE id = '$userId'");
            $msg = "Mot de passe changé !";
        } else {
            $error = "Ancien mot de passe incorrect !";
        }
    } else {
        $error = "Veuillez remplir tous les champs !";
    }
}
?>

<?php require("../partials/header.php"); ?>
<div class="home-page">
    <div>
        <h3>Changement de mot de passe</h3>
        <form method="post">
            <input type="text" name="oldPassword" id="oldPassword" placeholder="Ancien mot de passe">
            <input type="text" name="newPassword" id="newPassword" placeholder="Nouveau mot de passe">
            <input id="submit" type="submit" name="submit" value="Changer">
        </form>
        <?= isset($error) ? '<span style="color:red">' . $error . '</span>' : '' ?>
        <?= isset($msg) ? '<span style="color:green">' . $msg . '</span>' : '' ?>
        <a href="home.php">
            <button>accueil</button>
        </a>
    </div>
</div>
<?php require("../partials/header.php"); ?>