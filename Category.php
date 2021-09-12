<?php
require 'ConnexionBdd.php';

/**
 * Class Category
 */
class Category
{
    protected $name, $description, $created_at;

    /**
     * Category constructor.
     * @param $name
     * @param $description
     */
    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
        date_default_timezone_set("Europe/Paris");
        $this->created_at = date("Y-m-d H:i:s", time());
    }

    /**
     * @return string
     */
    public function store()
    {
        try
        {
            $bdd = ConnexionBdd::connect();

            $insert = $bdd->prepare("INSERT INTO category(name, description, created_at) VALUES (?,?,?)");
            $insert->execute(array($this->name, $this->description, $this->created_at));
            $insert->closeCursor();
        }
        catch (\Exception $exception)
        {
            return $exception->getMessage();
        }
    }

    /**
     * @return false|PDOStatement|string
     */
    public function index()
    {
        try
        {
            $bdd = ConnexionBdd::connect();
            $query = $bdd->query("SELECT * FROM category");
            return $query;
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
     * @return false|PDOStatement
     */
    public function getCategories()
    {
        try
        {
            $bdd = ConnexionBdd::connect();
            $query = $bdd->query('SELECT * FROM CATEGORIES');
            while ($line = $query->fetch()) {
                echo '<option value="' . $line['idc'] . '" >' . $line['libelle'] . '</option>';
            }
            $query->closeCursor();
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }


}
