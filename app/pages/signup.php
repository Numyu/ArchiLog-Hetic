<?php
session_start();
require("../includes/pdo.inc.php");
$submit = filter_input(INPUT_POST, "submit");
$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");
$dns = filter_input(INPUT_POST, "dns");
if (isset($submit)) {
    if (!empty($username) && !empty($password)) {
        $getUserUsername = $pdo->query("SELECT username FROM user WHERE username = '$username'");
        if ($getUserUsername->rowCount() > 0) {
            $error =  "Cet utilisateur existe déjà !";
        } else {
            $sql = $pdo->prepare('INSERT INTO user (username, password, domain_name) VALUES (:username, :password, :dns)');
            $sql->execute([
                ":username" => $username,
                ":password" => $password,
                ":dns" => $dns
            ]);

            $dbName = $username . 'db';
            $createUser = shell_exec("/var/www/html/app/script/createUser.sh $username $password $dns");
            $createUserDatabases = shell_exec("/var/www/html/app/script/createDb.sh $username $password $dbName");

            $getUserId = $pdo->query("SELECT id FROM user WHERE username = '$username'");
            $getUserId = $getUserId->fetch(PDO::FETCH_ASSOC)['id'];

            $sql = $pdo->prepare('INSERT INTO site (userId, domain_name) VALUES (:userId, :dns)');
            $sql->execute([
                ":userId" => $getUserId,
                ":dns" => $dns
            ]);

            $_SESSION['id'] = $getUserId;
            header("Location: home.php");
        }
    } else {
        $error = "Veuillez remplir tous les champs !";
    }
}
?>

<?php require("../partials/header.php"); ?>
<div class="auth-page">
    <div class="auth-box">
        <h2>Inscription</h2>
        <form method="post">
            <input class="auth-form-username" type="text" name="username" placeholder="Nom d'utilisateur">
            <input class="auth-form-password" type="password" name="password" placeholder="Mot de passe">
            <input class="auth-form-dns" type="text" name="dns" placeholder="Nom de domaine">
            <input class="auth-form-submit" type="submit" name="submit" value="s'inscrire">
        </form>
        <?= isset($error) ? '<span style="color:red">' . $error . '</span>' : '' ?>
        <br>
        <a href="./login.php">Se connecter</a>
    </div>
</div>
<?php require("../partials/footer.php"); ?>