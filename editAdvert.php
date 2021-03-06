<?php
/**
 * @description : Page d'accueil
 * @version 1.0.0
 * @since 05.06.20
 * @author Adar Güner
 */

require_once __DIR__ . '/php/includes/incAll/inc.all.php';

$idAdvertisement = FILTER_INPUT(INPUT_GET,"idAdvertisement",FILTER_VALIDATE_INT);

$advertisement = showUpdateInfo($idAdvertisement);


if(!isLogged()) {
    header("Location: ./index.php");
}

 if($_SESSION['id'] !== $advertisement['idUser']){
     header("Location: ./index.php");
 }


if (filter_has_var(INPUT_POST, 'modifyAdvert')) {

    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $organic = NOT_ORGANIC;
    $isValid = INVALID;
    $fichiers = $_FILES['imgFile'];

    if($fichiers['error']<=0) {
        $tmpName = $_FILES['imgFile']['tmp_name'];
        $fileName = $_FILES['imgFile']['name'];
        $fileName = preg_replace('/[^a-z0-9\.\-]/ i','',$fileName);
        $splitName = explode(".", $fileName);
        $newName = uniqid();
        $finalFileName = $newName . "." . $splitName[1];
        move_uploaded_file($tmpName,'./uploads/'.$finalFileName);
        unlink("./uploads/".$advertisement['path']);
    }else{
        $finalFileName = $advertisement['path'];
    }

    if (empty($title)) {
        $errors["title"] = "Le titre est vide";
    }

    if (empty($description)) {
        $errors["description"] = "La description est vide";
    }
    
    if( empty($_POST["organic"]) ) {
        $organic = NOT_ORGANIC; 
    }
    else { 
        $organic = ORGANIC; ; 
    }

    if (empty($errors) ) {        
        updateAdvert($idAdvertisement, $title, $description, $organic, $isValid, $finalFileName);
        
    }
}
if (filter_has_var(INPUT_POST, 'deleteAdvert')) {
    if($advertisement['path'] !== "noImage.png"){
        unlink("./uploads/".$advertisement['path']);
    }
    deleteAdvert($idAdvertisement);   
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

        <title>Modifier annonce</title>
    </head>

    <body>
        <?php include_once './php/includes/navbar.php'; ?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <div class="card-header text-light" style="background-color: #1e281e"><h4>Modifier l'annonce</h4></div>
                        <div class="card-body">
                            <form method='post' action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="title">Titre</label>
                                    <input type="title" class="form-control <?= !empty($errors['title']) ? 'is-invalid' : '' ?>" value="<?php echo $advertisement['title'] ?>" id="title" name="title" placeholder="Entrer un titre">
                                    <div class="invalid-feedback">
                                        <?= !empty($errors['title']) ? $errors['title'] : '' ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control <?= !empty($errors['description']) ? 'is-invalid' : '' ?>" aria-label="With textarea" id="description" name="description" placeholder="Description" ><?php echo $advertisement['description'] ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= !empty($errors['description']) ? $errors['description'] : '' ?>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <?php if ($advertisement['organic'] == ORGANIC): ?>
                                    <input type="checkbox" class="form-check-input" id="organic" name="organic" checked>
                                    <?php else: ?>
                                    <input type="checkbox" class="form-check-input" id="organic" name="organic">
                                    <?php endif; ?>
                                    <label class="form-check-label" for="organic">Bio</label>
                                </div>
                                <div class="custom-file mt-2 mb-2">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
                                    <input class="custom-file-input" type="file" name="imgFile" id="imgFile" accept="image/*">
                                    <label class="custom-file-label" for="imgFile" aria-describedby="inputGroupFileAddon02">Choisissez une image</label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="modifyAdvert" class="form-control btn text-light">Modifier l'annonce</button>
                                    <button type="submit" name="deleteAdvert" class="form-control btn-danger btn text-light">Supprimer l'annonce</button>
                                </div>
                            </form>
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