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
if(isset($_GET['show'])){
    $produit = htmlspecialchars($_GET['show']);

    $select = $db ->prepare("SELECT * FROM produits WHERE titre='$produit'");
    $select ->execute();
    $s = $select->fetch(PDO::FETCH_OBJ);
    ?>
    <div class="page" id='page'>
        <div class="articles">
            <div class="contenu1">
                <img src="../images_produits/<?= $s->titre; ?>.png" >
            </div>
            <div class="contenu2">
                
            </div>
            <div class="contenu3">
                <p class='titre'><?= $s->titre; ?></p>

                <div class="stock">
                    <p class= 'prix'>Prix :  <?= $s->prix; ?> frcs CFA</p>
                    <p class='stockage'>Stock : <a><?= $s->stock; ?></a> </p>
                </div>

                <div class="description">
                    <p> Description du produit : <?= $s->description; ?></p>
                    <!-- controller la longueur des textes avec des points etc -->
                    <?php $longueur=100;
                    $description = $s->description; 
                    $new_description = substr($description,0,$longueur).' ...';
                    // $desc_finale = wordwrap($new_description,15, '<br />', true);
                    ?>
                    <p><?= $new_description; ?></p>
                </div>

                <div class="pourpanier">
                <?php if ($s ->stock!=0){?><a href="#">Ajouter au panier</a> <?php }else{ ?><a> ----Stock épuisé  !----- </a> <?php } ?>
                </div>

                <div class="categorie">
                    <p>Categorie : <?= $s->categorie; ?></p>
                </div>

                </div>
            </div>
        </div>
        <div class="details">
                <h2>Details du produit</h2>
                <p> Description du produit : <?= $s->description; ?></p>
                <p>Categorie : <?= $s->categorie; ?></p>
                <p> Description du produit : <?= $s->description; ?></p>
                <p>Categorie : <?= $s->categorie; ?></p>
        </div>
        <div class="facade">
            <div class="trait"></div>
            <div class="middle">
                <p>Produits simulaires</p>
            </div>
            <div class="trait"></div>
        </div>
    </div>
    <?php
}
elseif(isset($_GET['page'])){
    require_once('corps1.php');
    $page = htmlspecialchars($_GET['page']);
    ?>

    <div class="grand_conteneur">
        <?php
        $for_page = 12;
        $debut = $page*$for_page - $for_page;
        $fin = $page*$for_page;
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
else{
    require_once('corps1.php');
?>

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