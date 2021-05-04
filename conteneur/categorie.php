    <link rel="icon" href="../medias/favicon.ico">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="article.css">
    <link rel="stylesheet" href="corps1.css">
    <link rel="stylesheet" href="page_article.css"><?php
session_start();
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
    $categorie = $_SESSION['page_categorie'];
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
            $categorie = $_SESSION['page_categorie'];
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
</div>
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