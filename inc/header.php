<?php
if (session_status() == PHP_SESSION_NONE) {
    //démarrer la session même si elle n'est pas trouvé
    session_start();
} ?>


<?php require_once 'function.php' ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Mes films</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['auth'])) : ?>
                        <li><a class="nav-link active" href="submit.php">Soumettre une idée</a></li>
                        <li><a class="nav-link active" href="idea.php">Voir toutes les idées</a></li>
                        <li><a class="nav-link active" href="myidea.php">Voir toutes mes idées</a></li>
                        <li><a class="nav-link active" href="logout.php">Se déconnecter</a></li>
                    <?php else : ?>
                        <li><a class="nav-link active" href="register.php">S'inscrire</a></li>
                        <li><a class="nav-link active" href="login.php">Se connecter</a></li>

                    <?php endif; ?>
                </ul>
            </div>
    </nav>

    <?php if (isset($_SESSION['flash'])) : ?>
        <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
            <div class="alert alert-<?= $type; ?>">
                <?= $message; ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>

    <?php endif; ?>