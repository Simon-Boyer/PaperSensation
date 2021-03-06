<?php
    /**
     * Created by PhpStorm.
     * User: antoi
     * Date: 2018-05-11
     * Time: 11:05 AM
     */
    /**
     * Gère le téléversement d'un fichier donné
     * @param string $strNomPost Nom du fichier dans le tableau $_FILES[]
     * @param string $strNomDossier Nom du dossier où sera entreposé le fichier
     * @param string $strNouveauNom Nouveau nom du fichier qui remplacera celui fourni durant le téleversement (inclut
     * extension)
     * @param int $grandeurMax Grandeur maximum (en bytes) permise du fichier
     * @param string[] $tTypesFichiers Tableau des extensions de fichier permises (en minuscules)
     */
    function enregistrerDocument($strNomPost, $strNomDossier, $strNouveauNom = null, $grandeurMax = PHP_INT_MAX, $tTypesFichiers = []) {
        $strNomFichier = $_FILES[$strNomPost]["name"];
        $strTypeFichier = substr($strNomFichier, strrpos($strNomFichier, ".") + 1); //extension plutôt que MIME
        $strNomFichierTemp = $_FILES[$strNomPost]["tmp_name"];
        $binTypeValide = sizeof($tTypesFichiers) == 0 || in_array($strTypeFichier, $tTypesFichiers);
        $intTaille = intval($_FILES[$strNomPost]["size"]);
    
        if (!$binTypeValide)
            exit ("Le fichier n'est pas d'un type valide");
    
        if ($intTaille > $grandeurMax)
            exit("La grandeur du fichier excède la limite de " . $grandeurMax);
    
        if (!is_uploaded_file($strNomFichierTemp))
            exit("Téléversement impossible...");
    
        if (!move_uploaded_file($strNomFichierTemp, $strNomDossier . "/" .
            ($strNouveauNom ? $strNouveauNom : $strNomFichier)))
            exit("Impossible de copier le fichier '$strNomFichier' dans le dossier '$strNomDossier'");
    }
    
    function loadDonneesCSV($classe) {
        $objBD = mysql::getBD();
    
        $fp = fopen("./reset/$classe.csv", "r");
        $contenu = array();
    
        if (!feof($fp)) {
            fgetcsv($fp, 0, ";");
        }
    
        while (!feof($fp)) {
            $tChamps = fgetcsv($fp, 0, ";");
            if ($classe == "document") {
                $lastIndex = sizeof($tChamps) - 1;
                $objBD->selectionneRow("utilisateur", "id", "nomComplet='$tChamps[$lastIndex]'");
                $tChamps[$lastIndex] = $objBD->OK->fetch_row()[0];
                $tChamps[] = 0;
            }
            
            $contenu[] = $tChamps;
        }
    
        $objBD->insereEnregistrementsTableau($classe, $contenu);
    }