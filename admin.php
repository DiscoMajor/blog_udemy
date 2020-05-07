<?php
session_start();

if (!isset($_SESSION['admin']) OR !$_SESSION['admin']) {
    header('Location: /');
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js"></script>
</head>

<!-- BODY -->

<body>

    <!-- HEADER -->

<?php include_once 'includes/header.php' ?>

<h1 id="h2_articles">Administration</h1>

<a href="php/deconnexion.php">Se déconnecter</a>



    <?php include_once 'includes/foot.php' ?>

</div>

</body>

</html>