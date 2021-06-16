<?php
    //Déclaration des variables
     $error = '';
     $stockError ='';
     $testForm = true;
     //REGEX
     $telReg = "/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/";
     $nameReg = "/^[A-Za-z]+$/";
     $zipReg = "/^[\d]{5}$/";
     $mailReg = "/^((\w[^\W]+)[\.\-]?){1,}\@(([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
     $poleReg = "/^[0-9]{6}[A-Z]{1}$/";
     $linkReg = "/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/\/=]*)/";

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

    //Les données sont-elles envoyées ?
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //Test des champs
        if(empty($_POST['firstname']) || empty($_POST['lastname']) 
        || empty($_POST['birthday']) || empty($_POST['country']) 
        || empty($_POST['number']) || empty($_POST['street'])
        || empty($_POST['city']) || empty($_POST['zip'])
        || empty($_POST['mail']) || empty($_POST['phone'])
        || empty($_POST['degree']) || empty($_POST['poleNumber'])
        || empty($_POST['badge']) || empty($_POST['codecademy'])
        || empty($_POST['secretAnswer']) || empty($_POST['secretDesc'])
        || empty($_POST['hackStory']) || empty($_POST['finalQuestion'])
        || empty($_POST['nationality']) 
        ){
            //Affichage du formulaire si vide
            $testForm = true;
        }
        else{
            //Affichage des données
            $testForm = false;

            //Correction et validation de toutes les données
            foreach ($_POST as $key => $value) {
                $_POST[$key] = valid_data($key,$value);
            }

            //Assignation des données dans des variables
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $birthday = $_POST['birthday'];
            $country = $_POST['country'];
            $nationality = $_POST['nationality'];
            $number = $_POST['number'];
            $street = $_POST['street'];
            $city = $_POST['city'];
            $zipCode = $_POST['zip'];
            $mail = $_POST['mail'];
            $phone = $_POST['phone'];
            $degree = $_POST['degree'];
            $poleNumber = $_POST['poleNumber'];
            $badge = $_POST['badge'];
            $codecademy = $_POST['codecademy'];
            $secretAnswer = $_POST['secretAnswer'];
            $secretDesc = $_POST['secretDesc'];
            $hackStory = $_POST['hackStory'];
            $finalQuestion = $_POST['finalQuestion'];

            //Test regex avant de rentrer dans la BDD
            if(!preg_match($poleReg, $poleNumber)){
                
                $error = "<br> ERREUR une donnée est invalide : Numéro Pole emploi";
                $stockError = $stockError.$error;
                $testForm = true;
            }

            if(!preg_match($nameReg, $firstname)){
                
                $error = "<br>ERREUR une donnée est invalide : Prénom";
                $stockError = $stockError.$error;
                $testForm = true;
            }

            if(!preg_match($nameReg, $lastname)){
                $error = "<br>ERREUR une donnée est invalide : Nom";
                $stockError = $stockError.$error;
                $testForm = true;
            }

            if(!preg_match($mailReg, $mail)){
                $error = "<br>ERREUR une donnée est invalide : Mail";
                $stockError = $stockError.$error;
                $testForm = true;
            }

            if(!preg_match($telReg, $phone)){
                $error = "<br>ERREUR une donnée est invalide : Téléphone";
                $stockError = $stockError.$error;
                $testForm = true;
            }

            if(!preg_match($zipReg, $zipCode)){
                $error = "<br>ERREUR une donnée est invalide : Code postal";
                $stockError = $stockError.$error;
                $testForm = true;
            }

            if(!preg_match($linkReg, $codecademy)){
                $error = "<br>ERREUR une donnée est invalide : Liens Codecademy";
                $stockError = $stockError.$error;
                $testForm = true;
            }
            if($badge > 8 && $badge < 0){
                $error = "<br>ERREUR une donnée est invalide : Nombre de badge";
                $stockError = $stockError.$error;
                $testForm = true;
            }


        }
    }
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Inscription La Manu : inscrivez-vous afin de pouvoir accéder à votre espace personnel</title>
</head>

