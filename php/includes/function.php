<?php
/**
 * @description : fichier des fonctions
 * @version 1.0.0
 * @since 26.05.20
 * @author Adar Güner
 */

/**
 * Fonction qui vérifie si on est connecté ou non
 *
 * @return boolean
 */
function isLogged()
{
    return isset($_SESSION['connect']);
}

/**
 * Inscrit un utilisateur dans la base
 *
 * @param [type] $password          Le mot de passe
 * @param [type] $email             L'addresse email
 * @param [type] $city              La ville
 * @param [type] $canton            Le canton
 * @param [type] $postCode          Le code postal
 * @param [type] $streetAndNumber   La rue et le numéro
 * @param [type] $isAdmin           Son rôle
 * @param [type] $description       Sa description
 * @return void
 */
function inscription($password, $email, $city, $canton, $postCode, $streetAndNumber, $isAdmin, $description) {
    $db = EDatabase::getInstance();
    try {
        $db->query('INSERT INTO directproddb.user (password,email,city,canton,postCode,streetAndNumber,isAdmin,description) VALUES ("' . password_hash($password, PASSWORD_DEFAULT) . '","' . $email . '","' . $city . '","' . $canton . '","' . $postCode . '","' . $streetAndNumber . '",' . $isAdmin . ',"' . $description . '")');
        header("Location: ./index.php");
    } catch (PDOException $ex) {
        echo "An Error occured!"; // user friendly message
        error_log($ex->getMessage());
    }
}

/**
 * Vérifie l'email
 *
 * @param [type] $emailParam    l'email
 * @return void
 */
function userVerify($emailParam){
    try {
        $s = "SELECT email FROM user WHERE user.email = :email";
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':email' => $emailParam));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return count($result)==1;

    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
        return false;
    }
}

/**
 * Vérifie le mot de passe
 *
 * @param [type] $emailParam    l'email
 * @param [type] $pwdParam      le mot de passe
 * @return void
 */
function pwdVerify($emailParam, $pwdParam){
    try {
        $password_ok = false;

        $s = 'SELECT * FROM user WHERE user.email=?';
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array($emailParam));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        

        if (password_verify($pwdParam, $result["password"])) {
            $password_ok = true;
            $_SESSION['id'] = $result['idUser'];
            $_SESSION['admin'] = $result['isAdmin'];
        }

        return $password_ok;
    }  catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            return false;
        }
}


function createAdvert($title, $description, $organic, $isValid, $idUser, $finalFileName) {
    $db = EDatabase::getInstance();
    try {
        $db->query('INSERT INTO directproddb.advertisement (title,description,organic,isValid,idUser) VALUES ("' . $title . '","' . $description . '","' . $organic . '","' . $isValid . '","' . $idUser . '")');
        $lastInsertId = EDatabase::getInstance()->lastInsertId();
        $db->query('INSERT INTO directproddb.picture (path,idAdvertisement) VALUES ("' . $finalFileName . '","'. $lastInsertId .'")');
        header("Location: ./index.php");
    } catch (PDOException $ex) {
        echo "An Error occured!"; // user friendly message
        error_log($ex->getMessage());
    }
}

/**
 * Fonction qui affiche tout les annonces validés
 *
 * @return void
 */
