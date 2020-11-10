<?php require_once "inc/header.php";
require_once 'inc/db.php';
logged_only();

//Si $_POST n'est pas vide = soumission du formulaire
if (!empty($_POST)) {
    //Créer une variable $req = requête préparée pour faire un INSERT 
    $req = $pdo->prepare('INSERT INTO films (title,synopsis,id_user) VALUES (?,?,?)');
    //execution de la requête préparé 
    $req->execute([$_POST['titre'], $_POST['synopsis'], $_SESSION['auth']->id]);
    
}

?>

<form action="" method="POST">


    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" class="form-control" />

    </div>

    <div class="form-group">
        <label for="synopsis">Synopsis</label>
        <textarea class="form-control" id="synopsis" rows="3" name="synopsis"></textarea>

    </div>
    <button type="submit" class="btn btn-primary">Soumettre mon idée</button>
</form>
