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
                    $Nom = htmlspecialchars($_POST["Nom"]);
                    $Prenom = htmlspecialchars($_POST["Prenom"]); 
                    $Email = htmlspecialchars($_POST["Email"]);
                    if(strlen($Prenom) > 30) return array_push($errors, "Votre nom ne doit pas avoir plus de 30 caractères");
                    
                    //Mot de passe et email encrytés
                    $Password = password_hash($Password, PASSWORD_BCRYPT);
                    $Email = md5($Email);

                    $stmt = $bdd->prepare("INSERT INTO `newclient` (`Prenom`,`Nom`,`Email`,`Password`) VALUES (?,?,?,?)");
                    $stmt->execute([$Prenom,$Nom,$Email,$Password]);
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

</body>
</html>
