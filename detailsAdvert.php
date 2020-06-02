<?php
/**
 * @description : Détails d'une annonce
 * @version 1.0.0
 * @since 27.05.20
 * @author Adar Güner
 */

 require_once __DIR__ . '/php/includes/incAll/inc.all.php';

$idAdvertisement = FILTER_INPUT(INPUT_GET,"idAdvertisement",FILTER_VALIDATE_INT);

$advertisement = showDetailsAdvert($idAdvertisement);

if (filter_has_var(INPUT_POST, 'evaluateAdvert')) {

    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_NUMBER_INT);
    $date = date('Y-m-d H:i:s');
    $idUser = $_SESSION['id'];

    if (empty($comment)) {
        $errors["comment"] = "Le commentaire est vide";
    }

    if (empty($errors) ) {        
        evaluateAdvert($note, $comment, $date, $idUser, $idAdvertisement);
        
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/style.css">
        <script src="https://kit.fontawesome.com/c89edac6b7.js" crossorigin="anonymous"></script>

        <title>Accueil</title>
    </head>

    <body>
        <?php include_once './php/includes/navbar.php'; ?>
        <div class="container border mt-5">
            <div class="row">
                <div class="col-sm-5">
                    <img class="card-img-top" alt="<?php echo $advertisement['path'] ?>" src="./uploads/<?php echo $advertisement['path'] ?>">
                </div>
                <div class="col-sm-7">
                    <h1 class="card-title"><?php echo $advertisement['title'] ?></h1>
                    <p class="card-text"><?php echo $advertisement['description'] ?></p>
                </div>
            </div>
            <?php if ($_SESSION['id'] !== $advertisement['idUser']): ?>
            <div class="row">
                <div class="col">
                    <form method='post' action="" class="mt-4" enctype="multipart/form-data">
                        <div class="form-group">
                        <label for="comment">Commentaire</label>
                        <input type="comment" class="form-control <?= !empty($errors['comment']) ? 'is-invalid' : '' ?>" id="comment" name="comment" placeholder="Entrer votre commentaire">
                        <div class="invalid-feedback">
                            <?= !empty($errors['comment']) ? $errors['comment'] : '' ?>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="note">Note</label>
                    <input type="number" id="note" name="note" min="0" max="5">
                    </div>
                    <button type="submit" name="evaluateAdvert" class="btn btn-primary">Evaluer l'annonce</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
            </div>
            <div class="container border mt-2">
            <?php showRate($idAdvertisement) ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>
    </body>
</html>