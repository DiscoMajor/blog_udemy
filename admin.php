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

$categories = $bdd->query('SELECT * FROM categories');

$message_article='';
$taille_maximum=2;
if(isset($_POST['article'])) {
	if(isset($_POST['categorie_article'], 
		$_POST['titre'], 
		$_POST['contenu'], 
		$_FILES['miniature']['tmp_name'])) {

		$categorie = htmlspecialchars ($_POST['categorie_article']);
		$titre = htmlspecialchars ($_POST['titre']);
		$contenu = htmlspecialchars ($_POST['contenu']);
		$miniature = $_FILES['miniature'];

		if(!empty($categorie) AND !empty($titre) AND !empty($contenu) AND !empty($miniature)) {
			 
			if(filesize($miniature['tmp_name']) <= $taille_maximum*1000000) {
				
				if(exif_imagetype($miniature['tmp_name']) == 2) {

					$ins = $bdd->prepare('INSERT INTO articles (titre, categorie, contenu, datetime_post) VALUES (:titre,:categorie,:contenu, NOW())');
					$res = $ins->execute([
						':titre' => $titre,
						':categorie' => $categorie,
						':contenu' => $contenu
					]);

						if ($res) {

							$last_id = $bdd->lastInsertId();

							$chemin ='img/miniatures/'.$last_id.'.jpg';

							$move = move_uploaded_file($miniature['tmp_name'], $chemin);

								if($move) {
									$message_article = 'Votre article a bien été crée !';
								} else {
									$message_article = "Une erreur est survenue lors de la création de la miniature";
								}

						} else {
							$message_article ='Une erreur est survenue durant l\'ajoute de l\'article';
						}

			} else {
					$message_article='Votre miniature doit etre au format JPG';
			}


			} else {
					$message_article='Votre taille maximum ne peut pas dépasser '.$taille_maximum.' Mo';
			}
		}

	}else{
		$message_article='Veuillez completer tous les champs';
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

<br><br>

<h3>Rédiger un article</h3>


<form method="POST" enctype="multipart/form-data">
	<select name="categorie_article" required>
		<?php while($o = $categories->fetch(PDO::FETCH_ASSOC)) { ?>
			<option value="<?= $o['categorie_url'] ?>"<?php if(isset($categorie) AND $categorie == $o['categorie_url']) { echo ' selected'; } ?>><?= $o['categorie'] ?></option>
		<?php } ?>
	</select>
	<br>
		<input type="text" name="titre" placeholder="Titre de l'article" <?php if(isset($titre)) { echo 'value="'.$titre.'"'; } ?> required>
	<br>
		<textarea name="contenu" placeholder="Contenu de l'article" style="width:80%;" required><?php if(isset($contenu)) { echo $contenu; } ?></textarea>
	<br>
		<input type="file" name="miniature" id="miniature" required><label for="miniature">Miniature de l'article</label>
	<br>
		<input type="submit" value="Publier l'article" name="article">

</form>


<?php if($message_article) { echo '<p>'.$message_article.'</p>'; } ?>



</section>

</div>


</body>

</html>