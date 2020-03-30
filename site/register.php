<?php

require "db.php";
//Si on a le post Email
if(isset($_POST["Email"])){
    //Tableau error
    $errors = array();
    //Si email n'est pas vide
    if(!empty($_POST["Email"])){
        //Si l'adresse mail fournie est une adresse mail valide
        if(filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)){
            //Check si le pseudo n'est pas vide
            if(!empty($_POST["Nom"])){
                                //Check si le motnom st pas vide
            if(!empty($_POST["Prenom"])){
                //Check si le mots de passe est pas vide
                if(!empty($_POST["Password"]) && !empty($_POST["Password_Verify"])){
                    //Check si les mots de passes correspondent entre eux
                    if($_POST["Password"] != $_POST["Password_Verify"]) return array_push($errors, "Les mots de passes ne correspondent pas");
                    $Password = htmlspecialchars($_POST["Password"]);
                    $Name = htmlspecialchars($_POST["Nom"]);
                    $Username = htmlspecialchars($_POST["Prenom"]); 
                    $Email = htmlspecialchars($_POST["Email"]);
                    if(strlen($Username) > 30) return array_push($errors, "Votre nom ne doit pas avoir plus de 30 caractères");
                    
                    //Mot de passe et email encrytés
                    $Password = password_hash($Password, PASSWORD_BCRYPT);
                    $Email = md5($Email);

                    $stmt = $bdd->prepare("INSERT INTO `users` (`Username`,`Name`,`Email`,`Password`) VALUES (?,?,?,?)");
                    $stmt->execute([$Username,$Name,$Email,$Password]);
                    echo "Inscrit";
                }else{
                    //Error: Les mots de passe n'est pas défini
                    array_push($errors, "Le/les mots de passes ne sont pas définis");
                }
            }else{
                //Error: Aucun pseudo fourni
                array_push($errors, "Aucun pseudo défini");   
            }
            }else{
                //Error: Aucun pseudo fourni
                array_push($errors, "Aucun pseudo défini");
                }
        }else{
            //Error: l'adresse mail fournie est invalide
            array_push($errors, "Le nom est invalide");
        }
    }else{
        //Error: L'utilisateur n'a défini aucune adresse mail
        array_push($errors, "Aucun email défini");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription</title>
</head>
<body>
    <center><a href="https://www.paypal.com/pools/c/8nK3yupQi0">Faites un don pour nous soutenir</a> </br></br>

<center><embed src=Criquet.pdf  width=800 height=550 type='application/pdf'/></center>
<center>Manon SAYAG a publié le 28 février 2020</center>
    <form action="/register" method="post">
        <h1>Inscription</h1>
        <input type="text" name="Email" placeholder="Email">
        <input type="text" name="Pseudo" placeholder="Pseudo">
        <input type="password" name="Password" placeholder="Mot de passe">
        <input type="password" name="Password_Verify" placeholder="Valider le mot de passe">
        <input type="submit" value="S'inscrire">
        <?php 
            if(!isset($errors)) return;
            if(count($errors) > 0){
                for ($i=0; $i < count($errors); $i++) { 
                    ?>
                        <li><?= $errors[$i] ?></li>
                    <?php
                }
            }
        ?>
    </form>
</body>
</html>
