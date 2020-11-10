<?php
if (isset($_GET['id']) && isset ($_GET['token'])){
    require_once 'inc/db.php';
    require_once 'inc/function.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND token=? AND reset_at > DATE_SUB (NOW(),INTERVAL 30 MINUTE)');
    $req->execute([$_GET['id'], $_GET['token']]);
    $user =  $req->fetch;
    if($user){
        if (!empty($_POST)){
            if (!empty($_POST['password']) && $_POST['password'] == $_POST ['password_confirm']){
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute ([$password]);
                session_start();
                $_SESSION['flash']['sucsess'] = 'Votre mot de passe a bien été modifié';
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();

            }
        }
    }else
    session_start();
    $_SESSION['flash']['error'] ="Ce token n'est pas valide";
    header('Location: login.php');
    exit();

}else{
    header('Location: login.php');
    exit();
}

?>

<?php require_once "inc/header.php"; ?>


<h1>Reinitialiser votre mot de passe</h1>
<!-- Formulaire d'enregistrement -->
<form action="" method="POST">

    <div class="form-group">
        <label for="">Mot de passe <a href="forget.php">(J'ai oublié mon mot de passe)</a> </label>
        <input type="password" name="password" class="form-control" />
    </div>
    <!-- Formulaire d'enregistrement du mot de passe -->

    
    <div class="form-group">
        <label for="">Confirmez votre mot de passe</label>
        <input type="password" name="password_confirm" class="form-control" />
    </div>
    <!-- Formulaire d'enregistrement confirmation du mot de passe-->

    <button type="submit" class="btn btn-primary">Reinitialiser votre mot de passe</button>
    <!-- Ajout d'un bouton -->

</form>

<?php require_once "inc/footer.php"; ?>