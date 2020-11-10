<?php require_once "inc/header.php"; ?>
<?php require_once "inc/function.php";
?>

<?php
//Condition - erreur 
if (!empty($_POST)) {
    $errors = array();
    require_once 'inc/db.php';
    //On aura besoin de la base de donnée ici; on va donc faire appel à elle avec un require_once (qui permet de ne l'envoyer qu'une fois et pas en boucle)

    //si aucun pseudo n'est rentré ou si les conditions ne sont pas réspectés
    if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
        $errors['username'] = "Votre pseudo n'est pas valide (Alphanumérique)";
        //var_dump ($errors);  pour vérifier que la condition est bien prise en compte = débuger 
    } else {
        $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        if ($user) {
            $errors['username'] = "Ce pseudo est déjà pris";
        } // Vérification qu'il n'y a pas déjà un username identique

    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Votre email n'est pas valide";
        //vérification de l'email
    } else {
        $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if ($user) {
            $errors['email'] = "Cet email est déjà utilisé pour un autre compte";
        } // Vérification qu'il n'y a pas déjà un email identique

    }



    if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
        //Si le mot de passe n'est pas valide alors:
        $errors['password'] = "Vous devez rentrer un mot de passe valide";
        //verification du mot de passe
    }

    if (empty($_POST['password_confirm'])) {
        $errors['password_confirm'] = "Mot de passe non identique";
        //Vérification mot de pase identique
    }

    if (empty($errors)) {

        $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token=?");
        // Inserer l'utilisateur avec des requêtes préparés
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        //On crypte le mot de passe en cas de piratage de la base donnée, les mots de passe utilisateur apparaîtron crypté
        $token = str_random(60);
        $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
        $user_id = $pdo->lastInsertId();
        mail($_POST['email'], "Confirmation de votre compte", "Afin de valider votre compte merci de cliquer sur ce lien : http://localhost/film/assets/register.php"); //ajouter le lien ainsi que l'id
        //Envoies un mail de confirmation
        //'->' = ordre de le faire - prepare - execute
        $_SESSION['flash']['success'] = "Un email de confirmation ou a été renvoyé pour activé votre compte";
        header('Location: login.php');
        exit();
        die("Notre compte a bien été crée");
    }

    debug($errors);
    //Message d'erreur
}

?>

<?php if (!empty($errors)) : //Message d'alerte si le formulaire contient des eurreurs
?>

    <div class="alert alert-danger">
        <p>Vous n'avez pas rempli le formulaire correctement</p>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

<?php endif; ?>


<h1>S'inscrire</h1>
<!-- Formulaire d'enregistrement -->
<form action="" method="POST">

    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" class="form-control" />
    </div>
    <!-- Formulaire d'enregistrement  du pseudo-->

    <div class="form-group">
        <label for="">Email</label>
        <input type="text" name="email" class="form-control" />
    </div>
    <!-- Formulaire d'enregistrement de l'email-->

    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control" />
    </div>
    <!-- Formulaire d'enregistrement du mot de passe -->

    <div class="form-group">
        <label for="">Confirmez votre mot de passe</label>
        <input type="password" name="password_confirm" class="form-control" />
    </div>
    <!-- Formulaire d'enregistrement confirmation du mot de passe-->

    <button type="submit" class="btn btn-primary">M'inscrire</button>
    <!-- Ajout d'un bouton -->

</form>


<?php require_once "inc/footer.php" ?>