function showAllAdverts()
{
    $db = EDatabase::getInstance();

    echo '<table class="table text-center">
          <thead style="background-color: #1e281e">
          <tr class="text-light">
            <th scope="col"> Image </th>
            <th scope="col"> Titre </th>
            <th scope="col"> Description </th>
            <th scope="col"> Etat </th>
            <th scope="col"> Nombre avis </th>
            <th scope="col"> Moyenne avis </th>
            <th scope="col"> Ville / Canton </th>
            <th scope="col"> Action </th>
          </tr>
          </thead>
          <tbody>';


    try {
        foreach ($db->query('SELECT p.path, a.title, a.description, a.organic, u.canton, u.city, a.idAdvertisement
        FROM user u
        INNER JOIN advertisement a
            on u.iduser = a.iduser
        INNER JOIN picture p
            on a.idAdvertisement = p.idAdvertisement WHERE a.isValid = 2
            ORDER BY a.title ASC;') as $row) {
            echo '<tr>
                  <td><img class="card-img-top"alt="' . $row['path'] . '" src="./uploads/' . $row['path'] . '"></td> 
                  <td>' . $row['title'] . '</td> 
                  <td>' . $row['description'] . '</td>';
                  if($row['organic'] == ORGANIC){
                     echo '<td>Bio</td>';
                  }else{
                    echo '<td>Pas Bio</td>';
                  }
            echo '<td></td>
                  <td></td>
                  <td>' . $row['city'].' / '. $row['canton'] . '</td>
                  <td><a class="nav-link" href="detailsAdvert.php?idAdvertisement='. $row['idAdvertisement'] . '"> <i class="fas fa-info-circle"></i></a></td>
                  </tr>';
        }

    } catch (PDOException $ex) {
        echo 'An Error occured!'; // user friendly message
        error_log($ex->getMessage());
    }

    echo '</table>';
}

/**
 * Fonction qui affiche tout les annonces
 *
 * @return void
 */
function showMyAdverts()
{
    $db = EDatabase::getInstance();

    echo '<table class="table text-center">
          <thead style="background-color: #1e281e">
          <tr class="text-light">
            <th scope="col"> Image </th>
            <th scope="col"> Titre </th>
            <th scope="col"> Description </th>
            <th scope="col"> Etat </th>
            <th scope="col"> Nombre avis </th>
            <th scope="col"> Moyenne avis </th>
            <th scope="col"> Ville / Canton </th>
            <th scope="col"> Action </th>
          </tr>
          </thead>
          <tbody>';


    try {
        foreach ($db->query('SELECT p.path, a.title, a.description, a.organic, u.canton, u.city, a.idAdvertisement, u.idUser
        FROM user u
        INNER JOIN advertisement a
            on u.iduser = a.iduser
        INNER JOIN picture p
            on a.idAdvertisement = p.idAdvertisement
            ORDER BY a.title ASC;') as $row) {
                if($row['idUser'] == $_SESSION['id']){
                    echo '<tr>
                    <td><img class="card-img-top" alt="' . $row['path'] . '" src="./uploads/' . $row['path'] . '"></td> 
                    <td>' . $row['title'] . '</td> 
                    <td>' . $row['description'] . '</td>';
                    if($row['organic'] == ORGANIC){
                       echo '<td>Bio</td>';
                    }else{
                      echo '<td>Pas Bio</td>';
                    }
              echo '<td></td>
                    <td></td>
                    <td>' . $row['city'].' / '. $row['canton'] . '</td>
                    <td><a class="nav-link" href="editAdvert.php?idAdvertisement='.$row['idAdvertisement'].'"> <i class="fas fa-edit"></i></a>
                        <a class="nav-link" href="detailsAdvert.php?idAdvertisement='. $row['idAdvertisement'] . '"> <i class="fas fa-info-circle"></i></a></td>
                    </tr>';
        }
    }

    } catch (PDOException $ex) {
        echo 'An Error occured!'; // user friendly message
        error_log($ex->getMessage());
    }

    echo '</table>';
}

/**
 * Fonction qui affiche les détails d'une annonce pour le modifier
 *
 * @param [type] $idAdvertisement   l'id de l'annonce
 * @return void
 */
function showUpdateInfo($idAdvertisement) {
    $db = EDatabase::getInstance();        
    try {
        $s = 'SELECT idAdvertisement, title, description, organic, isValid, idUser FROM directproddb.advertisement WHERE idAdvertisement = :idAdvertisement';
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':idAdvertisement' => $idAdvertisement));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($result)){
            return $result[0];
        }

    } catch (PDOException $ex) {
}}

