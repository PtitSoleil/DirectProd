<?php
/**
 * @description : Page d'accueil
 * @version 1.0.0
 * @since 05.06.20
 * @author Adar Güner
 */

require_once __DIR__ . '/php/includes/incAll/inc.all.php';

$word = "";

if (filter_has_var(INPUT_POST, 'word')) {

    $word = filter_input(INPUT_POST, 'word', FILTER_SANITIZE_STRING);

    $research = researchAdvert($word);
        
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

        <title>Rechercher une annonce</title>
    </head>

    <body>
        <?php include_once './php/includes/navbar.php'; ?>

        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <div class="card-header text-light" style="background-color: #1e281e"><h4>Rechercher une annonce</h4></div>
                        <div class="card-body">
                            <form method='post' action="">
                                <div class="form-group">
                                    <label for="title"><h5>Mot-Clé :</h5></label>
                                    <input type="title" class="form-control <?= !empty($errors['word']) ? 'is-invalid' : '' ?>" id="word" name="word" placeholder="Entrer un mot-clé">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="research" class="form-control btn text-light">Rechercher</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <div class="card-header text-light" style="background-color: #1e281e"><h4>Résultat(s)</h4></div>
                        <div class="card-body p-0 m-0">
                            <?php showResearchAdvert($word); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>
    </body>
</html>