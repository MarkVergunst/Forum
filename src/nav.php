<link href="css/styles.css" rel="stylesheet">
<ul>
    <li><a href="index.php" >HOME</a></li>
    <li><a href="registreren.php" >REGISTREREN</a></li>
    <li><a href="categorie.php" >CATEGORIEËN</a></li>
    <?php session_start();
    if(isset($_SESSION['id'])){ ?>
        <li><a href="profiel.php" name="profiel" >PROFIELPAGINA</a></li>
        <li><a href="topic_aanmaken.php" name="profiel" >TOPIC AANMAKEN</a></li>
        <?php
        if(database::execute("SELECT * FROM users WHERE level > 1")){
            ?>
            <li><a href="categorie_aanmaken.php" name="profiel" >CATEGORIE AANMAKEN</a></li>
    <?php
        }
        if(isset($_POST['profiel'])){
            header('Location: profiel.php');
        }
     }
    ?>
</ul>