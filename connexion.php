<?php
session_start();

if (isset($_SESSION['admin']) AND $_SESSION['admin']){
    header('Location: /admin.php');
}

$erreur='';
if (isset($_POST['connexion'])) {
    if (isset($_POST['pseudo'], $_POST['password'])) {
            $pseudo= htmlspecialchars ($_POST['pseudo']);
            $password= htmlspecialchars ($_POST['password']);

            if (!empty($pseudo) AND !empty($password)) {

                if($pseudo == 'vico' AND $password == '123') {
                    $_SESSION['admin'] = true;
                    header('location: /admin.php');
                     } else {
                         $erreur = 'Mauvais identifiants saisis';
                     }

        } else {
                $erreur = 'Veuillez saisir votre nom d\'utilisateur et votre mot de passe';
        }
    } else {
        $erreur = 'Veuillez saisir votre nom d\'utilisateur et votre mot de passe';
    }
}

?>



<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js"></script>
</head>


<body>

    <!-- HEADER -->

<?php include_once 'includes/header.php' ?>

<div class="visu_connexion">


    <h1>Connexion</h1>

    <section class="espace_connexion">

        <form method="POST">
            <input type="text" name="pseudo" placeholder="Nom d'utilisateur"  <?php if(isset($pseudo)) { ?> value="<?= $pseudo ?>" <?php } ?>>
            </br>
            <input type="password" name="password" placeholder="Mot de passe"  <?php if(isset($password)) { ?> value="<?= $password ?>" <?php } ?>>
            </br>
            <input type="submit" name="connexion" value="Se connecter">
        </form>

        <?php if ($erreur) { ?>
            <p style="color : red;"> <?= $erreur ?> </p>
        <?php } ?>

    </section>

</div>

</body>

</html>