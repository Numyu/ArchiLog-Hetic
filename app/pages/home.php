<?php
session_start();
require("../includes/pdo.inc.php");
$error = '';
$submit = filter_input(INPUT_POST, "submit");
$newDns = filter_input(INPUT_POST, "dns");
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
} else {
    $userId = $_SESSION['id'];
    $getAllUser = $pdo->query("SELECT * FROM user WHERE id = '$userId'");
    $getAllUser = $getAllUser->fetch(PDO::FETCH_ASSOC);
    $username = $getAllUser['username'];
    $password = $getAllUser['password'];
    $dns = $getAllUser['domain_name'];
    $dbName = $getAllUser['username'] . "db";
    $showDisk = shell_exec("/var/www/html/app/script/showDiskSpace.sh $username $password $dbName");


    // ------------- Download les Backups ------------------ //
    $downloadButton = filter_input(INPUT_POST, 'downloadBackup');
    if (isset($downloadButton)) {
        $backup = shell_exec("/var/www/html/app/script/backup.sh $username $password $dbName");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Ajout d'un deuxième site pour un user
    if (isset($submit) && isset($dns)) {

        // Vérification de l'unicité du nom de domaine
        $getDomainName = $pdo->query("SELECT domain_name FROM site WHERE domain_name = '$newDns'");
        $getDomainName = $getDomainName->fetch(PDO::FETCH_ASSOC)['domain_name'];

        if (isset($getDomainName)) {

            $error = 'Le nom de domaine ' . $getDomainName . ' est déjà utilisé ! ';
        } else {

            // Création de la nouvelle bdd 
            $db = shell_exec("/var/www/html/app/script/createDb.sh $username $password $newDns");

            // Ajout d'un nouveau site dans la table site
            $sql = $pdo->prepare('INSERT INTO site (userId, domain_name) VALUES (:userId, :dns)');
            $sql->execute([
                ":userId" => $userId,
                ":dns" => $newDns
            ]);
        }
    }
}

?>

<?php require("../partials/header.php"); ?>
<div class="home-page">
    <div class="home-box">
        <nav>
            <div class="nav-link">
                <h4>Utilisateur : <?= $username ?> - Identifiant : <?= $_SESSION['id'] ?></h4>
                <a href="../includes/logout.inc.php">
                    <button>Déconnexion</button>
                </a>
                <a href="changepassword.php">
                    <button>Changer de mot de passe</button>
                </a>
            </div>
        </nav>
    </div>

    <form method="post">
        <h3>Ajout d'un site</h3>
        <input type="text" name="dns" placeholder="DNS">
        <input type="submit" name="submit" value="ajout">
        <?= isset($error) ? '<span style="color:red">' . $error . '</span>' : '' ?>
    </form>
    <?= $showDisk ?>

    <form method="post">
        <input type="submit" name="downloadBackup" class="downloadBackup">
        downloadBackup
        </input>
    </form>
    <?= $backup ?>
</div>
<?php require("../partials/header.php"); ?>