/**
 * Fonction qui modifie une annonce
 *
 * @param [type] $idAdvertisement   l'id de l'annonce
 * @param [type] $title             son titre
 * @param [type] $description       sa description 
 * @param [type] $organic           s'il est bio ou non
 * @param [type] $isValid           s'il est valid ou non
 * @return void
 */
function updateAdvert($idAdvertisement, $title, $description, $organic, $isValid) {
    $db = EDatabase::getInstance();
    try {
        $db->query('UPDATE directproddb.advertisement SET title = "'.$title.'", description = "'.$description.'", organic = "'.$organic.'", isValid = "'.$isValid.'" WHERE idAdvertisement = "'.$idAdvertisement.'"');        
        header("Location: ./myAdvert.php");
    } catch (PDOException $ex) {
        echo "An Error occured!"; // user friendly message
        error_log($ex->getMessage());
    }}

/**
 * Fonction qui supprime une annonce
 *
 * @param [type] $idAdvertisement   id de l'annonce
 * @return void
 */
function deleteAdvert($idAdvertisement) {
    $db = EDatabase::getInstance();
    try {
        $db->query('DELETE from directproddb.picture where idAdvertisement = "'.$idAdvertisement.'"');
        $db->query('DELETE from directproddb.advertisement where idAdvertisement = "'.$idAdvertisement.'"');
        header("Location: ./myAdvert.php");
    } catch (PDOException $ex) {
        echo "An Error occured!"; // user friendly message
        error_log($ex->getMessage());
    }
}

/**
 * Fonction qui affiche une annonce
 *
 * @param [type] $idAdvertisement
 * @return void
 */
function showDetailsAdvert($idAdvertisement) {
    $db = EDatabase::getInstance();        
    try {
        $s = 'SELECT * FROM user s INNER JOIN advertisement a on s.iduser = a.iduser INNER JOIN picture p on a.idAdvertisement = p.idAdvertisement WHERE a.idAdvertisement = :idAdvertisement';
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':idAdvertisement' => $idAdvertisement));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($result)){
            return $result[0];
        }

    } catch (PDOException $ex) {
    }
}

/**
 * Fonctio qui créer un avis pour une annonce
 *
 * @param [type] $note              Note de l'annonce
 * @param [type] $comment           Son commentaire
 * @param [type] $date              La date ou il y a évaluer l'annonce
 * @param [type] $idUser            l'id de l'utilisateur
 * @param [type] $idAdvertisement   l'id de l'annonce
 * @return void
 */
function evaluateAdvert($note, $comment, $date, $idUser, $idAdvertisement) {
    $db = EDatabase::getInstance();        
    try {
        $db->query('INSERT INTO directproddb.rate (rating,comment,date,idUser,idAdvertisement) VALUES ("' . $note . '","' . $comment . '","' . $date . '","' . $idUser . '","' . $idAdvertisement . '")');
        header("Location: ./index.php");
    } catch (PDOException $ex) {
        echo "An Error occured!"; // user friendly message
        error_log($ex->getMessage());
    }
}

/**
 * Fonction qui affiche les avis
 *
 * @param [type] $idAdvertisement
 * @return void
 */
function showRate($idAdvertisement) {
    $db = EDatabase::getInstance();        
    try {
        foreach ($db->query('SELECT r.rating, r.comment, r.idUser, r.idAdvertisement, u.email
        FROM rate r
        INNER JOIN user u
            on r.iduser = u.iduser;') as $row) {
            if($row['idAdvertisement'] == $idAdvertisement){
                echo '<div class="row mb-1" style="border-bottom: 1px solid #1e281e;">
                        <div class="col">
                            <label for="userComment"><h5>'.explode("@", $row['email'])[0].'</h5></label>   
                            <p class="card-text ml-auto">'. $row["comment"].'</p>
                            <p class="card-text mr-auto">Note : '. $row["rating"].'</p>
                        </div>
                       </div>';
            }
        }
    } catch (PDOException $ex) {
        echo "An Error occured!"; // user friendly message
        error_log($ex->getMessage());
    }
}

/**
 * Fonction qui affiche les détails de l'utilisateur
 *
 * @param [type] $idUser   l'id de l'utilisateur
 * @return void
 */
function showDetailsUser($idUser) {
    $db = EDatabase::getInstance();        
    try {
        $s = 'SELECT idUser, password, email, city, canton, streetAndNumber, postCode, description FROM directproddb.user WHERE idUser = :idUser';
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':idUser' => $idUser));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($result)){
            return $result[0];
        }

    } catch (PDOException $ex) {
}}

