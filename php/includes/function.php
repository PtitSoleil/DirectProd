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
 * Fonction qui affiche tout les annonces
 *
 * @return void
 */
function showAllAdverts()
{
    $db = EDatabase::getInstance();

    echo '<table class="table table-striped table-hover border border-dark border-3">
          <thead class="thead-dark">
          <tr>
            <th scope="col"> Image </th>
            <th scope="col"> Titre </th>
            <th scope="col"> Description </th>
            <th scope="col"> Bio </th>
            <th scope="col"> Nombre avis </th>
            <th scope="col"> Moyenne avis </th>
            <th scope="col"> Ville / Canton </th>
          </tr>;
          </thead>
          <tbody>';


    try {
        foreach ($db->query('SELECT *
        FROM user s
        INNER JOIN advertisement a
            on s.iduser = a.iduser
        INNER JOIN picture p
            on a.idAdvertisement = p.idAdvertisement;') as $row) {
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

    echo '<table class="table table-striped table-hover border border-dark border-3">
          <thead class="thead-dark">
          <tr>
            <th scope="col"> Image </th>
            <th scope="col"> Titre </th>
            <th scope="col"> Description </th>
            <th scope="col"> Bio </th>
            <th scope="col"> Nombre avis </th>
            <th scope="col"> Moyenne avis </th>
            <th scope="col"> Ville / Canton </th>
          </tr>;
          </thead>
          <tbody>';


    try {
        foreach ($db->query('SELECT *
        FROM user s
        INNER JOIN advertisement a
            on s.iduser = a.iduser
        INNER JOIN picture p
            on a.idAdvertisement = p.idAdvertisement;') as $row) {
                if($row['idUser'] == $_SESSION['id']){
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
                  </tr>';
        }
    }

    } catch (PDOException $ex) {
        echo 'An Error occured!'; // user friendly message
        error_log($ex->getMessage());
    }

    echo '</table>';
}