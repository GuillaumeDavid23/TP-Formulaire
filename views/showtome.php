<?php 
    $registered = $_SESSION["registered"];
    if(!$registered){
        header('Location: ../index.php');
        exit();
    }else{
        $host = 'localhost';
        $dbname = 'form';
        $username = 'root';
        $password = ''; 
        $connect = "mysql:host=$host;dbname=$dbname"; 

        // récupérer tous les utilisateurs
        $sql = "SELECT * FROM user";
        
        //CONNEXION A LA BDD
        try{
        $pdo = new PDO($connect, $username, $password);
        $stmt = $pdo->query($sql);
        
        if($stmt === false){
            
        die("Erreur");
        }
        
        }catch (PDOException $e){
        echo $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Vous êtes connecté !</title>
</head>
<body>
    <?php if($registered) { ?>
        <h1>Vous êtes connecté :</h1>
        <?php while($row = $stmt->fetch()) : ?>
        <div class="info">
            <h1>Bonjour <?=$row['firstname'].' '.$row['lastname']?></h1>
            <div class="list">
                <strong>Votre date de naissance est :</strong>  <?=$row['birthday']?> <br>
                <strong>Votre pays de naissance est :</strong> <?=$row['country']?> <br>
                <strong>Votre nationalité est :</strong>  <?=$row['nationality']?> <br>
                <strong>Adresse :</strong> <?=$row['number'].' '.$row['street'].' à '.$row['city'].', '.$row['zip']?> <br>
                <strong>Votre e-mail :</strong>  <?=$row['mail']?> <br>
                <strong>Votre numéro de téléphone :</strong>  <?=$row['phone']?> <br>
                <strong>Vos diplômes :</strong> <?=$row['degree']?> <br>
                <strong>Vos numéro pôle emploi :</strong> <?=$row['poleNumber']?> <br>
                <strong>Vous avez :</strong> <?=$row['badge']?> Badge(s) <br>
                <strong>Votre lien vers Codecademy :</strong> <a href="<?=$row['link']?>" target="_blank">Allons-y</a> <br>
                <strong>Quelle super héro seriez vous ?</strong> <?=$row['secretAnswer']?> car <?=$row['secretDesc']?> <br>
                <strong>Votre hack préféré ?</strong> <?=$row['hackStory']?><br>
                <strong>Expérience en programmation ?</strong> <?=$row['finalQuestion']?><br>
            </div>
        </div>
        <?php endwhile; ?>
    <?php } ?>
</body>
</html>