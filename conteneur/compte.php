<?php 
require_once('start.php');
require_once('header.php');
?> 
<?php
    try {
        $db = new PDO('mysql:host=localhost;dbname=site-e-commerce','root','');
        $db ->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    catch(exception $e){
        echo 'Une erreur est survenue';
        die();
    }
?>
    <?php 
    if(isset($_SESSION['pseudo']) && isset($_SESSION['id'])){
        ?>
        <div class="informations">
        <h3 class="info">Mes informations</h3>
    <?php
        $info = $db->prepare('SELECT * FROM administration WHERE id= :id');
        $info->execute([
            "id"=> $_SESSION['id']
        ]);
        while($myinfo=$info->fetch(PDO::FETCH_OBJ)){
        ?> 
        <p><span>Nom et Prenom : </span><?= $myinfo -> nom ?></p>
        <p><span>Nom d'utilisateur : </span><?= $myinfo -> pseudo ?></p>
        <p><span>Email : </span><?= $myinfo -> email ?></p>
        <p><span>Âge : </span><?= $myinfo -> age ?> ans</p>
    <?php         
        }  
    ?>
</div>
    <?php
    $info->closeCursor();
    }else{
        ?>
        <h1>Nous vous souhaitons la bienvenue dans votre espace de Relooking !</h3>
        <p><span>Vous n'êtes pas connecté. <br> veilllez vous connectez sur votre espace client. </span></p>
        <p><span>Si vous n'êtes pas encore compté parmi, nous vous invitons vivement à créer votre compte</span><br><a href="../admin/inscription.php">Créer mon espace client</a></p>
        <?php
    }
    ?> 

<?php 
require_once('footer.php');
?> 
<link rel="stylesheet" href="compte.css">