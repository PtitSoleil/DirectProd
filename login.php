<?php
/**
 * @description : login
 * @version 1.0.0
 * @since 26.05.20
 * @author Adar Güner
 */

require_once __DIR__ . '/php/includes/incAll/inc.all.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isLogged()) {
    header("Location: ./index.php");
}

$email = "";
$password = "";
$errors = array();
$errorExist = false;

if (filter_has_var(INPUT_POST, 'login')) {

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);


    if(empty($email)){
        $errorEmpty = true;
        $errors['email'] = "L'email est vide";
    }
    if(empty($password)){
        $errorEmpty = true;
        $errors['password'] = "Le mot de passe est vide";
    }

    if(!$errorEmpty){
        if (userVerify($email)) {
            if (pwdVerify($email, $password)) {
                $_SESSION['email'] = $email;
                $_SESSION['logged'] = TRUE;
                $_SESSION['connect'] = true;
                $_SESSION['username'] = explode("@", $email)[0];
                header("Location:./index.php");
                exit;
            } else {
                $errors['password'] = "Mot de passe incorrect";
            }
        } else {
            $errors['email'] = "Email inconnu";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.min.css">
    <script src="https://kit.fontawesome.com/c89edac6b7.js" crossorigin="anonymous"></script>
</head>

<body>
<?php include_once './php/includes/navbar.php'; ?>

    <div class="m-auto w-50">
        <form method='post' action="" class="mt-4">
            <div class="form-group">
                <label for="email">Adresse mail</label>
                <input type="email" value="<?= $email ?>" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" aria-describedby="emailHelp" placeholder="Entrer votre email">
                <div class="invalid-feedback">
                    <?= !empty($errors['email']) ? $errors['email'] : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Mot de passe">
                <div class="invalid-feedback">
                    <?= !empty($errors['password']) ? $errors['password'] : '' ?>
                </div>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Se connecter</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>