<body>
    <h1>Inscription La Manu</h1>
    <?php if($testForm) { ?>
    <!-- Formulaire -->
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <!-- Affichage des erreurs -->
        <?= $error ?>

        <!-- Nom / Prénom -->
        <div>
            <label for="lastname">Nom : </label>
            <input type="text" name="lastname" id="lastname" placeholder="Nom" required pattern="^[A-Za-z]+$">
            <label for="firstname">Prénom : </label>
            <input type="text" name="firstname" id="firstname" placeholder="Prénom" required pattern="^[A-Za-z]+$">
        </div>

        <!-- Date de naissance -->
        <div> 
            <label for="birthday">Date de naissance :</label>
            <input type="date" name="birthday" id="birthday" required>
        </div>

        <!-- Pays de naissance et nationalité  -->
        <div>
            <label for="country">Pays de naissance :</label>
            <select name="country" required >
                <!-- Selection du pays -->
                <option>Choisissez votre pays de naissance</option>
                <optgroup label="A">
                    <option value="afghanistan">Afghanistan</option>
                    <option value="afrique-du-sud">Afrique du Sud</option>
                    <option value="albanie">Albanie</option>
                    <option value="algerie">Algérie</option>
                    <option value="allemagne">Allemagne</option>
                    <option value="ancienne-republique-yougoslave-de-macedoine">Ancienne République yougoslave de
                        Macédoine
                    </option>
                    <option value="andorre">Andorre</option>
                    <option value="angola">Angola</option>
                    <option value="anguilla">Anguilla</option>
                    <option value="antarctique">Antarctique</option>
                    <option value="antigua-et-barbuda">Antigua-et-Barbuda</option>
                    <option value="antilles-neerlandaises">Antilles néerlandaises</option>
                    <option value="arabie-saoudite">Arabie saoudite</option>
                    <option value="argentine">Argentine</option>
                    <option value="armenie">Arménie</option>
                    <option value="aruba">Aruba</option>
                    <option value="australie">Australie</option>
                    <option value="autriche">Autriche</option>
                    <option value="azerbaidjan">Azerbaïdjan</option>
                </optgroup>
                <optgroup label="B">
                    <option value="bahamas">Bahamas</option>
                    <option value="bahrein">Bahreïn</option>
                    <option value="bangladesh">Bangladesh</option>
                    <option value="barbade">Barbade</option>
                    <option value="belgique">Belgique</option>
                    <option value="belize">Belize</option>
                    <option value="benin">Bénin</option>
                    <option value="bermudes">Bermudes</option>
                    <option value="bhoutan">Bhoutan</option>
                    <option value="bielorussie">Biélorussie</option>
                    <option value="bolivie">Bolivie</option>
                    <option value="bosnie-et-herzegovine">Bosnie-et-Herzégovine</option>
                    <option value="botswana">Botswana</option>
                    <option value="bresil">Brésil</option>
                    <option value="brunei-darussalam">Brunei Darussalam</option>
                    <option value="bulgarie">Bulgarie</option>
                    <option value="burkina-faso">Burkina Faso</option>
                    <option value="burundi">Burundi</option>
                </optgroup>
                <optgroup label="C">
                    <option value="cambodge">Cambodge</option>
                    <option value="cameroun">Cameroun</option>
                    <option value="canada">Canada</option>
                    <option value="cap-vert">Cap-Vert</option>
                    <option value="chili">Chili</option>
                    <option value="chine">Chine</option>
                    <option value="chypre">Chypre</option>
                    <option value="colombie">Colombie</option>
                    <option value="comores">Comores</option>
                    <option value="congo">Congo</option>
                    <option value="costa-rica">Costa Rica</option>
                    <option value="cote-d-ivoire">Côte d'Ivoire</option>
                    <option value="croatie">Croatie</option>
                    <option value="cuba">Cuba</option>
                </optgroup>
                <optgroup label="D">
                    <option value="danemark">Danemark</option>
                    <option value="djibouti">Djibouti</option>
                    <option value="dominique">Dominique</option>
                </optgroup>
                <optgroup label="E">
                    <option value="egypte">Égypte</option>
                    <option value="el-salvador">El Salvador</option>
                    <option value="emirats-arabes-unis">Émirats arabes unis</option>
                    <option value="equateur">Équateur</option>
                    <option value="erythree">Érythrée</option>
                    <option value="espagne">Espagne</option>
                    <option value="estonie">Estonie</option>
                    <option value="etats-federes-de-micronesie">États fédérés de Micronésie</option>
                    <option value="etats-unis">États-Unis</option>
                    <option value="ethiopie">Éthiopie</option>
                </optgroup>
                <optgroup label="F">
                    <option value="fidji">Fidji</option>
                    <option value="finlande">Finlande</option>
                    <option value="france">France</option>
                </optgroup>
                <optgroup label="G">
                    <option value="gabon">Gabon</option>
                    <option value="gambie">Gambie</option>
                    <option value="georgie">Géorgie</option>
                    <option value="georgie-du-sud-et-les-iles-sandwich-du-sud">Géorgie du Sud-et-les Îles Sandwich du
                        Sud
                    </option>
                    <option value="ghana">Ghana</option>
                    <option value="gibraltar">Gibraltar</option>
                    <option value="grece">Grèce</option>
                    <option value="grenade">Grenade</option>
                    <option value="groenland">Groenland</option>
                    <option value="guadeloupe">Guadeloupe</option>
                    <option value="guam">Guam</option>
                    <option value="guatemala">Guatemala</option>
                    <option value="guinee">Guinée</option>
                    <option value="guinee-equatoriale">Guinée équatoriale</option>
                    <option value="guinee-bissau">Guinée-Bissau</option>
                    <option value="guyane">Guyane</option>
                    <option value="guyane-francaise">Guyane française</option>
                </optgroup>
                <optgroup label="H">
                    <option value="haiti">Haïti</option>
                    <option value="honduras">Honduras</option>
                    <option value="hong-kong">Hong Kong</option>
                    <option value="hongrie">Hongrie</option>
                </optgroup>
                <optgroup label="I">
                    <option value="ile-bouvet">Ile Bouvet</option>
                    <option value="ile-christmas">Ile Christmas</option>
                    <option value="ile-norfolk">Île Norfolk</option>
                    <option value="ile-pitcairn">Île Pitcairn</option>
                    <option value="iles-aland">Iles Aland</option>
                    <option value="iles-cayman">Iles Cayman</option>
                    <option value="iles-cocos-keeling">Iles Cocos (Keeling)</option>
                    <option value="iles-cook">Iles Cook</option>
                    <option value="iles-feroe">Îles Féroé</option>
                    <option value="iles-heard-et-macdonald">Îles Heard-et-MacDonald</option>
                    <option value="iles-malouines">Îles Malouines</option>
                    <option value="iles-mariannes-du-nord">Îles Mariannes du Nord</option>
                    <option value="iles-marshall">Îles Marshall</option>
                    <option value="iles-mineures-eloignees-des-etats-unis">Îles mineures éloignées des États-Unis
                    </option>
                    <option value="iles-salomon">Îles Salomon</option>
                    <option value="iles-turques-et-caiques">Îles Turques-et-Caïques</option>
                    <option value="iles-vierges-britanniques">Îles Vierges britanniques</option>
                    <option value="iles-vierges-des-etats-unis">Îles Vierges des États-Unis</option>
                    <option value="inde">Inde</option>
                    <option value="indonesie">Indonésie</option>
                    <option value="iraq">Iraq</option>
                    <option value="irlande">Irlande</option>
                    <option value="islande">Islande</option>
                    <option value="israel">Israël</option>
                    <option value="italie">Italie</option>
                </optgroup>
                <optgroup label="J">
                    <option value="jamahiriya-arabe-libyenne">Jamahiriya arabe libyenne</option>
                    <option value="jamaique">Jamaïque</option>
                    <option value="japon">Japon</option>
                    <option value="jordanie">Jordanie</option>
                </optgroup>
                <optgroup label="K">
                    <option value="kazakhstan">Kazakhstan</option>
                    <option value="kenya">Kenya</option>
                    <option value="kirghizistan">Kirghizistan</option>
                    <option value="kiribati">Kiribati</option>
                    <option value="koweit">Koweït</option>
                </optgroup>
                <optgroup label="L">
                    <option value="lesotho">Lesotho</option>
                    <option value="lettonie">Lettonie</option>
                    <option value="liban">Liban</option>
                    <option value="liberia">Libéria</option>
                    <option value="liechtenstein">Liechtenstein</option>
                    <option value="lituanie">Lituanie</option>
                    <option value="luxembourg">Luxembourg</option>
                </optgroup>
                <optgroup label="M">
                    <option value="macao">Macao</option>
                    <option value="madagascar">Madagascar</option>
                    <option value="malaisie">Malaisie</option>
                    <option value="malawi">Malawi</option>
                    <option value="maldives">Maldives</option>
                    <option value="mali">Mali</option>
                    <option value="malte">Malte</option>
                    <option value="maroc">Maroc</option>
                    <option value="martinique">Martinique</option>
                    <option value="maurice">Maurice</option>
                    <option value="mauritanie">Mauritanie</option>
                    <option value="mayotte">Mayotte</option>
                    <option value="mexique">Mexique</option>
                    <option value="monaco">Monaco</option>
                    <option value="mongolie">Mongolie</option>
                    <option value="montserrat">Montserrat</option>
                    <option value="mozambique">Mozambique</option>
                    <option value="myanmar">Myanmar</option>
                </optgroup>
                <optgroup label="N">
                    <option value="namibie">Namibie</option>
                    <option value="nauru">Nauru</option>
                    <option value="nepal">Népal</option>
                    <option value="nicaragua">Nicaragua</option>
                    <option value="niger">Niger</option>
                    <option value="nigeria">Nigéria</option>
                    <option value="niue">Niué</option>
                    <option value="norvege">Norvège</option>
                    <option value="nouvelle-caledonie">Nouvelle-Calédonie</option>
                    <option value="nouvelle-zelande">Nouvelle-Zélande</option>
                </optgroup>
                <optgroup label="O">
                    <option value="oman">Oman</option>
                    <option value="ouganda">Ouganda</option>
                    <option value="ouzbekistan">Ouzbékistan</option>
                </optgroup>
                <optgroup label="P">
                    <option value="pakistan">Pakistan</option>
                    <option value="palaos">Palaos</option>
                    <option value="panama">Panama</option>
                    <option value="papouasie-nouvelle-guinee">Papouasie-Nouvelle-Guinée</option>
                    <option value="paraguay">Paraguay</option>
                    <option value="pays-bas">Pays-Bas</option>
                    <option value="perou">Pérou</option>
                    <option value="philippines">Philippines</option>
                    <option value="pologne">Pologne</option>
                    <option value="polynesie-francaise">Polynésie française</option>
                    <option value="porto-rico">Porto Rico</option>
                    <option value="portugal">Portugal</option>
                    <option value="province-chinoise-de-taiwan">Province chinoise de Taiwan</option>
                </optgroup>
                <optgroup label="Q">
                    <option value="qatar">Qatar</option>
                </optgroup>
                <optgroup label="R">
                    <option value="republique-arabe-syrienne">République arabe syrienne</option>
                    <option value="republique-centrafricaine">République centrafricaine</option>
                    <option value="republique-de-coree">République de Corée</option>
                    <option value="republique-de-moldavie">République de Moldavie</option>
                    <option value="republique-democratique-du-congo">République démocratique du Congo</option>
                    <option value="republique-dominicaine">République dominicaine</option>
                    <option value="republique-islamique-d-iran">République islamique d'Iran</option>
                    <option value="republique-populaire-democratique-de-coree">République populaire démocratique de
                        Corée
                    </option>
                    <option value="republique-populaire-du-laos">République Populaire du Laos</option>
                    <option value="republique-tcheque">République tchèque</option>
                    <option value="republique-unie-de-tanzanie">République-Unie de Tanzanie</option>
                    <option value="reunion">Réunion</option>
                    <option value="roumanie">Roumanie</option>
                    <option value="royaume-uni">Royaume-Uni</option>
                    <option value="russie">Russie</option>
                    <option value="rwanda">Rwanda</option>
                </optgroup>
                <optgroup label="S">
                    <option value="sahara-occidental">Sahara occidental</option>
                    <option value="saint-christophe-et-nieves">Saint-Christophe-et-Niévès</option>
                    <option value="saint-marin">Saint-Marin</option>
                    <option value="saint-pierre-et-miquelon">Saint-Pierre-et-Miquelon</option>
                    <option value="saint-siege-cite-du-vatican">Saint-Siège (Cité du Vatican)</option>
                    <option value="saint-vincent-et-les-grenadines">Saint-Vincent-et-les Grenadines</option>
                    <option value="sainte-helene">Sainte-Hélène</option>
                    <option value="sainte-lucie">Sainte-Lucie</option>
                    <option value="samoa">Samoa</option>
                    <option value="samoa-americaines">Samoa américaines</option>
                    <option value="sao-tome-et-principe">Sao Tomé-et-Principe</option>
                    <option value="senegal">Sénégal</option>
                    <option value="serbie-et-montenegro">Serbie-et-Monténégro</option>
                    <option value="seychelles">Seychelles</option>
                    <option value="sierra-leone">Sierra Leone</option>
                    <option value="singapour">Singapour</option>
                    <option value="slovaquie">Slovaquie</option>
                    <option value="slovenie">Slovénie</option>
                    <option value="somalie">Somalie</option>
                    <option value="soudan">Soudan</option>
                    <option value="sri-lanka">Sri Lanka</option>
                    <option value="suede">Suède</option>
                    <option value="suisse">Suisse</option>
                    <option value="suriname">Suriname</option>
                    <option value="svalbard-et-jan-mayen">Svalbard et Jan Mayen</option>
                    <option value="swaziland">Swaziland</option>
                </optgroup>
                <optgroup label="T">
                    <option value="tadjikistan">Tadjikistan</option>
                    <option value="tchad">Tchad</option>
                    <option value="territoire-britannique-de-l-ocean-indien">Territoire britannique de l'océan Indien
                    </option>
                    <option value="territoire-francais-du-sud">Territoire Francais du Sud</option>
                    <option value="territoires-palestiniens-occupes">Territoires palestiniens occupés</option>
                    <option value="thailande">Thaïlande</option>
                    <option value="timor-oriental">Timor oriental</option>
                    <option value="togo">Togo</option>
                    <option value="tokelau">Tokelau</option>
                    <option value="tonga">Tonga</option>
                    <option value="trinite-et-tobago">Trinité-et-Tobago</option>
                    <option value="tunisie">Tunisie</option>
                    <option value="turkmenistan">Turkménistan</option>
                    <option value="turquie">Turquie</option>
                    <option value="tuvalu">Tuvalu</option>
                </optgroup>
                <optgroup label="U">
                    <option value="ukraine">Ukraine</option>
                    <option value="uruguay">Uruguay</option>
                </optgroup>
                <optgroup label="V">
                    <option value="vanuatu">Vanuatu</option>
                    <option value="venezuela">Vénézuéla</option>
                    <option value="vietnam">Vietnam</option>
                </optgroup>
                <optgroup label="W">
                    <option value="wallis-et-futuna">Wallis-et-Futuna</option>
                </optgroup>
                <optgroup label="Y">
                    <option value="yemen">Yémen</option>
                </optgroup>
                <optgroup label="Z">
                    <option value="zambie">Zambie</option>
                    <option value="zimbabwe">Zimbabwe</option>
                </optgroup>
            </select></div>
        <div> 
            <label for="nationality">Nationalité : </label>
            <select name="nationality" required>
                <!-- Selection de la nationalité -->
                <option>Choisissez votre nationalité..</option>
                <option value="AFG">Afghane (Afghanistan)</option>
                <option value="ALB">Albanaise (Albanie)</option>
                <option value="DZA">Algérienne (Algérie)</option>
                <option value="DEU">Allemande (Allemagne)</option>
                <option value="USA">Americaine (États-Unis)</option>
                <option value="AND">Andorrane (Andorre)</option>
                <option value="AGO">Angolaise (Angola)</option>
                <option value="ATG">Antiguaise-et-Barbudienne (Antigua-et-Barbuda)</option>
                <option value="ARG">Argentine (Argentine)</option>
                <option value="ARM">Armenienne (Arménie)</option>
                <option value="AUS">Australienne (Australie)</option>
                <option value="AUT">Autrichienne (Autriche)</option>
                <option value="AZE">Azerbaïdjanaise (Azerbaïdjan)</option>
                <option value="BHS">Bahamienne (Bahamas)</option>
                <option value="BHR">Bahreinienne (Bahreïn)</option>
                <option value="BGD">Bangladaise (Bangladesh)</option>
                <option value="BRB">Barbadienne (Barbade)</option>
                <option value="BEL">Belge (Belgique)</option>
                <option value="BLZ">Belizienne (Belize)</option>
                <option value="BEN">Béninoise (Bénin)</option>
                <option value="BTN">Bhoutanaise (Bhoutan)</option>
                <option value="BLR">Biélorusse (Biélorussie)</option>
                <option value="MMR">Birmane (Birmanie)</option>
                <option value="GNB">Bissau-Guinéenne (Guinée-Bissau)</option>
                <option value="BOL">Bolivienne (Bolivie)</option>
                <option value="BIH">Bosnienne (Bosnie-Herzégovine)</option>
                <option value="BWA">Botswanaise (Botswana)</option>
                <option value="BRA">Brésilienne (Brésil)</option>
                <option value="GBR">Britannique (Royaume-Uni)</option>
                <option value="BRN">Brunéienne (Brunéi)</option>
                <option value="BGR">Bulgare (Bulgarie)</option>
                <option value="BFA">Burkinabée (Burkina)</option>
                <option value="BDI">Burundaise (Burundi)</option>
                <option value="KHM">Cambodgienne (Cambodge)</option>
                <option value="CMR">Camerounaise (Cameroun)</option>
                <option value="CAN">Canadienne (Canada)</option>
                <option value="CPV">Cap-verdienne (Cap-Vert)</option>
                <option value="CAF">Centrafricaine (Centrafrique)</option>
                <option value="CHL">Chilienne (Chili)</option>
                <option value="CHN">Chinoise (Chine)</option>
                <option value="CYP">Chypriote (Chypre)</option>
                <option value="COL">Colombienne (Colombie)</option>
                <option value="COM">Comorienne (Comores)</option>
                <option value="COG">Congolaise (Congo-Brazzaville)</option>
                <option value="COD">Congolaise (Congo-Kinshasa)</option>
                <option value="COK">Cookienne (Îles Cook)</option>
                <option value="CRI">Costaricaine (Costa Rica)</option>
                <option value="HRV">Croate (Croatie)</option>
                <option value="CUB">Cubaine (Cuba)</option>
                <option value="DNK">Danoise (Danemark)</option>
                <option value="DJI">Djiboutienne (Djibouti)</option>
                <option value="DOM">Dominicaine (République dominicaine)</option>
                <option value="DMA">Dominiquaise (Dominique)</option>
                <option value="EGY">Égyptienne (Égypte)</option>
                <option value="ARE">Émirienne (Émirats arabes unis)</option>
                <option value="GNQ">Équato-guineenne (Guinée équatoriale)</option>
                <option value="ECU">Équatorienne (Équateur)</option>
                <option value="ERI">Érythréenne (Érythrée)</option>
                <option value="ESP">Espagnole (Espagne)</option>
                <option value="TLS">Est-timoraise (Timor-Leste)</option>
                <option value="EST">Estonienne (Estonie)</option>
                <option value="ETH">Éthiopienne (Éthiopie)</option>
                <option value="FJI">Fidjienne (Fidji)</option>
                <option value="FIN">Finlandaise (Finlande)</option>
                <option value="FRA">Française (France)</option>
                <option value="GAB">Gabonaise (Gabon)</option>
                <option value="GMB">Gambienne (Gambie)</option>
                <option value="GEO">Georgienne (Géorgie)</option>
                <option value="GHA">Ghanéenne (Ghana)</option>
                <option value="GRD">Grenadienne (Grenade)</option>
                <option value="GTM">Guatémaltèque (Guatemala)</option>
                <option value="GIN">Guinéenne (Guinée)</option>
                <option value="GUY">Guyanienne (Guyana)</option>
                <option value="HTI">Haïtienne (Haïti)</option>
                <option value="GRC">Hellénique (Grèce)</option>
                <option value="HND">Hondurienne (Honduras)</option>
                <option value="HUN">Hongroise (Hongrie)</option>
                <option value="IND">Indienne (Inde)</option>
                <option value="IDN">Indonésienne (Indonésie)</option>
                <option value="IRQ">Irakienne (Iraq)</option>
                <option value="IRN">Iranienne (Iran)</option>
                <option value="IRL">Irlandaise (Irlande)</option>
                <option value="ISL">Islandaise (Islande)</option>
                <option value="ISR">Israélienne (Israël)</option>
                <option value="ITA">Italienne (Italie)</option>
                <option value="CIV">Ivoirienne (Côte d'Ivoire)</option>
                <option value="JAM">Jamaïcaine (Jamaïque)</option>
                <option value="JPN">Japonaise (Japon)</option>
                <option value="JOR">Jordanienne (Jordanie)</option>
                <option value="KAZ">Kazakhstanaise (Kazakhstan)</option>
                <option value="KEN">Kenyane (Kenya)</option>
                <option value="KGZ">Kirghize (Kirghizistan)</option>
                <option value="KIR">Kiribatienne (Kiribati)</option>
                <option value="KNA">Kittitienne et Névicienne (Saint-Christophe-et-Niévès)</option>
                <option value="KWT">Koweïtienne (Koweït)</option>
                <option value="LAO">Laotienne (Laos)</option>
                <option value="LSO">Lesothane (Lesotho)</option>
                <option value="LVA">Lettone (Lettonie)</option>
                <option value="LBN">Libanaise (Liban)</option>
                <option value="LBR">Libérienne (Libéria)</option>
                <option value="LBY">Libyenne (Libye)</option>
                <option value="LIE">Liechtensteinoise (Liechtenstein)</option>
                <option value="LTU">Lituanienne (Lituanie)</option>
                <option value="LUX">Luxembourgeoise (Luxembourg)</option>
                <option value="MKD">Macédonienne (Macédoine)</option>
                <option value="MYS">Malaisienne (Malaisie)</option>
                <option value="MWI">Malawienne (Malawi)</option>
                <option value="MDV">Maldivienne (Maldives)</option>
                <option value="MDG">Malgache (Madagascar)</option>
                <option value="MLI">Maliennes (Mali)</option>
                <option value="MLT">Maltaise (Malte)</option>
                <option value="MAR">Marocaine (Maroc)</option>
                <option value="MHL">Marshallaise (Îles Marshall)</option>
                <option value="MUS">Mauricienne (Maurice)</option>
                <option value="MRT">Mauritanienne (Mauritanie)</option>
                <option value="MEX">Mexicaine (Mexique)</option>
                <option value="FSM">Micronésienne (Micronésie)</option>
                <option value="MDA">Moldave (Moldovie)</option>
                <option value="MCO">Monegasque (Monaco)</option>
                <option value="MNG">Mongole (Mongolie)</option>
                <option value="MNE">Monténégrine (Monténégro)</option>
                <option value="MOZ">Mozambicaine (Mozambique)</option>
                <option value="NAM">Namibienne (Namibie)</option>
                <option value="NRU">Nauruane (Nauru)</option>
                <option value="NLD">Néerlandaise (Pays-Bas)</option>
                <option value="NZL">Néo-Zélandaise (Nouvelle-Zélande)</option>
                <option value="NPL">Népalaise (Népal)</option>
                <option value="NIC">Nicaraguayenne (Nicaragua)</option>
                <option value="NGA">Nigériane (Nigéria)</option>
                <option value="NER">Nigérienne (Niger)</option>
                <option value="NIU">Niuéenne (Niue)</option>
                <option value="PRK">Nord-coréenne (Corée du Nord)</option>
                <option value="NOR">Norvégienne (Norvège)</option>
                <option value="OMN">Omanaise (Oman)</option>
                <option value="UGA">Ougandaise (Ouganda)</option>
                <option value="UZB">Ouzbéke (Ouzbékistan)</option>
                <option value="PAK">Pakistanaise (Pakistan)</option>
                <option value="PLW">Palaosienne (Palaos)</option>
                <option value="PSE">Palestinienne (Palestine)</option>
                <option value="PAN">Panaméenne (Panama)</option>
                <option value="PNG">Papouane-Néo-Guinéenne (Papouasie-Nouvelle-Guinée)</option>
                <option value="PRY">Paraguayenne (Paraguay)</option>
                <option value="PER">Péruvienne (Pérou)</option>
                <option value="PHL">Philippine (Philippines)</option>
                <option value="POL">Polonaise (Pologne)</option>
                <option value="PRT">Portugaise (Portugal)</option>
                <option value="QAT">Qatarienne (Qatar)</option>
                <option value="ROU">Roumaine (Roumanie)</option>
                <option value="RUS">Russe (Russie)</option>
                <option value="RWA">Rwandaise (Rwanda)</option>
                <option value="LCA">Saint-Lucienne (Sainte-Lucie)</option>
                <option value="SMR">Saint-Marinaise (Saint-Marin)</option>
                <option value="VCT">Saint-Vincentaise et Grenadine (Saint-Vincent-et-les Grenadines)</option>
                <option value="SLB">Salomonaise (Îles Salomon)</option>
                <option value="SLV">Salvadorienne (Salvador)</option>
                <option value="WSM">Samoane (Samoa)</option>
                <option value="STP">Santoméenne (Sao Tomé-et-Principe)</option>
                <option value="SAU">Saoudienne (Arabie saoudite)</option>
                <option value="SEN">Sénégalaise (Sénégal)</option>
                <option value="SRB">Serbe (Serbie)</option>
                <option value="SYC">Seychelloise (Seychelles)</option>
                <option value="SLE">Sierra-Léonaise (Sierra Leone)</option>
                <option value="SGP">Singapourienne (Singapour)</option>
                <option value="SVK">Slovaque (Slovaquie)</option>
                <option value="SVN">Slovène (Slovénie)</option>
                <option value="SOM">Somalienne (Somalie)</option>
                <option value="SDN">Soudanaise (Soudan)</option>
                <option value="LKA">Sri-Lankaise (Sri Lanka)</option>
                <option value="ZAF">Sud-Africaine (Afrique du Sud)</option>
                <option value="KOR">Sud-Coréenne (Corée du Sud)</option>
                <option value="SSD">Sud-Soudanaise (Soudan du Sud)</option>
                <option value="SWE">Suédoise (Suède)</option>
                <option value="CHE">Suisse (Suisse)</option>
                <option value="SUR">Surinamaise (Suriname)</option>
                <option value="SWZ">Swazie (Swaziland)</option>
                <option value="SYR">Syrienne (Syrie)</option>
                <option value="TJK">Tadjike (Tadjikistan)</option>
                <option value="TZA">Tanzanienne (Tanzanie)</option>
                <option value="TCD">Tchadienne (Tchad)</option>
                <option value="CZE">Tchèque (Tchéquie)</option>
                <option value="THA">Thaïlandaise (Thaïlande)</option>
                <option value="TGO">Togolaise (Togo)</option>
                <option value="TON">Tonguienne (Tonga)</option>
                <option value="TTO">Trinidadienne (Trinité-et-Tobago)</option>
                <option value="TUN">Tunisienne (Tunisie)</option>
                <option value="TKM">Turkmène (Turkménistan)</option>
                <option value="TUR">Turque (Turquie)</option>
                <option value="TUV">Tuvaluane (Tuvalu)</option>
                <option value="UKR">Ukrainienne (Ukraine)</option>
                <option value="URY">Uruguayenne (Uruguay)</option>
                <option value="VUT">Vanuatuane (Vanuatu)</option>
                <option value="VAT">Vaticane (Vatican)</option>
                <option value="VEN">Vénézuélienne (Venezuela)</option>
                <option value="VNM">Vietnamienne (Viêt Nam)</option>
                <option value="YEM">Yéménite (Yémen)</option>
                <option value="ZMB">Zambienne (Zambie)</option>
                <option value="ZWE">Zimbabwéenne (Zimbabwe)</option>
            </select>
        </div>
        
        <!-- Date de naissance -->
        <div>
            <label for="number">Adresse : </label>
            <input type="number" name="number" id="number" placeholder="N°" required min="1" max="999">
            <input type="text" name="street" id="street" placeholder="Rue" required>
            <input type="text" name="city" id="city" placeholder="Ville" required>
            <input type="text" name="zip" id="zip" size="8" maxlenght="5" placeholder="Code postal" required pattern="^[\d]{5}$" >
        </div>
        
        <!-- Email -->
        <div>
            <label for="mail">E-mail : </label>
            <input type="email" name="mail" id="mail" placeholder="Email" required pattern="^((\w[^\W]+)[\.\-]?){1,}\@(([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$">
        </div>

        <!-- Numéro de téléphone -->
        <div>
            <label for="phone">Téléphone : </label>
            <input type="tel" name="phone" id="phone" placeholder="Téléphone" required pattern="^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$" onkeyup="this.value = this.value.trim();">
        </div>

        <!-- Diplome -->
        <div> 
            <label for="degree">Diplôme : </label>
            <select name="degree" id="degree" required>
                <option value="">Niveau de diplôme ?</option>
                <option value="Aucun">Aucun</option>
                <option value="BAC">BAC</option>
                <option value="BAC+2">BAC +2</option>
                <option value="BAC+3">BAC +3</option>
                <option value="Supérieur à BAC+3">Supérieur à BAC +3</option>
            </select>
        </div>

        <!-- Numéro pole emploi -->
        <div>
            <label for="poleNumber">Numéro Pôle emploi : </label>
            <input type="text" name="poleNumber" id="poleNumber" placeholder="Numéro candidat" required pattern="^[0-9]{6}[A-Z]{1}$" onkeyup="this.value = this.value.toUpperCase();">
        </div>

        <!-- Nombre de badge -->
        <div>
            <label for="badge">Nombre de badge(s) : </label>
            <input type="number" name="badge" id="badge" required min="0" max="8">
        </div>

        <!-- Liens Codecademy -->
        <div>
            <label for="codecademy">Lien Codecademy</label>
            <input type="text" name="codecademy" id="codecademy" placeholder="Lien codecademy" required pattern="https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/\/=]*)">
        </div>

        <!-- Question secrète -->
        <div class="column">
            <h4>Si vous étiez un super héros/une super héroïne, qui seriez-vous et pourquoi ?</h4>
            <label for="secretAnswer">Qui ? </label>
            <input type="text" name="secretAnswer" id="secretQuestion" placeholder="Quel super héro ?" required>
            <label for="secretDesc">Pourquoi ?</label>
            <textarea name="secretDesc" id="secretDesc" placeholder="Pourquoi ce choix ?" cols="30" rows="5" required></textarea>
        </div>

        <!-- Hacks story -->
        <div class="column"> 
            <label for="hackStory"><h4>Racontez-nous un de vos "hacks" (pas forcément technique ou informatique)</h4></label>
            <textarea name="hackStory" id="hackStory" cols="30" rows="5" placeholder="Votre hack préféré.." required></textarea>
        </div>

        <!-- Question final -->
        <div> 
            <label for="finalQuestion">Avez vous déjà eu une expérience avec la programmation <br> et/ou l'informatique avant de remplir ce formulaire ?</label>
            <select name="finalQuestion" id="finalQuestion" required>
                <option value=""></option>
                <option value="oui">Oui</option>
                <option value="non">Non</option>
            </select>
        </div>
        <!-- Envoi du formulaire -->
        <button type="submit">Envoyer !</button>
    </form>
    <?php 
    //Affichage des données
    }else{ ?>
        <div class="info">
            <h1>Bonjour <?=$firstname.' '.$lastname?></h1>
            <div class="list">
                <strong>Votre date de naissance est :</strong>  <?=$birthday?> <br>
                <strong>Votre pays de naissance est :</strong> <?=$country?> <br>
                <strong>Votre nationalité est :</strong>  <?=$nationality?> <br>
                <strong>Adresse :</strong> <?=$number.' '.$street.' à '.$city.', '.$zipCode?> <br>
                <strong>Votre e-mail :</strong>  <?=$mail?> <br>
                <strong>Votre numéro de téléphone :</strong>  <?=$mail?> <br>
                <strong>Vos diplômes :</strong> <?=$degree?> <br>
                <strong>Vos numéro pôle emploi :</strong> <?=$poleNumber?> <br>
                <strong>Vous avez :</strong> <?=$badge?> Badge(s) <br>
                <strong>Votre lien vers Codecademy :</strong> <a href="<?=$codecademy?>" target="_blank">Allons-y</a> <br>
                <strong>Quelle super héro seriez vous ?</strong> <?=$secretAnswer?> car <?=$secretDesc?> <br>
                <strong>Votre hack préféré ?</strong> <?=$hackStory?><br>
                <strong>Expérience en programmation ?</strong> <?=$finalQuestion?><br>
            </div>
        </div>

    <?php } ?>
    <script src="assets/js/main.js"></script>
</body>

</html>