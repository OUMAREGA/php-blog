<?php
session_start();
require 'Category.php';
require 'Article.php';
include 'nav.php';

if(!isset($_SESSION['category_id'])) $_SESSION['category_id'] = 1;

if (isset($_POST['read']))
{
    // since php 7 $_SESSION['article_id'] = htmlspecialchars($_POST['article_id']) ?? NULL
    $_SESSION['article_id'] = htmlspecialchars($_POST['article_id']) ? htmlspecialchars($_POST['article_id']) :  NULL;
    if ($_SESSION['article_id']) header('Location:more.php');

}
if (isset($_POST['delete']))
{
    $article_id = htmlspecialchars($_POST['article_id']);

    if ($article_id)
    {
        $article = Article::delete($article_id);
    }

}

if(isset($_POST['category']))
{
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);

    if($name && $description)
    {
        $category = new Category($name, $description);
        $category->store();
    }
    else
    {
        echo "<span class='text-danger text-center' >Le champ nom et description sont obligatoires</span>";
    }
}
if(isset($_POST['filter']))
{
    $category_id = htmlspecialchars($_POST['category_id']);

    if($category_id)
    {
        $_SESSION['category_id'] = $category_id;
    }
}
if(isset($_POST['article']))
{
    $category_id = htmlspecialchars($_POST['category_id']);
    $content = htmlspecialchars($_POST['content']);
    $title = htmlspecialchars($_POST['title']);

    if($title && $category_id && $content)
    {
        $article = new Article($title, $category_id, $content);
        $article->store();
    }
}
?>
<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/profil.css" media="screen" type="text/css" />
</head>
<body>
<div class="container">
    <div class="container-fluid">
        <h3  class="mt-5 text-center">Bienvenu(e) dans mon blog</h3>
        <p> Retrouvez vos articles par catégorie </p>
        <form method="POST">
            <select name="category_id" class="custom-select w-25">
                <?php foreach (Category::index() as $category){?>
                    <option value="<?php echo $category["id"] ?>" <?php if ($_SESSION['category_id'] == $category["id"]) echo "selected" ?> ><?php echo $category["name"] ?></option>
                <?php }?>
            </select>
            <button type="submit" name="filter" class="btn btn-primary"> Filtrer </button>
        </form>
    </div>

    <div class="container-fluid">
        <div class="row">
                <div class="col-sm">
                    <div class="accordion" id="accordionExample">
                        <?php if(isset($_SESSION['category_id'])) {
                            foreach (Article::show($_SESSION['category_id']) as $article) { ?>
                                <div class="card mt-2">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button"
                                                    data-toggle="collapse" data-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                <?php echo $article['title'] ?>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                         data-parent="#accordionExample">
                                        <div class="card-body">
                                            <p  style="display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;" >
                                                <?php echo $article['content'] ?>
                                            </p>

                                            <br>
                                            <form method="POST" class="form-horizontal mt-3">
                                                <input type="hidden" name="article_id" value="<?php echo $article['id'] ?>"  />
                                                <button class="btn btn-primary" type="submit" name="read"> Lire l'article </button>
                                                <button class="btn btn-danger" type="submit" name="delete"> Supprimer l'article </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">
                                Ajouter un article
                            </h5>
                            <form method="POST">
                                <input type="text" name="title" placeholder="nom" />
                                <select name="category_id" class="custom-select mb-2">
                                    <?php foreach (Category::index() as $category){?>
                                        <option value="<?php echo $category["id"] ?>"><?php echo $category["name"] ?></option>
                                    <?php }?>
                                </select>
                                <textarea rows="5" cols="5"class="form-control mb-3" name="content" placeholder="le contenu ..." ></textarea>
                                <button class="btn btn-primary" type="submit" name="article"> Valider </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    // disabled resubmission on page refresh
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>


