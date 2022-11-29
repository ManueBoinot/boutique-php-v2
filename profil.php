<?php
require_once("header.php");
if(!isset($_SESSION['email'])){
}

?>



<body>
    <div class="success">
    <h1>Bienvenue dans votre espace personnel !</h1>
    <button class="btn btn-secondary border-0" style="background-color: darksalmon;"><a href="logout.php">Déconnexion</a></button>
    </div>
</body>

<?php
include("footer.php");
?>