
<?php
/**
 * @description : register
 * @version 1.0.0
 * @since 26.05.20
 * @author Adar Güner
 */

require_once __DIR__ . '/php/includes/incAll/inc.all.php';



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.min.css">
    <script src="https://kit.fontawesome.com/c89edac6b7.js" crossorigin="anonymous"></script>
</head>

<body>
<?php include_once './php/includes/navbar.php'; ?>

    <div class="m-auto w-50">
        <form method='post' action="" class="mt-4">
            <div class="form-group">
                <label for="email">Addresse mail</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Entrer votre email">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="form-group">
                <label for="lastname">Rue et numéro</label>
                <input type="lastname" class="form-control" id="streetAndNumber" name="streetAndNumber" placeholder="Rue et numéro">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="form-group">
                <label for="firstname">Canton</label>
                <input type="firstname" class="form-control" id="canton" name="canton" placeholder="Canton">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="form-group">
                <label for="password">Code Postal</label>
                <input type="password" class="form-control" id="postCode" name="postCode" placeholder="Code Postal">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Ville</label>
                <input type="password" class="form-control" id="city" name="city" placeholder="Ville">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Description</label>
                <textarea class="form-control" aria-label="With textarea" id="description" name="description" placeholder="Description" ></textarea>
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirmez votre mot de passe</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirmez votre mot de passe">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <button type="submit" name="register" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>