/**
 * Modifie un utilisateur dans la base
 *
 * @param [type] $password          Le mot de passe
 * @param [type] $email             L'addresse email
 * @param [type] $city              La ville
 * @param [type] $canton            Le canton
 * @param [type] $postCode          Le code postal
 * @param [type] $streetAndNumber   La rue et le numéro
 * @param [type] $isAdmin           Son rôle
 * @param [type] $description       Sa description
 * @return void
 */
function updateUser($password, $email, $city, $canton, $postCode, $streetAndNumber, $isAdmin, $description, $idUser) {
    $db = EDatabase::getInstance();
    try {
        $db->query('UPDATE directproddb.user SET password = "'.$password.'", email = "'.$email.'", canton = "'.$canton.'", postCode = "'.$postCode.'", streetAndNumber = "'.$streetAndNumber.'", isAdmin = "'.$isAdmin.'", description = "'.$description.'" WHERE idUser = "'.$idUser.'"');        
        header("Location: ./profile.php?idUser=".$idUser);
    } catch (PDOException $ex) {
        echo "An Error occured!"; // user friendly message
        error_log($ex->getMessage());
    }}

/**
 * Fonction qui affiche les annonces recherchés
 *
 * @return void
 */
function researchAdvert($word)
{
    $db = EDatabase::getInstance();
    try {
        $s = 'SELECT p.path, a.title, a.description, a.organic, u.canton, u.city, a.idAdvertisement, u.idUser
        FROM user u
        INNER JOIN advertisement a
            on u.iduser = a.iduser
        INNER JOIN picture p
            on a.idAdvertisement = p.idAdvertisement
		WHERE isValid = 2
        AND (a.title LIKE :word
		OR a.description LIKE :word
        OR u.canton LIKE :word
        OR u.city LIKE :word)
        ORDER BY a.title ASC';
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':word' => "%".$word."%"));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($result)){
            return $result;
        }
    } catch (PDOException $ex) {
        echo 'An Error occured!'; // user friendly message
        error_log($ex->getMessage());
    }
}

/**
 * Fonction qui affiche tout les annonces
 *
 * @return void
 */
function showResearchAdvert($word)
{
    $research = researchAdvert($word);

    if(!empty($research)){
    echo '<table class="table text-center">
    <thead style="background-color: #1e281e">
    <tr class="text-light">
      <th scope="col"> Image </th>
      <th scope="col"> Titre </th>
      <th scope="col"> Description </th>
      <th scope="col"> Etat </th>
      <th scope="col"> Nombre avis </th>
      <th scope="col"> Moyenne avis </th>
      <th scope="col"> Ville / Canton </th>
      <th scope="col"> Action </th>
    </tr>
    </thead>
    <tbody>';

    
    
    foreach ($research as $r){
        echo '<tr>
                  <td><img class="card-img-top"alt="' . $r['path'] . '" src="./uploads/' . $r['path'] . '"></td> 
                  <td>' . $r['title'] . '</td> 
                  <td>' . $r['description'] . '</td>';
                  if($r['organic'] == ORGANIC){
                     echo '<td>Bio</td>';
                  }else{
                    echo '<td>Pas Bio</td>';
                  }
            echo '<td></td>
                  <td></td>
                  <td>' . $r['city'].' / '. $r['canton'] . '</td>
                  <td><a class="nav-link" href="detailsAdvert.php?idAdvertisement='. $r['idAdvertisement'] . '"> <i class="fas fa-info-circle"></i></a></td>
                  </tr>';
        }
        }
        else{
            echo '<h1>Aucun résultat</h1>';
        }
    }

