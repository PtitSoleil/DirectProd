<?php
/**
 * @description : Page de profil
 * @version 1.0.0
 * @since 05.06.20
 * @author Adar Güner
 */

require_once __DIR__ . '/php/includes/incAll/inc.all.php';

if(!isLogged()) {
    header("Location: ./index.php");
}

$idUser = FILTER_INPUT(INPUT_GET, "idUser",FILTER_VALIDATE_INT);

$user = showDetailsUser($idUser);

if($_SESSION['id'] !== $user['idUser']){
    header("Location: ./index.php");
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

        <title>Profil</title>
    </head>

    <body>
        <?php include_once './php/includes/navbar.php'; ?>

        <div class="container mt-5 text-center">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card-header text-light text-center" style="background-color: #1e281e"><h1><?php echo $user['email'] ?></h1></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title">Rue et numéro</h3>
                                <p class="card-text"><?php echo $user['streetAndNumber'] ?></p>
                                <h3 class="card-title">Canton</h3>
                                <p class="card-text"><?php echo $user['canton'] ?></p>
                            </div>
                            <div class="col">
                                <h3 class="card-title">Code Postal</h3>
                                <p class="card-text"><?php echo $user['postCode'] ?></p>
                                <h3 class="card-title">Ville</h3>
                                <p class="card-text"><?php echo $user['city'] ?></p>
                            </div>
                        </div>
                        <h3 class="card-title">Description</h3>
                        <p class="card-text"><?php echo $user['description'] ?></p>
                        <div class="form-group mt-2">
                            <a href="./editProfile.php?idUser=<?php echo $_SESSION['id']?>" class="form-control btn text-light">Modifier le profil</a>
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