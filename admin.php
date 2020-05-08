<?php
session_start();

require_once 'php/config.php';

if(!isset($_SESSION['admin']) OR !$_SESSION['admin']) {
	header('Location: /');
}

$message_categorie = '';
if(isset($_POST['categorie'])) {
	if(!empty($_POST['nom']) AND !empty($_POST['slug'])) {
		$nom = htmlspecialchars($_POST['nom']);
		$slug = htmlspecialchars($_POST['slug']);

		$ins = $bdd->prepare('INSERT INTO categories (categorie, categorie_url) VALUES (?, ?)');
		$res = $ins->execute([$nom, $slug]);

		if($res) {
			$message_categorie = 'La nouvelle catégorie a bien été ajoutée !';
		} else {
			$message_categorie = 'Une erreur est survenue durant l\'ajout de la catégorie';
		}

	} else {
		$message_categorie = 'Veuillez renseigner un nom de catégorie ainsi qu\'un slug';
	}
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

<div class="visu_connexion">

<h1>Administration</h1>

<a href="php/deconnexion.php">Se déconnecter</a>

<br><br>

<h3>Nouvelle catégorie</h3>

<section class="espace_connexion">

<form method="POST">
    <input type="text" name="nom" placeholder="Nom de la categorie" required>
    <input type="text" name="slug" size="30" placeholder="Slug de la catégorie (dans l'url)" required>
    <input type="submit" name="categorie" value="Créer la catégorie">
</form>

<?php if($message_categorie) { echo '<p>' .$message_categorie. '<p>'; } ?>

</section>

</div>


</body>

</html>