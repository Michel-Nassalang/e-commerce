<?php 
try {
    $db = new PDO('mysql:host=localhost;dbname=site-e-commerce','root','');
    $db ->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); // les noms des caracteres seront en minuscules
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // les erreurs lanceront des exceptions
}
catch(exception $e){
    echo 'Une erreur est survenue';
    die();
}
require_once('start.php');
require_once('header.php');
?> 
<link rel="stylesheet" href="panier.css">
<div class="page_panier">
    <div class="titre">
        <h1>Panier Client</h1>
    </div>
<?php 
if(isset($_SESSION['pseudo'])){
    ?>
    <div class="panier">
        <div class="tete">
            <nav>
                <div class="p one">Image</div>
                <div class="p two">Titre</div>
                <div class="p three">Prix</div>
                <div class="p four">Quantité</div>
                <div class="p five">Total</div>
            </nav>
        </div>
        <div class="produits">
            <?php 
                $select = $db ->prepare('SELECT * FROM panier WHERE client=:client');
                $select->execute([
                    "client"=>$_SESSION['pseudo']
                ]);
                while ($ligne = $select->fetch(PDO::FETCH_OBJ)) {
                    $produit = $db->prepare('SELECT * FROM produits WHERE titre=:title');
                    $produit->execute([
                        "title"=> $ligne->produits
                    ]);
                    while($pro = $produit->fetch(PDO::FETCH_OBJ)){
                    ?>
                    <nav>
                        <div class="p one"><img src="../images_produits/<?= $pro->titre ?>.png" alt=""></div>
                        <div class="p two"><?= $pro->titre ?></div>
                        <div class="p three"><?= $pro->prix ?> frcs</div>
                        <div class="p four"><?= $ligne->quantite ?></div>
                        <div class="p five">
                            <?= $ligne->quantite*$pro->prix ?> frcs <br> 
                            <a href=""><img src="" alt=""> supprimer</a>
                        </div>
                    </nav>
                    <?php
                    }
                }
            ?>  
            <a class="commande" href="#"> Passer la commande</a> 
        </div>
    </div>
    <?php
}else {
    ?>
    <h1>Désolé, vous n'êtes pas connecté donc vous ne pouvez pas accedez à un panier.</h1>
    <?php  
}
?> 
</div>

<?php 
require_once('footer.php');
?> 