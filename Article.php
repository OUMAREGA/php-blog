<?php



/**
 * Class Article
 */
class Article
{
    protected $title, $category_id, $content, $created_at;

    /**
     * Article constructor.
     * @param $title
     * @param $category_id
     * @param $content
     */
    public function __construct($title, $category_id, $content)
    {
        $this->title = $title;
        $this->category_id = $category_id;
        $this->content = $content;
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
            var_dump($this->title, $this->category_id, $this->content, $this->created_at);
            $insert = $bdd->prepare("INSERT INTO article (title, category_id, content, created_at) VALUES (?,?,?,?)");
            $insert->execute(array($this->title, $this->category_id, $this->content, $this->created_at));
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
    public function show($category_id)
    {
        try
        {
            $bdd = ConnexionBdd::connect();
            $query = $bdd->query("SELECT * FROM article where category_id = $category_id");
            return $query;
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            return $e->getMessage();
        }
    }

    public function getAricleById($id)
    {
        try
        {
            $bdd = ConnexionBdd::connect();
            $query = $bdd->query("SELECT * FROM article where id = $id");
            return $query;
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
     * @param $article_id
     * @return string
     */
    public function delete($article_id) {
        try {
            $bdd = ConnexionBdd::connect();
            $insert = $bdd->prepare("DELETE FROM article WHERE id = ?");
            $insert->execute(array($article_id));

            $insert->closeCursor();

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }




}
