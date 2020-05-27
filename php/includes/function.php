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
function pwdVerify($emailParam, $pwdParam)
{
    try {
        $password_ok = false;

        $s = 'SELECT password FROM user WHERE user.email=?';
        $statement = EDatabase::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array($emailParam));
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (password_verify($pwdParam, $result["password"])) {
            $password_ok = true;
        }

        return $password_ok;
    }  catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
            return false;
        }
    }
