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