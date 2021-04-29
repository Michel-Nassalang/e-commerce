<?php 
    try {
        $db = new PDO('mysql:host=localhost;dbname=site-e-commerce', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    } 
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin/compte.css">
    <title>Discussion</title>
</head>
<body>
    <div class="fixel">
        <form action="" method="post">
            <input type="text" name="pseudo" placeholder='Pseudo'>
            <input type="password" name="password" placeholder="Mot de Passe">
            <input type="submit" class="submit" value="Je me connecte"><br>
            <a href="admin/inscription.php" style ="color:white; text-decoration:none">M'inscrire</a><br>
            <a href="conteneur/codex.php" style="color:white; text-decoration:none">Naviguer sans compte</a>
        </form>
    </div>
</body>
</html>
<?php 
    if(isset($_POST['pseudo']) && isset($_POST['password']) && !empty($_POST['pseudo']) && !empty($_POST['password']))
    {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $password = htmlspecialchars($_POST['password']);
        $connexion = $db->prepare('SELECT * FROM administration WHERE pseudo = :pseudo');
        $connexion->execute([
                    'pseudo' => $pseudo
                ]);
        $compte = $connexion->fetch();
        $ligne = $connexion->rowCount();
        if($ligne == 1)
        {
            if(password_verify($password, $compte['pass']))
            {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['id'] = $compte['id'];
                header('Location: conteneur/codex.php');
            }
            else{
?>
                <div class="erreur">
                    <p>Veuillez vérifier votre mot de passe.</p>
                </div>
<?php   
                }
        }
        else{
?>
                <div class="erreur">
                    <p>Veuillez vérifier votre pseudo.</p>
                </div>
<?php
        }
    }elseif(isset($_POST['pseudo']) && isset($_POST['password']) && empty($_POST['pseudo']) && empty($_POST['password']))
    {
?>
                <div class="erreur">
                    <p>Veuillez vérifier votre pseudo ou votre mot de passe si vous vous êtes inscris. <br>
                    Sinon veilllez vous inscrire. Nous serions contents de vous compter parmi vous.</p>
                </div>
<?php
    }
?>