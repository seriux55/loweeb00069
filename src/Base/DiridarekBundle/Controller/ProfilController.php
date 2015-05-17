<?php

namespace Base\DiridarekBundle\Controller;

class ProfilController extends Controller
{
    public function albumAction()
    {
        if(isset($_SESSION) && isset($_POST) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1 && isset($_POST['category']) && !empty($_POST['category']) && $_POST['category']>=1 && $_POST['category']<=4){
	
            $sqlsession = "SELECT id FROM compte WHERE mail='".htmlentities(addslashes($_SESSION['mail']))."' AND mdp='".htmlentities(addslashes($_SESSION['mdp']))."' AND id='".intval($_SESSION['id'])."' LIMIT 1";
            $reqsession = mysqli_query($db,$sqlsession);
            $nbrsession = mysqli_num_rows($reqsession);
            if($nbrsession == 1){

                $photo_name = "photo".$_POST['category'];

                $sqq = "SELECT ".$photo_name." FROM compte WHERE id='".intval($_SESSION['id'])."'";
                $ree = mysqli_query($db,$sqq);
                $lii = mysqli_fetch_assoc($ree);

                $ph  = $lii[$photo_name];

                if($_FILES["upload"]["size"]<=10000000 and $_FILES["upload"]["size"]>0)
                {

                    $infofich = pathinfo($_FILES["upload"]["name"]);
                    $ext      = $infofich['extension'];
                    $file     = uniqid().'.jpg';
                    $ext      = strtolower($ext);
                    $extAut   = array('jpg','jpeg','gif','png');
                    if(in_array($ext,$extAut))
                    {

                        $size = getimagesize($_FILES["upload"]["tmp_name"]);
                        if( $size[1] == $size[0] ){
                                $destination = imagecreatetruecolor(320, 320);
                        }else if( $size[1] > $size[0] ){ 
                                $rap = $size[0] / $size[1];
                                $L   = 320 * $rap;
                                $destination = imagecreatetruecolor($L, 320);
                        }else if( $size[0] > $size[1] ){ 
                                $rap = $size[1] / $size[0];
                                $H   = 320 * $rap;
                                $destination = imagecreatetruecolor(320, $H);
                        }
                        $source              = imagecreatefromjpeg($_FILES["upload"]["tmp_name"]);
                        $largeur_source      = imagesx($source);
                        $hauteur_source      = imagesy($source);
                        $largeur_destination = imagesx($destination);
                        $hauteur_destination = imagesy($destination);
                        $chemin		 = '../../img/album/'.$file;

                        imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
                        $resultat = imagejpeg($destination, $chemin);

                        if($resultat){
                            $photo = $file; 
                            if ( ($ph != "") && file_exists("../../img/album/".$ph) ) unlink("../../img/album/".$ph); 					
                        }
                        else{ $photo = $ph; }
                    }
                    else{ $photo = $ph; }      
                }
                else{ $photo = $ph; }

                $ip = $_SERVER['REMOTE_ADDR'];
                $sql = "INSERT INTO pictures (id_compte,photo,category,last,ip,deposit) VALUES ('".intval($_SESSION['id'])."','".@mysqli_real_escape_string($db, $photo)."','".@intval($_POST['category'])."','".@mysqli_real_escape_string($db, $ph)."','".@mysqli_real_escape_string($db, $ip)."',now())";
                $req = mysqli_query($db,$sql);
                
            }
            mysqli_close($db);
        }
        header('Location: http://www.diridarek.com/view/profil.php');
    }
    
