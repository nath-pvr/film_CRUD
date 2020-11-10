<?php

if (!empty($_POST) && !empty($_POST['email'])) {
    require_once 'inc/db.php';
    require_once 'inc/function.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if ($user) {
        session_start();
        $reser_token = str_random(60);
        $pdo->prepare('UPDATE users SET reset_token =?, reset_at = NOW() WHERE id = ?')->execute([$reser_token, $user->id]);
        $_SESSION['flash']['success'] =  'Les instructions du rappel du mot de passe vous ont été renvoyé par email';
        header('Location: login.php');
        mail($_POST['email'], "Réinitialisation de votre Mot de passe", "Merci de cliquer sur ce lien : http://localhost/film/assets/reset.php?id={$user->id}&token=$reset_token"); //ajouter le lien ainsi que l'id
        exit();
    } else {
        $_SESSION['flash']['danger'] = 'Aucun compte ne correspont à cette adresse';
    }
}

?>


<?php require_once "inc/header.php"; ?>

<h1>Mot de passe oublié</h1>
<!-- Formulaire MDP oubli"é -->
<form action="" method="POST">


    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control" />
    </div>


    <button type="submit" class="btn btn-primary">Se connecter</button>
    <!-- Ajout d'un bouton -->

</form>


<?php require_once "inc/footer.php" ?>