<link href="css/styles.css" rel="stylesheet">
<ul>
    <li><a href="index.php" >HOME</a></li>
    <li><a href="registreren.php" >REGISTREREN</a></li>
    <li><a href="index.php" >CATEGORIEËN</a></li>
    <li><a href="topic.php" >TOPICS</a></li>
    <?php session_start();
    if(isset($_SESSION['id'])){ ?>
        <li>
            <div id='logout'>
                <form method="post"><input type="submit" value="logout" name="logout">
                </form>
                <?php

                //if $_SESSION doesnt exist when this is being called then create it
                if(!isset($_SESSION)){
                    session_start();
                }

                if(isset($_POST['logout'])){
                    unset($_SESSION['id']);
                    header('Location: '. $_SERVER['HTTP_REFERER']);
                }
                ?>
            </div>
        </li>
        <li>
            <div id='profiel'>
                <form method="post"><input type="submit" value="profiel" name="profiel">
                </form>
        </li>
        <?php
        if(isset($_POST['profiel'])){
            header('Location: profiel.php');
        }
     }
    ?>
</ul>