    public function commentaireAction()
    {
        if(isset($_SESSION) && isset($_POST) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
	
            $sqlsession = "SELECT id FROM compte WHERE mail='".htmlentities(addslashes($_SESSION['mail']))."' AND mdp='".htmlentities(addslashes($_SESSION['mdp']))."' AND id='".intval($_SESSION['id'])."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){
                $ip  = $_SERVER['REMOTE_ADDR']; 
                $sql = "INSERT INTO comment (id_compte_sent,id_compte_receive,smily,comment,ip,deposit) VALUES ('".intval($_SESSION['id'])."','".intval($_POST['receive'])."','".intval($_POST['smily'])."','".@mysqli_real_escape_string($db, utf8_decode($_POST['comment']))."','".@mysqli_real_escape_string($db, $ip)."', now())";
                $req = @mysqli_query($db,$sql);
            }
            @mysqli_close($db);
        }
    }
    
    public function couvertureAction()
    {
        if(isset($_SESSION) && isset($_POST) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
	
            include '../../../dd.php';
            $sqlsession = "SELECT id FROM compte WHERE mail='".htmlentities(addslashes($_SESSION['mail']))."' AND mdp='".htmlentities(addslashes($_SESSION['mdp']))."' AND id='".intval($_SESSION['id'])."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){

                    $sqq = "SELECT couverture FROM compte WHERE id='".intval($_SESSION['id'])."'";
                    $ree = @mysqli_query($db,$sqq);
                    $lii = @mysqli_fetch_assoc($ree);

            $ph  = $lii['couveture'];

            if($_FILES["upload"]["size"]<=10000000 and $_FILES["upload"]["size"]>0)
            {

                $infofich = @pathinfo($_FILES["upload"]["name"]);
                $ext      = $infofich['extension'];
                $file     = @uniqid().'.jpg';
                $ext      = @strtolower($ext);
                $extAut   = array('jpg','jpeg','gif','png');
                if(@in_array($ext,$extAut))
                {

                    $source              = @imagecreatefromjpeg($_FILES["upload"]["tmp_name"]);
                    $destination         = @imagecreatetruecolor(720, 249);
                    $largeur_source      = @imagesx($source);
                    $hauteur_source      = @imagesy($source);
                    $largeur_destination = @imagesx($destination);
                    $hauteur_destination = @imagesy($destination);
                                    $chemin				 = '../../img/couverture/'.$file;

                    @imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
                    $resultat = @imagejpeg($destination, $chemin);

                    if($resultat){

                        $photo = $file; 
                        if ( ($ph != "") && @file_exists("../../img/couverture/".$ph) ) @unlink("../../img/couverture/".$ph); 					
                    }
                    else{ $photo = $ph; }
                }
                else{ $photo = $ph; }      
            }
            else{ $photo = $ph; }

                    $sql = "UPDATE compte SET couverture='".htmlentities(addslashes($photo))."' WHERE id='".intval($_SESSION['id'])."'";
                    $req = @mysqli_query($db,$sql);
            }
            @mysqli_free_result($req);
            @mysqli_free_result($ree);
            @mysqli_free_result($reqsession);
            @mysqli_close($db);
        }
        header('Location: http://www.diridarek.com/view/profil.php');
    }
    
    public function descriptionAction()
    {
        if(isset($_SESSION) && isset($_POST) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
	
            $sqlsession = "SELECT id FROM compte WHERE mail='".htmlentities(addslashes($_SESSION['mail']))."' AND mdp='".htmlentities(addslashes($_SESSION['mdp']))."' AND id='".intval($_SESSION['id'])."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){
                $ip = $_SERVER['REMOTE_ADDR'];
                $sql = "UPDATE compte SET description='".@mysqli_real_escape_string($db, utf8_decode($_POST['description']))."' WHERE id='".intval($_SESSION['id'])."'";
                $req = @mysqli_query($db,$sql);
                // écriture dans l'actu
                $sql = "INSERT INTO actu (id_compte,type,ip,depot,describ_H) VALUES ('".intval($_SESSION['id'])."','2','".@mysqli_real_escape_string($db, $ip)."',now(),'".@mysqli_real_escape_string($db, utf8_decode($_POST['description']))."')";
                $req = @mysqli_query($db,$sql);
            }
            @mysqli_close($db);
        }
        header('Location: http://www.diridarek.com/view/profil.php');
    }
    
    public function infoAction()
    {
        if(isset($_SESSION) && isset($_POST) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
	
            $sqlsession = "SELECT id FROM compte WHERE mail='".htmlentities(addslashes($_SESSION['mail']))."' AND mdp='".htmlentities(addslashes($_SESSION['mdp']))."' AND id='".intval($_SESSION['id'])."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){
                $sql = "UPDATE compte SET nom='".@mysqli_real_escape_string($db, utf8_decode($_POST['nom']))."',prenom='".@mysqli_real_escape_string($db, utf8_decode($_POST['prenom']))."',naissance='".@mysqli_real_escape_string($db, utf8_decode($_POST['naissance']))."' WHERE id='".intval($_SESSION['id'])."'";
                $req = @mysqli_query($db,$sql);
            }
            @mysqli_close($db);
        }
        header('Location: http://www.diridarek.com/view/profil.php');
    }
    
    public function informationAction()
    {
        if(isset($_SESSION) && isset($_POST) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
            $sqlsession = "SELECT id FROM compte WHERE mail='".htmlentities(addslashes($_SESSION['mail']))."' AND mdp='".htmlentities(addslashes($_SESSION['mdp']))."' AND id='".intval($_SESSION['id'])."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){
                    $sql = "UPDATE compte SET naissance='".intval($_POST['naissance'])."',prenom='".@mysqli_real_escape_string($db, utf8_decode($_POST['prenom']))."',ville='".@mysqli_real_escape_string($db, utf8_decode($_POST['villeA']))."',villeN='".@mysqli_real_escape_string($db, utf8_decode($_POST['villeB']))."',fonction='".@mysqli_real_escape_string($db, utf8_decode($_POST['func']))."' WHERE id='".intval($_SESSION['id'])."'";
                    $req = @mysqli_query($db,$sql);
            }
            @mysqli_close($db);
        }
        header('Location: http://www.diridarek.com/view/profil.php');
    }
    
    public function photoAction()
    {
        if(isset($_SESSION) && isset($_POST) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
	
            $sqlsession = "SELECT id FROM compte WHERE mail='".htmlentities(addslashes($_SESSION['mail']))."' AND mdp='".htmlentities(addslashes($_SESSION['mdp']))."' AND id='".intval($_SESSION['id'])."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){

                $sqq = "SELECT photo FROM compte WHERE id='".intval($_SESSION['id'])."'";
                $ree = @mysqli_query($db,$sqq);
                $lii = @mysqli_fetch_assoc($ree);

            $ph  = $lii['photo'];

            if($_FILES["upload"]["size"]<=10000000 and $_FILES["upload"]["size"]>0)
            {

                $infofich = @pathinfo($_FILES["upload"]["name"]);
                $ext      = $infofich['extension'];
                $file     = @uniqid().'.jpg';
                $ext      = @strtolower($ext);
                $extAut   = array('jpg','jpeg','gif','png');
                if(@in_array($ext,$extAut))
                {

                    $size = @getimagesize($_FILES["upload"]["tmp_name"]);
                    if( $size[1] == $size[0] ){
                            $destination = @imagecreatetruecolor(300, 300);
                    }else if( $size[1] > $size[0] ){ 
                            $rap = $size[0] / $size[1];
                            $L   = 300 * $rap;
                            $destination = @imagecreatetruecolor($L, 300);
                    }else if( $size[0] > $size[1] ){ 
                            $rap = $size[1] / $size[0];
                            $H   = 300 * $rap;
                            $destination = @imagecreatetruecolor(300, $H);
                    }


                    $source              = @imagecreatefromjpeg($_FILES["upload"]["tmp_name"]);
                    //$destination         = imagecreatetruecolor(120, 120);
                    $largeur_source      = @imagesx($source);
                    $hauteur_source      = @imagesy($source);
                    $largeur_destination = @imagesx($destination);
                    $hauteur_destination = @imagesy($destination);
                    $chemin				 = '../../img/profil/'.$file;

                    @imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
                    $resultat = @imagejpeg($destination, $chemin);

                    if($resultat){
                        $photo = $file; 
                    }
                    else{ $photo = $ph; }
                }
                else{ $photo = $ph; }      
            }
            else{ $photo = $ph; }

                $ip = $_SERVER['REMOTE_ADDR'];
                $sql = "INSERT INTO pictures (id_compte,photo,category,last,ip,deposit) VALUES ('".intval($_SESSION['id'])."','".@mysqli_real_escape_string($db, $photo)."','profil','".@mysqli_real_escape_string($db, $ph)."','".@mysqli_real_escape_string($db, $ip)."',now())";
                $req = @mysqli_query($db,$sql);
            }
            @mysqli_close($db);
        }
        header('Location: http://www.diridarek.com/view/profil.php');
    }
    
    public function rechercheAction()
    {
        if(isset($_SESSION) && isset($_POST) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
	
            $sqlsession = "SELECT id FROM compte WHERE mail='".htmlentities(addslashes($_SESSION['mail']))."' AND mdp='".htmlentities(addslashes($_SESSION['mdp']))."' AND id='".intval($_SESSION['id'])."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){
                $ip  = $_SERVER['REMOTE_ADDR'];
                $sql = "UPDATE compte SET recherche='".@mysqli_real_escape_string($db, utf8_decode($_POST['recherche']))."' WHERE id='".intval($_SESSION['id'])."'";
                $req = @mysqli_query($db,$sql);
                // écriture dans l'actu
                $sql = "INSERT INTO actu (id_compte,type,ip,depot,search_H) VALUES ('".intval($_SESSION['id'])."','3','".@mysqli_real_escape_string($db, $ip)."',now(),'".@mysqli_real_escape_string($db, utf8_decode($_POST['recherche']))."')";
                $req = @mysqli_query($db,$sql);
            }
            @mysqli_close($db);
        }
        header('Location: http://www.diridarek.com/view/profil.php');
    }
    
    public function signalerAction()
    {
        if(isset($_SESSION) && isset($_POST) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
            $sqlsession = "SELECT id FROM compte WHERE mail='".htmlentities(addslashes($_SESSION['mail']))."' AND mdp='".htmlentities(addslashes($_SESSION['mdp']))."' AND id='".intval($_SESSION['id'])."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){
                $ip  = $_SERVER['REMOTE_ADDR']; 
                $sql = "INSERT INTO report (id_compte_sent,id_compte_receive,type,report,ip,deposit) VALUES ('".intval($_SESSION['id'])."','".intval($_POST['receive'])."','".@mysqli_real_escape_string($db, utf8_decode($_POST['type']))."','".@mysqli_real_escape_string($db, utf8_decode($_POST['report']))."','".@mysqli_real_escape_string($db, $ip)."', now())";
                $req = mysqli_query($db,$sql);
            }
            @mysqli_close($db);
        }
    }
    
    public function statutAction()
    {
        if(isset($_SESSION) && isset($_POST) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
	
            $sqlsession = "SELECT id FROM compte WHERE mail='".htmlentities(addslashes($_SESSION['mail']))."' AND mdp='".htmlentities(addslashes($_SESSION['mdp']))."' AND id='".intval($_SESSION['id'])."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){
                    @mysqli_free_result($reqsession);
                    $sql = "UPDATE compte SET statut='".@mysqli_real_escape_string($db, utf8_decode($_POST['statut']))."' WHERE id='".intval($_SESSION['id'])."'";
                    $req = @mysqli_query($db,$sql);
                    @mysqli_free_result($req);
            }
            @mysqli_close($db);
        }
        header('Location: http://www.diridarek.com/view/profil.php');
    }
}
