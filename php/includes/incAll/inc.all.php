<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * INCLUDE DE LA CONNEXION A LA BDD
 */
require_once __DIR__ . '/../../server/database.php';

/**
 * INCLUDE DES FONCTIONS
 */
require_once __DIR__ . '/../function.php';