/**
 * Fonction qui affiche tout les annonces non-validés
 *
 * @return void
 */
function showAllAdvertsNotValid()
{
    $db = EDatabase::getInstance();

    echo '<table class="table text-center">
          <thead style="background-color: #1e281e">
          <tr class="text-light">
            <th scope="col"> Image </th>
            <th scope="col"> Titre </th>
            <th scope="col"> Description </th>
            <th scope="col"> Etat </th>
            <th scope="col"> Ville / Canton </th>
            <th scope="col"> Validation </th>
          </tr>
          </thead>
          <tbody>';


    try {
        foreach ($db->query('SELECT p.path, a.title, a.description, a.organic, u.canton, u.city, a.idAdvertisement
        FROM user u
        INNER JOIN advertisement a
            on u.iduser = a.iduser
        INNER JOIN picture p
            on a.idAdvertisement = p.idAdvertisement WHERE a.isValid = 1;') as $row) {
            echo '<tr>
                  <td><img class="card-img-top"alt="' . $row['path'] . '" src="./uploads/' . $row['path'] . '"></td> 
                  <td>' . $row['title'] . '</td> 
                  <td>' . $row['description'] . '</td>';
                  if($row['organic'] == ORGANIC){
                     echo '<td>Bio</td>';
                  }else{
                    echo '<td>Pas Bio</td>';
                  }
            echo '<td>' . $row['city'].' / '. $row['canton'] . '</td>
                  <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="isValid" name="isValid">
                    </div>
                  </td>
                  </tr>';
        }

    } catch (PDOException $ex) {
        echo 'An Error occured!'; // user friendly message
        error_log($ex->getMessage());
    }

    echo '</table>';
}

/**
 * Fonction qui affiche tout les annonces non-validés
 *
 * @return void
 */
function showAllUsers()
{
    $db = EDatabase::getInstance();

    echo '<table class="table text-center">
          <thead style="background-color: #1e281e">
          <tr class="text-light">
            <th scope="col"> Email </th>
            <th scope="col"> Description </th>
            <th scope="col"> Admin </th>
          </tr>
          </thead>
          <tbody>';


    try {
        foreach ($db->query('SELECT idUser, email, description, isAdmin FROM user;') as $row) {
            echo '<tr>
                  <td>' . $row['email'] . '</td> 
                  <td>' . $row['description'] . '</td>';
                  if($row['isAdmin'] == ADMIN){
                    echo '<td><input type="radio" name="isAdmin'.$row['idUser'].'" checked ></td>';
                     }else{
                   echo '<td><input type="radio" name="isAdmin'.$row['idUser'].'"></td>';
                 }
                  echo '</tr>';
        }

    } catch (PDOException $ex) {
        echo 'An Error occured!'; // user friendly message
        error_log($ex->getMessage());
    }

    echo '</table>';
}

function validedAdvert($idAdvertisement, $isValid) {
    $db = EDatabase::getInstance();
    try {
        $db->query('UPDATE directproddb.advertisement SET isValid = "'.$isValid.'" WHERE idAdvertisement = "'.$idAdvertisement.'"');        
        header("Location: ./administration.php");
    } catch (PDOException $ex) {
        echo "An Error occured!"; // user friendly message
        error_log($ex->getMessage());
}}


function updatePrivilegeUser($idUser, $isAdmin) {
        $db = EDatabase::getInstance();
        try {

        } catch (PDOException $ex) {
            echo "An Error occured!"; // user friendly message
            error_log($ex->getMessage());
}}