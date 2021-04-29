    <header>
        <div class='logo'>Chic-Fric <span></span></div>
        <nav>
            <ul>
                <li class="liste one"><a href="codex.php">Acceuil</a></li>
                <li class="liste two "><a href="boutique.php">Boutique</a></li>
                <li class="liste one"><a href="panier.php">Panier</a></li>
                <li class="liste one"><a href="compte.php">Compte</a></li>
                <?php 
                if(isset($_SESSION['pseudo']) && isset($_SESSION['id'])){
                ?>
                <li class="liste two"><a href="../admin/deconnexion.php">Deconnexion</a></li>
                <?php 
                }else{
                ?>
                <li class="liste two"><a href="../index.php">Connexion</a></li>
                <?php
                }
                ?> 
            </ul>
        </nav>
    </header>
    <script type="text/javascript">
        window.addEventListener("scroll", function(){
        var header = document.querySelector("header");
        header.classList.toggle("sticky",window.scrollY > 0);
    }) 
    </script>
    