<?php

/**
 * Class ConnexionBdd
 */
class ConnexionBdd
{
    public function connect()
    {
        return new PDO('mysql:host=localhost;dbname=blog;charset=utf8;port=8889', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) );
    }
}