<link href="css/styles.css" rel="stylesheet">
<ul>
    <li><a href="index.php" >HOME</a></li>
    <li><a href="registreren.php" >REGISTREREN</a></li>
    <li><a href="categorie.php" >CATEGORIEËN</a></li>
    <?php session_start();
    if(isset($_SESSION['id'])){ ?>
        <li><a href="profiel.php" name="profiel" >PROFIELPAGINA</a></li>
        <?php
        if(isset($_POST['profiel'])){
            header('Location: profiel.php');
        }
     }
    ?>
</ul>