<?php

/**
 * Class Comment
 */
class Comment
{
    protected $article_id, $first_name, $last_name, $email, $comment, $created_at;

    /**
     * Comment constructor.
     * @param $article_id
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $comment
     */
    public function __construct($first_name, $last_name, $email, $comment, $article_id)
    {
        $this->article_id = $article_id;
        $this->first_name = $first_name;
        $this->last_name  = $last_name;
        $this->email      = $email;
        $this->comment   = $comment;
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
            $insert=$bdd->prepare("INSERT INTO comments (first_name, last_name, email, comment, article_id, authorized, created_at) VALUES (?,?,?,?,?,?,?) ");

            $insert->execute(array($this->first_name, $this->last_name, $this->email, $this->comment, $this->article_id, true, $this->created_at));

            return $bdd->lastInsertId();
        }
        catch (Exception $e)
        {
                var_dump($e->getMessage());
            return $e->getMessage();
        }
    }

    /**
     * @param $post_id
     * @return false|PDOStatement|string
     */
    public function getComment($article_id)
    {
        try
        {
            $bdd = ConnexionBdd::connect();
            $query = $bdd->query("SELECT * FROM  comments where article_id = $article_id and authorized= 1");
            return $query;

        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }

    }

    public function desactivateComment($article_id)
    {
        try
        {
            $bdd = ConnexionBdd::connect();

            $sql = "UPDATE comments SET authorized=? WHERE article_id=?";
            $query = $bdd->prepare($sql);
            $query->execute([0, $article_id]);
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            return $e->getMessage();
        }

    }

}
