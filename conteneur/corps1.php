<link rel="stylesheet" href="corps1.css">
<?php
    require_once('header.php');
    require_once('corps1.php');
    try {
        $db = new PDO('mysql:host=localhost;dbname=site-e-commerce','root','');
        $db ->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); // les noms des caracteres seront en minuscules
        $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // les erreurs lanceront des exceptions
    }
    catch(exception $e){
        echo 'Une erreur est survenue';
        die();
    
    }
    $select = $db ->prepare("SELECT * FROM produits ORDER BY id DESC LIMIT 0,2");
    $select ->execute();
?>
<link rel="stylesheet" href="page_article.css">
<?php
if(isset($_GET['show'])){
    $_SESSION['produit'] = htmlspecialchars($_GET['show']);
    header('Location: produits.php');
}else{
?>
<div class="cadre">
<div id="slider">
        <img src="../medias/dressing1.jpg" id="image">
        <div class="affiche">
        <h1>Achète et savoure <span></span></h1>
        <h1>Revends et recupère <span></span></h1>
        <h1>Le bon choix reste crucial <span></span></h1>
        </div>
        <div id="BD">
            <img src="../medias/right.png" class="right" onclick="slider(1);">
        </div>
        <div id="BG">
            <img src="../medias/left.png" class="left" onclick="slider(-1);">
        </div>
</div>
<script src="../js/slider.js" type="text/javascript"></script>

<div class=conteneur>
        <div class='article'>
            <p><a>Dernières articles</a></p>

            <?php
            while($s=$select->fetch(PDO::FETCH_OBJ)){
            ?>
                <a href="?show=<?= $s->titre; ?>"><div class="container1">
                    <div class="card1">
                        <div class="image1">
                            <img src="../images_produits/<?= $s->titre; ?>.png"/>
                        </div>
                        <div class="contenu1">
                            <h2><?= $s->titre; ?></h2>
                            <div class="taille1">
                                <h3>Size : </h3>
                                <span><?= $s->n1; ?></span>
                                <span><?= $s->n2; ?></span>
                                <span><?= $s->n3; ?></span>
                                <span><?= $s->n4; ?></span>
                            </div>
                            <div class="couleur1">
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
            ?>
        </div>
</div>
<?php
}
?>
<!-- <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet"> -->