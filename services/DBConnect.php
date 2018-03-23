<?php
/**
 * Created by PhpStorm.
 * User: jhaudry
 * Date: 20/03/2018
 * Time: 23:14
 */

namespace Dico\Services;


class DBConnect
{
    private $db;

    public function __construct($settings)
    {
        try
        {
            $dsn = 'mysql:host=' . $settings['appHost'] . ':' . $settings['port'] . ';dbname=' . $settings['dbname'] . ';charset=utf8';
            $username = $settings['user'];
            $password = $settings['password'];
            $this->db = new \PDO($dsn, $username, $password);
        }
        catch (\Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        return $this->db;
    }

    public function getPDO()
    {
        return $this->db;
    }

}