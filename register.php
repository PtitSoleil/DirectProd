
<?php
/**
 * @description : register
 * @version 1.0.0
 * @since 27.05.20
 * @author Adar Güner
 */

require_once __DIR__ . '/php/includes/incAll/inc.all.php';

if(isLogged()) {
    header("Location: ./index.php");
}

if (filter_has_var(INPUT_POST, 'register')) {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $streetAndNumber = filter_input(INPUT_POST, 'streetAndNumber', FILTER_SANITIZE_STRING);
    $canton = filter_input(INPUT_POST, 'canton', FILTER_SANITIZE_STRING);
    $postCode = filter_input(INPUT_POST, 'postCode', FILTER_SANITIZE_NUMBER_INT);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $isAdmin = USER;
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_STRING);

    if (empty($email)) {
        $errors["email"] = "L'email est vide";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Le format de l'email est incorrect";
    }

    if (empty($streetAndNumber)) {
        $errors["streetAndNumber"] = "La rue et le numéro sont vide";
    }

    if (empty($canton)) {
        $errors["canton"] = "Le canton est vide";
    }

    if (empty($postCode)) {
        $errors["postCode"] = "Le code postal est vide";
    }

    if (empty($city)) {
        $errors["city"] = "La ville est vide";
    }

    if (empty($description)) {
        $errors["description"] = "La description est vide";
    }

    if (empty($password)) {
        $errors["password"] = "Le mot de passe est vide";
    }

    if (empty($confirmPassword)) {
        $errors["confirmPassword"] = "Le mot de passe de confirmation est vide";
    }

    if ($password != $confirmPassword) {
        $errors["password"] = "Le mot de passe n'est pas identique";
        $errors["confirmPassword"] = "Le mot de passe n'est pas identique";
    }

    if (empty($errors)) {
        inscription($password, $email, $city, $canton, $postCode, $streetAndNumber, $isAdmin, $description);
    }
}

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
                <input type="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>" id="email" name="email" aria-describedby="emailHelp" placeholder="Entrer votre email">
                <div class="invalid-feedback">
                    <?= !empty($errors['email']) ? $errors['email'] : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for="streetAndNumber">Rue et numéro</label>
                <input type="streetAndNumber" class="form-control <?= !empty($errors['streetAndNumber']) ? 'is-invalid' : '' ?>" id="streetAndNumber" name="streetAndNumber" placeholder="Rue et numéro">
                <div class="invalid-feedback">
                    <?= !empty($errors['streetAndNumber']) ? $errors['streetAndNumber'] : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for="canton">Canton</label>
                <input type="canton" class="form-control <?= !empty($errors['canton']) ? 'is-invalid' : '' ?>" id="canton" name="canton" placeholder="Canton">
                <div class="invalid-feedback">
                    <?= !empty($errors['canton']) ? $errors['canton'] : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for="postCode">Code Postal</label>
                <input type="postCode" class="form-control <?= !empty($errors['postCode']) ? 'is-invalid' : '' ?>" id="postCode" name="postCode" placeholder="Code Postal">
                <div class="invalid-feedback">
                    <?= !empty($errors['postCode']) ? $errors['postCode'] : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for="city">Ville</label>
                <input type="city" class="form-control <?= !empty($errors['city']) ? 'is-invalid' : '' ?>" id="city" name="city" placeholder="Ville">
                <div class="invalid-feedback">
                    <?= !empty($errors['city']) ? $errors['city'] : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control <?= !empty($errors['description']) ? 'is-invalid' : '' ?>" aria-label="With textarea" id="description" name="description" placeholder="Description" ></textarea>
                <div class="invalid-feedback">
                    <?= !empty($errors['description']) ? $errors['description'] : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Mot de passe">
                <div class="invalid-feedback">
                    <?= !empty($errors['password']) ? $errors['password'] : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirmez votre mot de passe</label>
                <input type="password" class="form-control <?= !empty($errors['confirmPassword']) ? 'is-invalid' : '' ?>" id="confirmPassword" name="confirmPassword" placeholder="Confirmez votre mot de passe">
                <div class="invalid-feedback">
                    <?= !empty($errors['confirmPassword']) ? $errors['confirmPassword'] : '' ?>
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