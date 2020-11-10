<?php
require_once "inc/header.php";
require_once 'inc/db.php';
logged_only();


if (isset($_GET['id'])) {



    $req = $pdo->prepare('SELECT  films.id,films.title,films.synopsis,films.id_user FROM films WHERE films.id=?');
    $req->execute([intval($_GET['id'])]);
    $film = $req->fetch();

    if ($film->id_user == $_SESSION['auth']->id) { ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre" class="form-control" value="<?php echo $film->title ?>" />
            </div>

            <div class="form-group">
                <label for="synopsis">Synopsis</label>
                <textarea class="form-control" id="synopsis" rows="3" name="synopsis"><?php echo $film->synopsis ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour mon idée</button>
        </form>

<?php } else{
    $_SESSION['flash']['danger'] = "Vous ne pouvez pas modifié ce film.";
    header('Location: idea.php');
}
} else {

    $_SESSION['flash']['danger'] = "La page demandée n'existe pas.";
    header('Location: idea.php');
}

if (!empty($_POST)){

    $req = $pdo->prepare('UPDATE films SET title = :title, synopsis = :synopsis WHERE id=:id');
    $req->execute([':title'=> $_POST['titre'], ':synopsis'=> $_POST['synopsis'], ':id'=> $film->id]);

    $_SESSION['flash']['success']= " Vos modifications ont bien été apportées";
    header('Location: idea.php');
};

?>

