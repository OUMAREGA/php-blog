<?php
session_start();

class Post
{
    protected $user_id, $post, $created_at;

    public function __construct($user_id, $post, $created_at)
    {
        $this->user_id = $user_id;
        $this->post = $post;
        $this->created_at = $created_at;
    }

    public function store()
    {
        try {
            $bdd = ConnexionBdd::connect();

            $insert = $bdd->prepare("INSERT INTO posts (user_id, post, created_at) VALUES (?,?,?) ");
            $insert->execute(array($this->user_id, $this->post, $this->created_at));

            $insert->closeCursor();

        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
        }
    }

    public function all()
    {
        try
        {
            $bdd = ConnexionBdd::connect();
            $query = $bdd->query('SELECT *, u.id as uid, p.id as pid  FROM posts p join users u on p.user_id = u.id');

            return $query;
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }

    }


    public function comments($post_id)
    {
        try
        {
            $bdd = ConnexionBdd::connect();

            //$query = $bdd->query('SELECT *, u.id as uid, p.id as pid  FROM posts p join users u on p.id = u.user_id');
            $query = $bdd->query('SELECT *, u.id as uid, p.id as pid, c.id as cid  FROM posts p join users u on p.user_id = u.id join comments c on c.post_id = p.id');

            return $query;

        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }

    }

    public function supprimerCommande($idPers,$idp)
    {
        try {
            $bdd = ConnexionBdd::connect();
            $insert = $bdd->prepare("DELETE FROM jonction_Personnes_Produits WHERE idPers = ? AND idProd = ? ");
            $insert->execute(array($idPers, $idp));

            $insert->closeCursor();

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

}
