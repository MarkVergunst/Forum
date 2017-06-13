<ul>
    <li><a href="index.php" >HOME</a></li>
    <li><a href="registreren.php" >REGISTREREN</a></li>
    <li><a href="categorie.php" >CATEGORIEËN</a></li>
    <?php session_start();
    if(isset($_SESSION['id'])){ ?>
        <li><a href="profiel.php" name="profiel" >PROFIELPAGINA</a></li>
        <li><a href="topic_aanmaken.php" name="topic" >TOPIC AANMAKEN</a></li>
        <?php
        $id = $_SESSION['id'];
    $resultaat = database::execute("SELECT * FROM users WHERE id = '$id'");
        if($resultaat[0]['level'] > 1){
            ?>
            <li><a href="categorie_aanmaken.php" name="categorie_aanmaken" >CATEGORIE AANMAKEN</a></li>
    <?php
        }
        ?>
    <?php
        if($resultaat[0]['level'] > 2){
            ?>
            <li><a href="admin_tools.php" name="admin_tools" >ADMIN TOOLS</a></li>
            <?php
        }

        if(isset($_POST['profiel'])){
            header('Location: profiel.php');
        }
     }
    ?>
</ul>