<link rel="icon" href="../medias/favicon.ico">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="article.css">
    <link rel="stylesheet" href="corps1.css">
    <link rel="stylesheet" href="page_article.css">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet"> -->
<?php
session_start();
    require_once('header.php');
    try {
        $db = new PDO('mysql:host=localhost;dbname=site-e-commerce','root','');
        $db ->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); // les noms des caracteres seront en minuscules
        $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // les erreurs lanceront des exceptions
    }
    catch(exception $e){
        echo 'Une erreur est survenue';
        die();
    }
?>
<?php
// ----------------------------------------------------------------
if(isset($_GET['show'])){
    $_SESSION['produit'] = htmlspecialchars($_GET['show']);
    header('Location: produits.php');
}
// -------------------------------------------------------------
elseif(isset($_GET['page'])){
    require_once('corps1.php');
    ?>
    <div class="categories">
    <nav>
        <ul class="bus">
            <li><a href="">Categories</a>
                <ul class="barre">
                    <?php
                        $menu = $db ->prepare("SELECT nom_categorie FROM categories");
                        $menu ->execute();
                        while($m = $menu->fetch(PDO::FETCH_OBJ)){
                    ?>
                    <li><a href="?categorie=<?= $m->nom_categorie ?>"><?= $m->nom_categorie ?></a></li>
                    <?php
                        }
                    ?>
                </ul>
            </li>
        </ul>
        
    </nav>
    </div>
<?php
    $page = htmlspecialchars($_GET['page']);
    ?>

    <div class="grand_conteneur">
        <?php
        $for_page = 12;
        $debut = $page*$for_page - $for_page;
        $fin = $for_page;
        $decompte = $db->prepare('SELECT count(id) FROM produits');
        $decompte->execute();
        $nombre_produits = $decompte->fetchColumn();
        $nombre_pages = $nombre_produits / $for_page;
        $select = $db ->prepare("SELECT * FROM produits ORDER BY id DESC LIMIT :fin OFFSET :debut");
        $select->bindValue('fin', $fin, PDO::PARAM_INT);
        $select->bindValue('debut', $debut, PDO::PARAM_INT);
        $select ->execute();
        while($s=$select->fetch(PDO::FETCH_OBJ)){
        ?>

        <div class="container">
                <a href="?show=<?= $s->titre; ?>">
                <div class="card">
                    <div class="image">
                        <img src="../images_produits/<?= $s->titre; ?>.png">
                    </div>
                    <div class="contenu">
                        <h2><?= $s->titre; ?></h2>
                        <div class="taille">
                            <h3>Size : </h3>
                            <span><?= $s->n1; ?></span>
                            <span><?= $s->n2; ?></span>
                            <span><?= $s->n3; ?></span>
                            <span><?= $s->n4; ?></span>
                        </div>
                        <div class="couleur">
                            <h3>couleur : </h3>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
        </div></a>
        <?php
        }
        $select -> closeCursor();
    ?>
    </div>
    <div class="pagination">
    <?php
        if($nombre_pages<=1){
            ?>
            <a href="?page=1">1</a>
            <?php
        }
        for ($i=1; $i < abs($nombre_pages)+1; $i++) { 
            ?>
            <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php
        }
    ?> 
    </div>
    <?php     
}
// -----------------------------------------------------------------
elseif(isset($_GET['categorie'])){ 
    require_once('corps1.php');   
    ?>
    <div class="categories">
        <nav>
            <ul class="bus">
                <li><a href="">Categories</a>
                    <ul class="barre">
                        <?php
                            $menu = $db ->prepare("SELECT nom_categorie FROM categories");
                            $menu ->execute();
                            while($m = $menu->fetch(PDO::FETCH_OBJ)){
                        ?>
                        <li><a href="?categorie=<?= $m->nom_categorie ?>"><?= $m->nom_categorie ?></a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </li>
            </ul>
            
        </nav>
    </div>
    <?php
    if(isset($_GET['page_categorie'])){
        $page_c = htmlspecialchars($_GET['page_categorie']);
    ?>
    <div class="grand_conteneur">
            <?php
            $for_page = 12;
            $debut = $page_c * $for_page - $for_page;
            $fin = $for_page;
            $categorie = htmlspecialchars($_GET['categorie']);
            $select = $db ->prepare("SELECT count(id) FROM produits WHERE categorie= :categorie");
            $select->execute([
                "categorie"=>$categorie
            ]);
            $nombre_produits = $select->fetchColumn();
            $nombre_pages = $nombre_produits / $for_page;
            $affiche = $db ->prepare("SELECT * FROM produits WHERE categorie= :categorie ORDER BY id DESC LIMIT :fin OFFSET :debut");
            $affiche->bindValue('fin', $fin, PDO::PARAM_INT);
            $affiche->bindValue('debut', $debut, PDO::PARAM_INT);
            $affiche->bindValue('categorie', $categorie);
            $affiche->execute();
            while($a=$affiche->fetch(PDO::FETCH_OBJ)){
            ?>
            <div class="container">
                    <a href="?show=<?= $a->titre; ?>">
                    <div class="card">
                        <div class="image">
                            <img src="../images_produits/<?= $a->titre; ?>.png">
                        </div>
                        <div class="contenu">
                            <h2><?= $a->titre; ?></h2>
                            <div class="taille">
                                <h3>Size : </h3>
                                <span><?= $a->n1; ?></span>
                                <span><?= $a->n2; ?></span>
                                <span><?= $a->n3; ?></span>
                                <span><?= $a->n4; ?></span>
                            </div>
                            <div class="couleur">
                                <h3>couleur : </h3>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
            </div></a>
            <?php
            }
            $affiche -> closeCursor();
        ?>
    </div>
    <?php
    }
    else {
        ?>
    <div class="grand_conteneur">
            <?php
            $for_page = 12;
            $debut = $for_page - $for_page;
            $fin = $for_page;
            $categorie = htmlspecialchars($_GET['categorie']);
            $select = $db ->prepare("SELECT count(id) FROM produits WHERE categorie= :categorie");
            $select->execute([
                "categorie"=>$categorie
            ]);
            $nombre_produits = $select->fetchColumn();
            $nombre_pages = $nombre_produits / $for_page;
            $affiche = $db ->prepare("SELECT * FROM produits WHERE categorie= :categorie ORDER BY id DESC LIMIT :fin OFFSET :debut");
            $affiche->bindValue('fin', $fin, PDO::PARAM_INT);
            $affiche->bindValue('debut', $debut, PDO::PARAM_INT);
            $affiche->bindValue('categorie', $categorie);
            $affiche->execute();
            while($a=$affiche->fetch(PDO::FETCH_OBJ)){
            ?>
            <div class="container">
                    <a href="?show=<?= $a->titre; ?>">
                    <div class="card">
                        <div class="image">
                            <img src="../images_produits/<?= $a->titre; ?>.png">
                        </div>
                        <div class="contenu">
                            <h2><?= $a->titre; ?></h2>
                            <div class="taille">
                                <h3>Size : </h3>
                                <span><?= $a->n1; ?></span>
                                <span><?= $a->n2; ?></span>
                                <span><?= $a->n3; ?></span>
                                <span><?= $a->n4; ?></span>
                            </div>
                            <div class="couleur">
                                <h3>couleur : </h3>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
            </div></a>
            <?php
            }
            $affiche -> closeCursor();
        ?>
    </div>
        <?php  
    }
    ?>
            <div class="pagination">
            <?php
                if($nombre_pages<=1){
                    ?>
                    <a href="?page_categorie=1">1</a>
                    <?php
                }else{
                    for ($i=1; $i < abs($nombre_pages)+1; $i++) { 
                        ?>
                        <a href="?page_categorie=<?= $i ?>"><?= $i ?></a>
                        <?php
                    }
                }
                    
            ?> 
            </div>
            <?php
}
else{
// ----------------------------------------------------------
    require_once('corps1.php');
?>

<div class="categories">
    <nav>
        <ul class="bus">
            <li><a href="">Categories</a>
                <ul class="barre">
                    <?php
                        $menu = $db ->prepare("SELECT nom_categorie FROM categories");
                        $menu ->execute();
                        while($m = $menu->fetch(PDO::FETCH_OBJ)){
                    ?>
                    <li><a href="?categorie=<?= $m->nom_categorie ?>"><?= $m->nom_categorie ?></a></li>
                    <?php
                        }
                    ?>
                </ul>
            </li>
        </ul>
        
    </nav>
</div>

<div class="grand_conteneur">
    <?php
    $for_page = 12;
    $debut = 0;
    $fin = 12;
    $decompte = $db->prepare('SELECT count(id) FROM produits');
    $decompte->execute();
    $nombre_produits = $decompte->fetchColumn();
    $nombre_pages = $nombre_produits / $for_page;
    $select = $db ->prepare("SELECT * FROM produits ORDER BY id DESC LIMIT :fin OFFSET :debut");
    $select->bindValue('fin', $fin, PDO::PARAM_INT);
    $select->bindValue('debut', $debut, PDO::PARAM_INT);
    $select ->execute();
    while($s=$select->fetch(PDO::FETCH_OBJ)){
    ?>

    <div class="container">
            <a href="?show=<?= $s->titre; ?>"><div class="card">
                <div class="image">
                    <img src="../images_produits/<?= $s->titre; ?>.png">
                </div>
                <div class="contenu">
                    <h2><?= $s->titre; ?></h2>
                    <div class="taille">
                        <h3>Size : </h3>
                        <span><?= $s->n1; ?></span>
                        <span><?= $s->n2; ?></span>
                        <span><?= $s->n3; ?></span>
                        <span><?= $s->n4; ?></span>
                    </div>
                    <div class="couleur">
                        <h3>couleur : </h3>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <!-- <div class="achat">
                        <div class='a1'>
                            <a href="#">Acheter</a>
                        </div>
                        <div class='a2'>
                            <a href="#">Mettre au panier</a>
                        </div>
                    </div> -->
            </div>
        </div></a>
    <?php
    }
    $select -> closeCursor();
    ?>
</div>
<div class="pagination">
        <?php
            if($nombre_pages<=1){
                ?>
                <a href="?page=1">1</a>
                <?php
            }
                for ($i=1; $i < abs($nombre_pages)+1; $i++) { 
                    ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                    <?php
                }
        ?> 
</div>
<?php
}
    require_once('footer.php');
?>