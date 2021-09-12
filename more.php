<?php
session_start();
require 'Category.php';
require 'Comment.php';
require 'Article.php';
include 'nav.php';

if(!isset($_SESSION['category_id'])) $_SESSION['category_id'] = 1;

if  (isset($_POST['desactivate']))
{
    $article_id = htmlspecialchars($_SESSION['article_id']);

    if ($article_id)
    {
        Comment::desactivateComment($article_id);
    }
}

if  (isset($_POST['post-comment']))
{
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $comment = htmlspecialchars($_POST['comment']);
    $article_id = htmlspecialchars($_SESSION['article_id']);

    //var_dump($first_name , $last_name , $email , $comment , $article_id);

    if($first_name && $last_name && $email && $comment && $article_id)
    {
        $comments = new Comment($first_name, $last_name, $email, $comment, $article_id);
        $comments->store();
    }
    else
    {
        echo "<span class='text-danger text-center' >Tous les champs sont obligatoires</span>";
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
    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
</head>
<body>
<div class="container">
    <div class="jumbotron jumbotron-fluid mt-5">
        <div class="container">
            <h1 class="display-4">
                <?php foreach (Article::getAricleById($_SESSION['article_id']) as $article) {
                    echo 'Titre : '. $article['title'];
                }?>
            </h1>
        </div>
    </div>

    <div class="container-fluid">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <div id="main-content" class="blog-page">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-lg-8 col-md-12 left-box">
                        <div class="card single_post">
                            <div class="body">
                                <p>
                                    <?php foreach (Article::getAricleById($_SESSION['article_id']) as $article) {
                                        echo $article['content'];
                                    }?>
                                </p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="header">
                                <h2>Comments </h2>
                            </div>
                            <div class="body">
                                <ul class="comment-reply list-unstyled">
                                    <li class="row clearfix">
                                        <?php foreach (Comment::getComment($_SESSION['article_id']) as $comment) {?>
                                         <div class="icon-box col-md-2 col-4">
                                            <img class="img-fluid img-thumbnail" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQN6qtG51_xdYVcYcP4qhCeWEB9HtKAF4ySCA&usqp=CAU" alt="Awesome Image">
                                         </div>

                                        <div class="text-box col-md-10 col-8 p-l-0 p-r0">
                                            <h5 class="m-b-0"> <?php echo $comment['first_name'].' '.$comment['last_name'] ?> </h5>
                                            <p>
                                                <?php echo $comment['comment'] ?>
                                            </p>

                                            <form method="POST" >
                                                <button class="btn btn-danger mt-5" type="submit" name="desactivate">Desactivez ce commentaire</button>
                                            </form>

                                        </div>
                                        <?php }?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="header">
                                <h2>Laisser un commentaire</h2>
                            </div>
                            <div class="body">
                                <div class="comment-form">
                                    <form class="row clearfix" method="POST">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="first_name" placeholder="Prénom">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="last_name" placeholder="Nom">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" name="email" class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <textarea rows="4" name="comment" class="form-control no-resize" placeholder="Comment ...."></textarea>
                                            </div>
                                            <button type="submit" name="post-comment" class="btn btn-block btn-primary">Commenter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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


