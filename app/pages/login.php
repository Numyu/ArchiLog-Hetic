<?php
session_start();
require("../includes/pdo.inc.php");
if (isset($_SESSION['id'])) {
    header("Location: ./home.php");
    exit;
} else {
    $submit = filter_input(INPUT_POST, "submit");
    $username = filter_input(INPUT_POST, "username");
    $password = filter_input(INPUT_POST, "password");
    if (isset($submit)) {
        if (!empty($username) && !empty($password)) {
            $background = true;
            $getUserUsername = $pdo->query("SELECT username FROM user WHERE username = '$username'");
            if ($getUserUsername->rowCount() === 0) {
                $error = "Erreur, veuillez réessayer !";
            } else {
                $getPswd = $pdo->query("SELECT password FROM user WHERE username = '$username'");
                $getPswd = $getPswd->fetch(PDO::FETCH_ASSOC)['password'];
                if ($password === $getPswd) {
                    $getUserId = $pdo->query("SELECT id FROM user WHERE username = '$username'");
                    $getUserId = $getUserId->fetch(PDO::FETCH_ASSOC)['id'];

                    $_SESSION['id'] = $getUserId;

                    header("Location: home.php");
                } else {
                    $error = "Erreur, veuillez réessayer !";
                }
            }
        } else {
            $error = "Veuillez remplir tous les champs !";
        }
    }
}
?>

<?php require("../partials/header.php"); ?>
<div class="auth-page">
    <div class="auth-box">
        <h2>Connexion</h4>
            <form method="post">
                <input class="auth-form-username" type="text" name="username" placeholder="Nom d'utilisateur">
                <input class="auth-form-password" type="password" name="password" placeholder="Mot de passe">
                <input id="submit" class="auth-form-submit" type="submit" name="submit" value="se connecter">
            </form>
            <?= isset($error) ? '<span style="color:red">' . $error . '</span>' : '' ?>
            <br>
            <a href="./signup.php">Sign in</a>
    </div>
</div>
<?php require("../partials/footer.php"); ?>