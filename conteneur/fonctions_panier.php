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
?>

<?php
    class ACHAT{
        function soustraction($produits){
            if(isset($_SESSION['pseudo'])){
                $db = new PDO('mysql:host=localhost;dbname=site-e-commerce','root','');
                $db ->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); // les noms des caracteres seront en minuscules
                $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // les erreurs lanceront des exceptions
                $stock = $db ->prepare("SELECT * FROM produits WHERE titre=:title");
                $stock->execute(["title"=>$produits]);
                $stockage = $stock->fetch(PDO::FETCH_OBJ);
                $mon_stock = $stockage->stock;
                $base = $db ->prepare("UPDATE produits SET stock = :stock WHERE titre= :titre");
                if($mon_stock>0){
                    $base->execute([
                        "stock"=> $mon_stock-1,
                        "titre"=> $produits
                    ]);
                    ?>
                    <div class="reussi">
                        <p>Votre commande est enrigistrée sur votre panier.</p>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="contre">
                        <p>Votre commande ne peut être éffectuée.</p>
                    </div>
                    <?php
                }
            }else{
                ?>
                <div class="contre">
                    <p>Veuillez vous connecter pour faire un achat.</p>
                </div>
                <?php
            }
        }
        function produit_panier($produits){
            if(isset($_SESSION['pseudo'])){
                $db = new PDO('mysql:host=localhost;dbname=site-e-commerce','root','');
                $db ->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); // les noms des caracteres seront en minuscules
                $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // les erreurs lanceront des exceptions
                $base = $db ->prepare("SELECT * FROM produits WHERE titre=:title");
                $base->execute(["title"=>$produits]);
                $mon_prix = $base->fetch(PDO::FETCH_OBJ);
                $prix = $mon_prix->prix;
                $insert = $db->prepare('INSERT INTO panier(produits, quantite, prix, client) VALUES (:produit, :quantite, :prix, :client)');
                $insert->execute([
                    "produit"=> $produits,
                    "quantite"=> 1,
                    "prix"=> $prix,
                    "client"=> $_SESSION['pseudo']
                ]);
            }
        }
    }
?>
