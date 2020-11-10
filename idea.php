<?php require_once "inc/header.php";
require_once 'inc/db.php';


$req = $pdo->prepare('SELECT films.id,films.title,films.synopsis,users.username,films.id_user FROM films, users WHERE films.id_user=users.id'); 
$req->execute();
$films = $req->fetchAll();

foreach ($films as $film) {
     ?>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title"><?php echo $film->title  ?></h5>
            <p class="card-text"><?php echo $film->synopsis  ?></p>
            <p class="card-text">Proposé par :<?php echo $film->username ?></p>
            <?php
            if ($_SESSION['auth']->id == $film->id_user) { ?>
                <a href="update.php?id=<?php echo $film->id ?>" class="btn btn-primary">Éditer ce film</a>
                <a href="delete.php?id=<?php echo $film->id ?>" class="btn btn-danger">Supprimer ce film</a>
            <?php
            } ?>
        </div>
    </div>

<?php
}
