<?php
session_start();
require 'Category.php';
include 'nav.php';

if(isset($_POST['redirect']))
{
    $category_id = htmlspecialchars($_POST['category_id']);
    var_dump($category_id);
    if($category_id)
    {
        $_SESSION['category_id'] = $category_id;
        header('Location:item.php');
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

?>
<!Doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="profil.css" media="screen" type="text/css" />
</head>
<body>
<div class="container">
    <div class="container-fluid">
        <h3  class="mt-5 text-center">Bienvenu(e) dans mon blog</h3>
        <p> Retrouvez vos catégories d'articles </p>
    </div>

    <div class="container-fluid">
        <div class="row">
                <div class="col-sm">
                    <div class="accordion" id="accordionExample">
                        <?php foreach (Category::index() as $category){ ?>
                            <div class="card mt-2">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <?php echo $category['name'] ?>
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <?php echo $category['description'] ?>

                                        <div class="mt-3">
                                            <form method="POST">
                                                <input type="hidden" name="category_id" value="<?php echo $category['id']?>"/>
                                                <button type="submit" name="redirect" class="btn btn-primary">
                                                    Voir les articles <?php echo $category['name'] ?>
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">
                                Ajouter une catégorie
                            </h5>
                            <form method="POST">
                                <input type="text" name="name" placeholder="nom" />
                                <textarea class="form-control mb-3" name="description" placeholder="la description ..." ></textarea>
                                <button class="btn btn-primary" type="submit" name="category"> Valider </button>
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


