<?php
session_start();
//Déclaration des variables
    $error = '';
    $stockError = [];
    $testForm = true;
     //REGEX
    $telReg = "/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/";
    $letterReg = "/[A-Za-z]/";
    $nameReg = "/^[A-Za-z]+$/";
    $zipReg = "/^[\d]{5}$/";
    $poleReg = "/^[0-9]{6}[A-Z]{1}$/";

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
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }
    
     //Fonction de validation des données
    function valid_data($index, $data)
    {

        if($index == 'phone'){ //enlever espace dans le numéro
            $data = preg_replace('/\s+/', '', $data);
            $_POST[$index] =  $data;
        }
        elseif($index == 'poleNumber'){ //Mettre en majuscule tout les caractères
            $data = strtoupper($data);
            $_POST[$index] =  $data;
        }
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $requiredInput = [
                'firstname' => true,
                'lastname' => true,
                'birthday' => false,
                'country' => false,
                'number' => false,
                'street' => false,
                'city'=> false,
                'zip'=> false,
                'mail'=> false,
                'phone'=> false,
                'degree'=> false,
                'poleNumber'=> false,
                'badge'=> false,
                'codecademy'=> false,
                'secretAnswer'=> false,
                'secretDesc'=> false,
                'hackStory'=> false,
                'finalQuestion'=> false,
                'nationality'=> false
            ];


    //Les données sont-elles envoyées ?
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //Test des champs
        if(empty($_POST['firstname'])      
        || empty($_POST['lastname']) && $requiredInput['lastname'] == true
        || empty($_POST['birthday']) && $requiredInput['birthday'] == true
        || empty($_POST['country']) && $requiredInput['country'] == true
        || empty($_POST['number']) && $requiredInput['number'] == true
        || empty($_POST['street'])&& $requiredInput['street'] == true
        || empty($_POST['city']) && $requiredInput['city'] == true
        || empty($_POST['zip'])&& $requiredInput['zip'] == true
        || empty($_POST['mail']) && $requiredInput['mail'] == true
        || empty($_POST['phone'])&& $requiredInput['phone'] == true
        || empty($_POST['degree']) && $requiredInput['degree'] == true
        || empty($_POST['poleNumber'])&& $requiredInput['poleNumber'] == true
        || empty($_POST['badge']) && $requiredInput['badge'] == true
        || empty($_POST['codecademy'])&& $requiredInput['codecademy'] == true
        || empty($_POST['secretAnswer']) && $requiredInput['secretAnswer'] == true
        || empty($_POST['secretDesc'])&& $requiredInput['secretDesc'] == true
        || empty($_POST['hackStory']) && $requiredInput['hackStory'] == true
        || empty($_POST['finalQuestion'])&& $requiredInput['finalQuestion'] == true
        || empty($_POST['nationality']) && $requiredInput['nationality'] == true
        ){
            //Affichage du formulaire si vide
            $testForm = true;
            $error = 'Un ou plusieurs champs obligatoires sont vides';
            $stockError['empty'] = $error;
        }
        elseif(empty($_POST['firstname']) 
        && empty($_POST['lastname']) 
        && empty($_POST['birthday'])
        && empty($_POST['country'])
        && empty($_POST['number']) 
        && empty($_POST['street'])
        && empty($_POST['city']) 
        && empty($_POST['zip'])
        && empty($_POST['mail']) 
        && empty($_POST['phone']) 
        && empty($_POST['degree'])   
        && empty($_POST['poleNumber'])      
        && empty($_POST['badge'])  
        && empty($_POST['codecademy'])      
        && empty($_POST['secretAnswer'])         
        && empty($_POST['secretDesc'])      
        && empty($_POST['hackStory'])      
        && empty($_POST['finalQuestion'])
        && empty($_POST['nationality'])        
        ){
            //Affichage du formulaire si vide
            $testForm = true;
            $error = 'Tout les champs sont vides';
            $stockError['empty'] = $error;
        }
        else{
            //Affichage des données
        $testForm = false;

        //Correction et validation de toutes les données
        foreach ($_POST as $key => $value) {
            $_POST[$key] = valid_data($key,$value);
        }

        //Assignation des données dans des variables
        if(empty($_POST['firstname'])){
            $firstname = null;
        }else{
            $firstname = $_POST['firstname'];
        }

        if(empty($_POST['lastname'])){
            $lastname = null;
        }else{
            $lastname = $_POST['lastname'];
        }

        if(empty($_POST['birthday'])){
            $birthday = null;
        }else{
            $birthday = $_POST['birthday'];
        }

        if(empty($_POST['country'])){
            $country = "null";
        }else{
            $country = $_POST['country'];
        }

        if(empty($_POST['nationality'])){
            $nationality = null;
        }else{
            $nationality = $_POST['nationality'];
        }

        if(empty($_POST['number'])){
            $number = null;
        }else{
            $number = $_POST['number'];
        }

        if(empty($_POST['street'])){
            $street = null;
        }else{
            $street = $_POST['street'];
        }

        if(empty($_POST['city'])){
            $city = null;
        }else{
            $city = $_POST['city'];
        }

        if(empty($_POST['zip'])){
            $zip = null;
        }else{
            $zip = $_POST['zip'];
        }

        if(empty($_POST['mail'])){
            $mail = null;
        }else{
            $mail = $_POST['mail'];
        }

        if(empty($_POST['phone'])){
            $phone = null;
        }else{
            $phone = $_POST['phone'];
        }

        if(empty($_POST['degree'])){
            $degree = null;
        }else{
            $degree = $_POST['degree'];
        }

        if(empty($_POST['poleNumber'])){
            $poleNumber = null;
        }else{
            $poleNumber = $_POST['poleNumber'];
        }

        if(empty($_POST['badge'])){
            $badge = null;
        }else{
            $badge = $_POST['badge'];
        }

        if(empty($_POST['codecademy'])){
            $codecademy = null;
        }else{
            $codecademy = $_POST['codecademy'];
        }

        if(empty($_POST['secretAnswer'])){
            $secretAnswer = null;
        }else{
            $secretAnswer = $_POST['secretAnswer'];
        }

        if(empty($_POST['secretDesc'])){
            $secretDesc = null;
        }else{
            $secretDesc = $_POST['secretDesc'];
        }

        if(empty($_POST['hackStory'])){
            $hackStory = null;
        }else{
            $hackStory = $_POST['hackStory'];
        }

        if(empty($_POST['finalQuestion'])){
            $finalQuestion = null;
        }else{
            $finalQuestion = $_POST['finalQuestion'];
        }

        //Test regex avant de rentrer dans la BDD
        if(!preg_match($nameReg, $firstname) && !empty($firstname)){
            $error = "<br>ERREUR une donnée est invalide : Prénom";
            array_push($stockError, $error);
            $testForm = true;
        }

        if(!preg_match($nameReg, $lastname)&& !empty($lastname)){
            $error = "<br>ERREUR une donnée est invalide : Nom";
            $stockError['lastname'] = $error;
            $testForm = true;
        }

        if(!preg_match($zipReg, $zip)&& !empty($zip)){
            $error = "<br>ERREUR une donnée est invalide : Code postal";
            $stockError['zip'] = $error;
            $testForm = true;
        }

        if(!filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL) && !empty($mail)){
                $error = "<br>ERREUR une donnée est invalide : Mail";
                $stockError['mail'] = $error;
                $testForm = true;
        }

        if(!preg_match($telReg, $phone)&& !empty($phone)){
            $error = "<br>ERREUR une donnée est invalide : Téléphone";
            $stockError['phone'] = $error;
            $testForm = true;
        }

        if($degree != "Aucun" && $degree != "BAC" && $degree != "BAC+2" && $degree != "BAC+3" && $degree != "Supérieur à BAC+3" && !empty($degree)){
            $error = "<br>ERREUR une donnée est invalide :  Diplôme";
            $stockError['degree'] = $error;
            $testForm = true;
        }

        if(!preg_match($poleReg, $poleNumber)&& !empty($poleNumber)){

            $error = "<br> ERREUR une donnée est invalide : Numéro Pole emploi";
            $stockError['poleNumber'] = $error;
            $testForm = true;
        }

        if($number > 999 || $number < 0 || preg_match($letterReg, $number) && !empty($number)){
            $error = "<br>ERREUR une donnée est invalide :  Numéro de la rue";
            $stockError['number'] = $error;
            $testForm = true;
        }

        if(!filter_var($codecademy, FILTER_VALIDATE_URL) && !empty($codecademy)){
            $error = "<br>ERREUR une donnée est invalide : Lien Codecademy";
            $stockError['codecademy'] = $error;
            $testForm = true;
        }
        if($badge > 8 || $badge < 0 || preg_match($letterReg, $badge) && !empty($badge)){
            $error = "<br>ERREUR une donnée est invalide : Nombre de badge";
            $stockError['badge'] = $error;
            $testForm = true;
        }
        if(!preg_match($letterReg, $city) && !empty($city)){

            $error = "<br> ERREUR une donnée est invalide : Ville";
            $stockError['city'] = $error;
            $testForm = true;
        }
        }
    }
    
    if($testForm){
        session_destroy();
        session_start();
        $_SESSION["registered"] = false;
        include '../views/register.php';
    }else{
        
        session_destroy();
        session_start();
        echo $firstname;
        $_SESSION["registered"] = true;
        $sql = "INSERT INTO `user`(`firstname`, `lastname`, `birthday`, `number`, `street`, `city`, `zip`, `mail`, `phone`, `degree`, `poleNumber`, `badge`, `link`, `secretAnswer`, `secretDesc`, `hackStory`, `finalQuestion`, `nationality`, `country`) 
        VALUES('$firstname', '$lastname', '$birthday', '$number', '$street', '$city', '$zip', '$mail', '$phone', '$degree', '$poleNumber', '$badge', '$codecademy', '$secretAnswer', '$secretDesc', '$hackStory', '$finalQuestion', '$nationality', '$country')";
        $pdo->query($sql);
        include '../views/showtome.php';
    }
?>