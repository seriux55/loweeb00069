<?php

namespace Base\DiridarekBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class AccueilController extends Controller
{
    /*
     *  La fonction qui affiche la suite de la liste d'actualite
     */
    public function newsAction(Request $request, $pg=0)
    {
        if ($request->isXmlHttpRequest())
        {
            $actu = array();
            $pg   = $request->request->get('pg');
            $news = $this->getDoctrine()->getRepository('BaseDiridarekBundle:News')
                ->createQueryBuilder('a')
                ->addSelect('b')
                ->leftJoin('a.user', 'b')
                ->orderBy('a.id','DESC')
                ->getQuery()
                ->getResult();
            foreach ($news as $data)
            {
                $actu[] = array(
                    'id'            => $data->getId(),
                    'id_compte'     => $data->getUser()->getId(),
                    'type'          => $data->getType(),
                    'description'   => $data->getDescribH(),
                    'album'         => $data->getAlbumH(),
                    'depot'         => $data->getDateTime(),
                    'prenom'        => $data->getUser()->getSecondename(),
                    'sexe'          => $data->getUser()->getGender(),
                    'recherche'     => $data->getSearchH(),
                    'naissance'     => $data->getUser()->getBorn(),
                    'photo'         => "",
                    'photo2'        => "",
                    'photo3'        => "",
                    'photo4'        => "",
                    'statut'        => $data->getStatutH(),
                    'photo_album'   => $data->getPhotoH(),
                );
            }
            return $this->container->get('templating')->renderResponse('BaseDiridarekBundle:Accueil:news.html.twig', array(
                'news' => $actu,
            ));
        }
    }
    
    /*
     *  La fonction qui affiche la liste des contacts //new
     */
    public function contactsAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $contacts = array();
            $id       = $this->container->get('security.context')->getToken()->getUser()->getId();
            $contact  = $this->getDoctrine()->getRepository('BaseDiridarekBundle:Amis')
                ->createQueryBuilder('a')
                ->addSelect('b')
                ->leftJoin('a.user_sent', 'b')
                ->addSelect('c')
                ->leftJoin('a.user_receive', 'c')
                ->where('a.user_sent = :id OR a.user_receive = :id')
                ->andWhere('a.etat = 1')
                ->setParameter('id', $id)
                ->orderBy('a.id','DESC')
                ->getQuery()
                ->getResult();
            foreach($contact as $data){
                if($data->getUserSent()->getId() == $id){
                    $contacts[] = array(
                        'session' => $id,
                        'id'      => $data->getUserReceive()->getId(),
                        'prenom'  => $data->getUserReceive()->getSecondename(),
                        'nom'     => $data->getUserReceive()->getFirstname(),
                        'sexe'    => $data->getUserReceive()->getGender(),
                        'photo'   => "",
                        'last'    => $data->getUserReceive()->getLastConnexion(),
                    );
                }else{
                    $contacts[] = array(
                        'session' => $id,
                        'id'      => $data->getUserSent()->getId(),
                        'prenom'  => $data->getUserSent()->getSecondename(),
                        'nom'     => $data->getUserSent()->getFirstname(),
                        'sexe'    => $data->getUserSent()->getGender(),
                        'photo'   => "",
                        'last'    => $data->getUserSent()->getLastConnexion(),
                    );
                }
            }
            //array_multisort($contacts['last'], SORT_DESC, SORT_STRING);
            return $this->container->get('templating')->renderResponse('BaseDiridarekBundle:Accueil:contacts.html.twig', array(
                'contacts' => $contacts,
            ));
        }
    }
    
    public function demandeAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1 && isset($_POST['dest']) && !empty($_POST['dest']) && $_POST['dest']>=1){
	
                $sqlam = "SELECT id FROM amis WHERE id_compte_accepte='".intval($_SESSION['id'])."' AND id_compte_demande='".intval($_POST['dest'])."' AND etat='1'";
                $reqam = @mysqli_query($db,$sqlam);
                $nbram = @mysqli_num_rows($reqam);
                $message   = array();
                if($nbram=='1'){

                        $message[] = array('Vous êtes déjà amis');

                }else{

                                $sqlverif = "SELECT id FROM demande WHERE id_compte='".intval($_SESSION['id'])."' AND id_dest='".intval($_POST['dest'])."' AND (etat='1' OR etat='2') ORDER BY id DESC";
                                $reqverif = @mysqli_query($db, $sqlverif);
                                $numverif = @mysqli_num_rows($reqverif);
                                if($numverif == '0'){

                                        $ip  = $_SERVER['REMOTE_ADDR'];
                                        $now = date('Y-m-d H:i:s');
                                        $sql = "INSERT INTO demande (id_compte, id_dest, ip, depot) VALUES ('".intval($_SESSION['id'])."','".intval($_POST['dest'])."','".$ip."','$now')";
                                        $req = @mysqli_query($db, $sql);
                                        @mysqli_free_result($reqam);
                                @mysqli_free_result($reqverif);
                                @mysqli_free_result($req);
                                        
                                        if($req){
                                                $message[] = array('Demande envoyée');
                                        }
                                }else{
                                        $message[] = array('Demande déjà envoyée');
                                }
                }
                die($_GET['callback'].'('.json_encode($message).')');
                
        }
        /**
         * ajouter la verification si la demande n'est pas déjà envoyé 
         */
    }
    
    public function demandeOkAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
	
            $sql = "SELECT id FROM amis WHERE etat='1' AND vue='1' AND id_compte_demande = '".$_SESSION['id']."' ORDER BY etat DESC, vue DESC LIMIT 15";
            $req = @mysqli_query($db,$sql);
            $nbr = @mysqli_num_rows($req);
            if($nbr>0){
                $sqll = "UPDATE amis SET vue='0' WHERE etat='1' AND id_compte_demande = '".$_SESSION['id']."' ORDER BY etat DESC, vue DESC LIMIT 15";
                $reqq = @mysqli_query($db,$sqll);
                @mysqli_free_result($req);
                @mysqli_free_result($reqq);

            }
                
        }
    }
    
    public function enLigneAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $id = $this->container->get('security.context')->getToken()->getUser()->getId();
            $ip = $request->getClientIp();
            $now = date('Y-m-d H:i:s');
            $update = $this->get('doctrine')->getManager()
                ->createQueryBuilder('a')
                ->update('BaseUserBundle:User', 'a')
                ->set('a.lastConnexion', "'".date('Y-m-d H:i:s')."'")
                ->where("a.id = :id")
                ->setParameter(':id', $id)
                ->getQuery()
                ->execute();
            $response = new JsonResponse();
            return $response->setData(array('data' => 'yes'));
        }
    }
    
    public function feedbackAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1 && isset($_POST['feed']) && !empty($_POST['feed']) ){
	
                
            $sqlsession = "SELECT id FROM compte WHERE mail='".$_SESSION['mail']."' AND mdp='".$_SESSION['mdp']."' AND id='".$_SESSION['id']."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){

                $ip  = $_SERVER['REMOTE_ADDR'];
                $now = date('Y-m-d H:i:s');


        $mail = $_SESSION['prenom'].',

        Feed: '.$_POST['feed'].'

        Date: '.$now.'

        Mail: '.$_SESSION['mail'].'

        IP: '.$ip.'

        DIRIDAREK!';

                mail('couzina@diridarek.com', 'feedback', $mail);
                @mysqli_free_result($reqsession);
                echo 'ok';
            }
        }
    }
    
    public function getAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){

            $mes  = array();
            $sql1 = "SELECT id FROM demande WHERE id_dest  ='".$_SESSION['id']."' AND etat='2' ORDER BY etat DESC LIMIT 15";
            $sql3 = "SELECT id FROM visite  WHERE id_compte='".$_SESSION['id']."' AND vue='1' AND id_dest != '".$_SESSION['id']."' ORDER BY vue DESC LIMIT 15";

            $sql2 = "SELECT id FROM 
            ( SELECT M.id, id_compte, id_dest,M.lut FROM msg M JOIN ( SELECT MAX( id ) AS id, IF( id_compte =  '".$_SESSION['id']."', id_dest, id_compte ) 
            AS contact FROM msg WHERE id_compte =  '".$_SESSION['id']."' OR id_dest =  '".$_SESSION['id']."' GROUP BY contact ) L 
            ON M.id = L.id AND (M.id_compte = L.contact OR M.id_dest = L.contact) 
            WHERE (id_dest =  '".$_SESSION['id']."')AND (M.suppr_first !=  '".$_SESSION['id']."' AND M.suppr_seconde !=  '".$_SESSION['id']."') 
            AND M.lut =  '0' ORDER BY M.lut ASC, M.id DESC LIMIT 15) AS new_message";

            $sql4 = "SELECT id FROM amis WHERE etat='1' AND vue='1' AND id_compte_demande = '".$_SESSION['id']."' ORDER BY etat DESC, vue DESC ";

            $req1 = @mysqli_query($db, $sql1);
            $req2 = @mysqli_query($db, $sql2);
            $req3 = @mysqli_query($db, $sql3);
            $req4 = @mysqli_query($db, $sql4);


            $nbr1 = @mysqli_num_rows($req1); if($nbr1==0) $nbr1 = '';
            $nbr2 = @mysqli_num_rows($req2); if($nbr2==0) $nbr2 = '';
            $nbr3 = @mysqli_num_rows($req3); if($nbr3==0) $nbr3 = '';
            $nbr4 = @mysqli_num_rows($req4); if($nbr4==0) $nbr4 = '';

            @mysqli_free_result($req1);
            @mysqli_free_result($req2);
            @mysqli_free_result($req3);
            @mysqli_free_result($req4);

            if(isset($_SESSION['son']) && !empty($_SESSION['son']) && $_SESSION['son']>=0 && $nbr2 > $_SESSION['son']){
                    $son = '1';
            }else{ $son = '0'; }

            $_SESSION['son'] = $nbr2;

            $mes[] = array( 'son' => $son, 'nbr1' => $nbr1, 'nbr2' => $nbr2, 'nbr3' => $nbr3, 'nbr4' => $nbr4 );
            die($_GET['callback'].'('.json_encode($mes).')');
                
        }
    }
    
    public function getMAAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $id      = $this->get('security.context')->getToken()->getUser()->getId();
            $db      = $this->get('database_connection');
            $message = $db->prepare("SELECT id FROM 
            ( SELECT M.id, user_sent_id, user_receive_id, M.lut FROM diridarek__Message M JOIN ( SELECT MAX(id) AS id, IF( user_sent_id = :id, user_receive_id, user_sent_id ) 
            AS contact FROM diridarek__Message WHERE user_sent_id = :id OR user_receive_id = :id GROUP BY contact ) L 
            ON M.id = L.id AND (M.user_sent_id = L.contact OR M.user_receive_id = L.contact) 
            WHERE (user_receive_id = :id) AND (M.delFirst_id != :id AND M.delSeconde_id != :id) 
            AND M.lut = '0' ORDER BY M.lut ASC, M.id DESC LIMIT 10) AS new_message");
            $message->bindValue(':id', $id);
            $message->execute();
            $amis  = $db->prepare("SELECT id FROM diridarek__Amis WHERE etat='1' AND vue='1' AND user_sent_id = ':id' ORDER BY etat DESC, vue DESC ");
            $amis->bindValue(':id', $id);
            $amis->execute();
            $nbr1 = $nbr2 = 0;
            foreach($message as $data){
                $nbr1++;
            }
            foreach($amis as $data){
                $nbr2++;
            }
            $session = new Session();
            if((null != $session->get('son')) && ($session->get('son')>=0) && ($nbr1 > $session->get('son'))){
                $son = '1';
            }else{ $son = '0'; }
            $session->set('son', $nbr1);
            $mes = array( 'son' => $son, 'nbr1' => $nbr1, 'nbr2' => $nbr2 );
            $response = new JsonResponse();
            return $response->setData($mes);
        }
    }
    
    public function getVDAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {   
            $id      = $this->get('security.context')->getToken()->getUser()->getId();
            $db      = $this->get('database_connection');
            $demande = $db->prepare("SELECT id FROM diridarek__Demande WHERE user_receive_id =':id' AND etat='2' ORDER BY etat DESC LIMIT 10");
            $demande->bindValue(':id', $id);
            $demande->execute();
            $visite  = $db->prepare("SELECT id FROM diridarek__Visite WHERE user_sent_id=':id' AND vue='1' AND user_receive_id != ':id' ORDER BY vue DESC LIMIT 10");
            $visite->bindValue(':id', $id);
            $visite->execute();
            $nbr1 = $nbr2 = 0;
            foreach($visite as $data){
                $nbr1++;
            }
            foreach($demande as $data){
                $nbr2++;
            }
            $session = new Session();
            if((null != $session->get('son')) && ($session->get('son') >= 0) && ($nbr2 > $session->get('son')) ){
                $son = '1';
            }else{ $son = '0'; }
            $session->set('son', $nbr2);
            $mes      = array( 'son' => $son, 'nbr1' => $nbr1, 'nbr2' => $nbr2);
            $response = new JsonResponse();
            return $response->setData($mes);
        }
    }
    
    public function messagesAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $em      = $this->getDoctrine();
            $id      = $this->get('security.context')->getToken()->getUser()->getId();
            $message = $em->getRepository('BaseDiridarekBundle:Message')
                ->createQueryBuilder('a')
                ->addSelect('b')
                ->leftJoin('a.user_sent', 'b')
                ->addSelect('c')
                ->leftJoin('a.user_receive', 'c')
                ->where('a.user_sent = :id OR a.user_receive = :id')
                ->andWhere('(a.delFirst != :id OR a.delFirst IS NULL) AND (a.delSeconde != :id OR a.delSeconde IS NULL)')
                ->setParameter('id', $id)
                ->orderBy('a.lut', 'ASC')
                ->addOrderBy('a.dateTime', 'DESC')
                ->getQuery()
                ->getResult();
            /*
            $sqlmsg = "SELECT id, message, L.depot, id_compte, id_dest, lut FROM msg M
                       JOIN (SELECT MAX(depot) AS depot, IF (id_compte='".$_SESSION['id']."', id_dest, id_compte) AS contact FROM msg 
                       WHERE id_compte = '".$_SESSION['id']."' OR id_dest = '".$_SESSION['id']."' GROUP BY contact) L
                       ON M.depot = L.depot AND (M.id_compte = L.contact OR M.id_dest = L.contact)
                       WHERE (id_compte = '".$_SESSION['id']."' OR id_dest = '".$_SESSION['id']."') AND (M.suppr_first != '".$_SESSION['id']."' AND M.suppr_seconde != '".$_SESSION['id']."') ORDER BY lut ASC,depot DESC";
            */
            $messages = $m = array();
            foreach($message as $data){
                if( !in_array($data->getUserSent()->getId(), $m) && !in_array($data->getUserSent()->getId(), $m) ){
                    //$m[] = $data->getId();
                    if($id != $data->getUserSent()->getId()){
                        $messages[] = array(
                            'session' => $id,
                            'id'      => $data->getUserSent()->getId(),
                            'lut'     => $data->getLut(),
                            'prenom'  => $data->getUserSent()->getSecondename(),
                            'nom'     => $data->getUserSent()->getFirstname(),
                            'sexe'    => $data->getUserSent()->getGender(),
                            'photo'   => "",
                            'last'    => $data->getUserSent()->getLastConnexion(),
                        );
                        $m[] = $data->getUserSent()->getId();
                    }else{
                        $messages[] = array(
                            'session' => $id,
                            'id'      => $data->getUserReceive()->getId(),
                            'lut'     => $data->getLut(),
                            'prenom'  => $data->getUserReceive()->getSecondename(),
                            'nom'     => $data->getUserReceive()->getFirstname(),
                            'sexe'    => $data->getUserReceive()->getGender(),
                            'photo'   => "",
                            'last'    => $data->getUserReceive()->getLastConnexion(),
                        );
                        $m[] = $data->getUserReceive()->getId();
                    }
                }
            }
            $update = $this->get('doctrine')->getManager()
                ->createQueryBuilder('a')
                ->update('BaseDiridarekBundle:Message', 'a')
                ->set('a.lut', "'1'")
                ->where("a.user_receive = :id AND a.lut = '0'")
                ->setParameter('id', $id)
                ->getQuery()
                ->execute();
            
            return $this->container->get('templating')->renderResponse('BaseDiridarekBundle:Accueil:messages.html.twig', array(
                'messages' => $messages,
            ));
        }
    }
    
    public function msgAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1 && isset($_GET['id']) && !empty($_GET['id']) && $_GET['id']>=1){
            $pseudo   = $_GET['first'];
            $id  	  = $_GET['id'];
            $msg      = 'msg'.$id;
            $idm      = 'idm'.$id; // id du dernier message
            $messages = array();

            if(isset($_SESSION[$msg]) && isset($_SESSION[$idm])){ // si il existe une session

                $messages = $_SESSION[$msg];
                $sql = "SELECT msg.id,msg.id_compte,msg.id_dest,msg.lut,msg.depot,msg.message, 
                                compte.prenom,compte.sexe,compte.last_connexion,compte.photo 
                            FROM msg JOIN compte ON msg.id_compte=compte.id WHERE  
                            (id_compte='".$_GET['id']."' AND id_dest='".$_SESSION['id']."' AND msg.id>'".$_SESSION[$idm]."') 
                            OR (id_compte='".$_SESSION['id']."' AND id_dest='".$_GET['id']."' AND msg.id>'".$_SESSION[$idm]."')
                            ORDER BY depot DESC";
                $req = @mysqli_query($db, $sql) or die ('allo'.mysqli_error($db));
                $num = @mysqli_num_rows($req);


                if($num > 0){ // si il y a de nouveau messages

                    $msgi = array();
                    $msgi = array_reverse($_SESSION[$msg]);
                    $lid  = $_SEESION[$idm];
                    while($lig = @mysqli_fetch_assoc($req)){

                        if($lig['id']>$lid) $lid = $lig['id'];

                            $msgi[] = array(
                                'scroll'  => $lid,
                                'de'      => $lig['id_compte'],
                                'a'       => $lig['id_dest'],
                                'msg'     => utf8_encode(htmlentities(stripslashes($lig['message']))),
                                'lut'     => $lig['lut'],
                                'depot'   => $lig['depot'],
                                'prenom'  => utf8_encode($lig['prenom']),
                                'sexe'    => $lig['sexe'],
                                'last'    => $lig['last_connexion'],
                                'photo'   => $lig['photo'],
                                'pseudo'  => $pseudo
                            );
                        }
                        $messages = array_reverse($msgi);
                        $_SESSION[$msg] = $messages;
                        $_SESSION[$idm] = $lid;
                        @mysqli_free_result($req);


                    }

                }else{ // si il n'y a pas de session

                    if(isset($_SESSION[$idm])) unset($_SESSION[$idm]); 
                    if(isset($_SESSION[$msg])) unset($_SESSION[$msg]); 
                    $lid = '0';

                    $sqll  = "SELECT msg.id,msg.id_compte,msg.id_dest,msg.lut,msg.depot,msg.message, 
                                compte.prenom,compte.sexe,compte.last_connexion,compte.photo 
                                FROM msg JOIN compte ON msg.id_compte=compte.id WHERE (id_compte='".$_GET['id']."' 
                                AND id_dest='".$_SESSION['id']."') OR (id_compte='".$_SESSION['id']."' AND id_dest='".$_GET['id']."') 
                                ORDER BY depot DESC LIMIT 7";
                    $reqq  = @mysqli_query($db, $sqll);
                    $numm  = @mysqli_num_rows($reqq);

                    while($ligg = @mysqli_fetch_assoc($reqq)){

                        if($ligg['id']>$lid) $lid = $ligg['id'];

                            $messages[] = array(
                                'ses'	  => '0',
                                'de'      => $ligg['id_compte'],
                                'a'       => $ligg['id_dest'],
                                'msg'     => utf8_encode(htmlentities(stripslashes($ligg['message']))),
                                'lut'     => $ligg['lut'],
                                'depot'   => $ligg['depot'],
                                'prenom'  => utf8_encode($ligg['prenom']),
                                'sexe'    => $ligg['sexe'],
                                'last'    => $ligg['last_connexion'],
                                'photo'   => $ligg['photo'],
                                'pseudo'  => $pseudo
                            );
                        }

                        $_SESSION[$msg] = $messages;
                        $_SESSION[$idm] = $lid;
                        $message = $messages;
                        @mysqli_free_result($reqq);
                    }

                    $message = array_reverse($messages);

                    die($_GET['callback'].'('.json_encode($message).')');
            
        }
    }
    
    public function nonAmiAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1 && isset($_GET['ami']) && !empty($_GET['ami']) && $_GET['ami']>=1){
	
            $sql = "UPDATE demande SET etat='0' WHERE id_compte='".intval($_GET['ami'])."' AND id_dest='".intval($_SESSION['id'])."' ORDER BY etat ASC";
            $req = @mysqli_query($db,$sql);
            @mysqli_free_result($req);

            if($req){
                $message   = array();
                            $message[] = array('La demande a été refusé');
                            die($_GET['callback'].'('.json_encode($message).')');
            }
        }
    }
    
    public function ouiAmiAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1 && isset($_GET['ami']) && !empty($_GET['ami']) && $_GET['ami']>=1){
	
            $sqlam   = "SELECT id FROM amis WHERE id_compte_accepte='".intval($_SESSION['id'])."' AND id_compte_demande='".intval($_GET['ami'])."' AND etat='1' LIMIT 1";
            $reqam   = @mysqli_query($db,$sqlam);
            $nbram   = @mysqli_num_rows($reqam);
            $message = array();
            if($nbram=='1'){

                $sql = "UPDATE demande SET etat='3' WHERE id_compte='".intval($_GET['ami'])."' AND id_dest='".intval($_SESSION['id'])."'";
                $req = @mysqli_query($db,$sql);

                $message[] = array(
                    'session' => '-1',
                    'msg'     => 'Vous êtes déjà amis'
                );
                @mysqli_free_result($reqam);
                @mysqli_free_result($req);
            }else{
                $sql = "UPDATE demande SET etat='3' WHERE id_compte='".intval($_GET['ami'])."' AND id_dest='".intval($_SESSION['id'])."' LIMIT 1";
                $req = @mysqli_query($db,$sql);
                if($req){
                    $ipp  = $_SERVER['REMOTE_ADDR'];
                    $now = date('Y-m-d H:i:s');
                    $sqll = "INSERT INTO amis (id_compte_accepte,id_compte_demande,ip,depot) VALUES ('".intval($_SESSION['id'])."', '".intval($_GET['ami'])."', '".htmlentities(addslashes($ipp))."', '$now')";
                    $reqq = @mysqli_query($db,$sqll);
                    if($reqq){
                        $sqlami = "SELECT prenom,nom,sexe,last_connexion,photo FROM compte WHERE id='".intval($_GET['ami'])."' LIMIT 1";
                        $reqami = @mysqli_query($db,$sqlami);

                        $lii    = @mysqli_fetch_assoc($reqami);

                        $message[] = array(
                            'session' => $_SESSION['id'],
                            'id'      => $_GET['ami'],
                            'msg'     => 'Vous êtes maintenant amis',
                            'prenom'  => utf8_encode($lii['prenom']),
                            'nom'     => utf8_encode($lii['nom']),
                            'sexe'    => $lii['sexe'],
                            'photo'   => $lii['photo'],
                            'last'    => $lii['last_connexion']
                        );
                        @mysqli_free_result($reqami);
                    }
                    @mysqli_free_result($reqq);
                                        }
                }
                die($_GET['callback'].'('.json_encode($message).')');
        }
    }
    
    public function paginationAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1 && isset($_POST['p']) && $_POST['p']>=0){
            $message = array();
            $sql = "SELECT id,prenom,photo,sexe,last_connexion,naissance,ville,statut FROM compte WHERE id != '".$_SESSION['id']."' AND mode!='3' ORDER BY last_connexion DESC LIMIT ".$_POST['p'].",15";
            $req = @mysqli_query($db, $sql);
            while($lig = @mysqli_fetch_assoc($req)){
                $sqlam = "SELECT id FROM amis WHERE ( (id_compte_accepte='".$_SESSION['id']."' AND id_compte_demande='".$lig['id']."') OR (id_compte_accepte='".$lig['id']."' AND id_compte_demande='".$_SESSION['id']."') ) AND etat='1' ORDER BY depot DESC LIMIT 1";
                $reqam = @mysqli_query($db,$sqlam);
                $nbram = @mysqli_num_rows($reqam);
                if($nbram==0){
                    $sqld = "SELECT id FROM demande WHERE (id_compte='".intval($_SESSION['id'])."' AND id_dest='".intval($lig['id'])."') OR (id_compte='".intval($lig['id'])."' AND id_dest='".intval($_SESSION['id'])."') LIMIT 1";
                    $reqd = @mysqli_query($db, $sqld);
                    $nbrd = @mysqli_num_rows($reqd);
                    if($nbrd=='1'){ $demande = 1; }else{ $demande = 0; }
                }
                $message[] = array(
                    'ami'    			=> $nbram,
                    'id'    			=> $lig['id'],
                    'prenom'			=> $lig['prenom'],
                    'sexe'				=> $lig['sexe'],
                    'photo'				=> $lig['photo'],
                    'last'				=> $lig['last_connexion'],
                    'naissance'			=> $lig['naissance'],
                    'statut'			=> $lig['statut'],
                    'demande'			=> $demande,
                    'ville'				=> $lig['ville']
                );
            }
            @mysqli_free_result($req);
            @mysqli_free_result($reqam);
            die($_GET['callback'].'('.json_encode($message).')');
        }
    }
    
    public function posterAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
            if(isset($_POST['dest']) && $_POST['dest'] >= 1){
                $ip  = $_SERVER['REMOTE_ADDR'];
                $now = date('Y-m-d H:i:s');
                $req = @mysqli_query($db, "INSERT INTO msg (id_compte, id_dest, message, ip, depot) VALUES ('".@mysqli_real_escape_string($db, $_SESSION['id'])."', 					  '".mysqli_real_escape_string($db, $_POST['dest'])."', '".@mysqli_real_escape_string($db, utf8_decode($_POST['msg']))."', '$ip', '$now')");
                if($req){
                    $sqlhottif = "UPDATE msg SET lut='1' WHERE id=(SELECT max(id) AS last FROM msg WHERE id_dest='".$_SESSION['id']."' AND lut='0')";
                    $reqhottif = @mysqli_query($db,$sqlhottif);

                    $messages  = array();
                    @mysqli_free_result($req);
                    @mysqli_free_result($reqhottif);

                    die($_GET['callback'].'('.json_encode($messages).')');
                }
            }
        }
        //union departemental de paris   des avocat 0142038825
    }
    
    public function profilAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1 && isset($_POST['dest']) && !empty($_POST['dest']) && $_POST['dest']>=1){
	
            $profil = array();
            $sql    = "SELECT prenom,nom,naissance,sexe,ville,last_connexion,statut,photo,couverture FROM compte WHERE id='".$_POST['dest']."' LIMIT 1";
            $req    = @mysqli_query($db, $sql);
            $num    = @mysqli_num_rows($req);
            $lig    = @mysqli_fetch_assoc($req);

            $sqlam = "SELECT id FROM amis WHERE id_compte_accepte='".$_SESSION['id']."' AND id_compte_demande='".$_POST['dest']."' AND etat='1' LIMIT 1";
            $reqam = @mysqli_query($db,$sqlam);
            $nbram = @mysqli_num_rows($reqam);
            if($nbram=='1'){ $ami = "1"; }else{ $ami = "0"; }
            $profil = array(
                'session'    => $_SESSION['id'],
                'ami'        => $ami,
                'prenom'     => utf8_encode($lig['prenom']),
                'nom'        => utf8_encode($lig['nom']),
                'naissance'  => $lig['naissance'],
                'last'		 => $lig['last_connexion'],
                'ville'		 => utf8_encode($lig['ville']),
                'sexe'		 => $lig['sexe'],
                'statut'	 => $lig['statut'],
                'photo'		 => $lig['photo'],
                'couverture' => $lig['couverture'],
                'pers'       => $_SESSION['sexe']
            );
            $sqlprof = "SELECT id FROM visite WHERE id_compte='".$_POST['dest']."' AND id_dest='".$_SESSION['id']."' AND vue='1'";
            $reqprof = @mysqli_query($db,$sqlprof);
            $numprof = @mysqli_num_rows($reqprof);
            $now = date('Y-m-d H:i:s');
            if($numprof==0){
                $sqlprofi = "INSERT INTO visite (id_compte,id_dest,ip,depot) VALUES ('".$_POST['dest']."','".$_SESSION['id']."','".$_SERVER['REMOTE_ADDR']."','$now')";
                $reqprofi = @mysqli_query($db,$sqlprofi);
            }
            @mysqli_free_result($reqprofi);
            @mysqli_free_result($reqprof);
            @mysqli_free_result($reqam);
            @mysqli_free_result($req);
            @mysqli_free_result($reqsession);
                
            die($_GET['callback'].'('.json_encode($profil).')');
        }
    }
    
    public function refreshAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){

                $message = array();
                $sql = "SELECT id,prenom,photo,sexe,last_connexion,naissance,ville,statut FROM compte WHERE id != '".$_SESSION['id']."' AND mode!='3' ORDER BY last_connexion DESC LIMIT 0,15";
                $req = mysqli_query($db, $sql);
                while($lig = mysqli_fetch_assoc($req)){
                    $sqlam = "SELECT id FROM amis WHERE ( (id_compte_accepte='".$_SESSION['id']."' AND id_compte_demande='".$lig['id']."') OR (id_compte_accepte='".$lig['id']."' AND id_compte_demande='".$_SESSION['id']."') ) AND etat='1' ORDER BY depot DESC LIMIT 1";
                    $reqam = mysqli_query($db,$sqlam);
                    $nbram = mysqli_num_rows($reqam);
                    if($nbram==0){
                        $sqld = "SELECT id FROM demande WHERE (id_compte='".intval($_SESSION['id'])."' AND id_dest='".intval($lig['id'])."') OR (id_compte='".intval($lig['id'])."' AND id_dest='".intval($_SESSION['id'])."') LIMIT 1";
                        $reqd = @mysqli_query($db, $sqld);
                        $nbrd = @mysqli_num_rows($reqd);
                        if($nbrd=='1'){ $demande = 1; }else{ $demande = 0; }
                        mysqli_free_result($reqd);
                    }
                    $message[] = array(
                        'ami'    			=> $nbram,
                        //'nom'				=> $lig['nom'],
                        'id'    			=> $lig['id'],
                        'prenom'			=> $lig['prenom'],
                        'sexe'				=> $lig['sexe'],
                        'photo'				=> $lig['photo'],
                        'last'				=> $lig['last_connexion'],
                        'naissance'			=> $lig['naissance'],
                        'statut'			=> $lig['statut'],
                        'demande'			=> $demande,
                        'ville'				=> $lig['ville']
                    );
                }
                @mysqli_free_result($req);
                @mysqli_free_result($reqam);
                @mysqli_close($db);
                die($_GET['callback'].'('.json_encode($message).')');
        }
    }
    
    public function statutAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1 && isset($_POST['feed']) && !empty($_POST['feed']) ){
	
            
            $sqlsession = "SELECT photo,prenom,sexe FROM compte WHERE mail='".$_SESSION['mail']."' AND mdp='".$_SESSION['mdp']."' AND id='".$_SESSION['id']."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){

                $ip  = $_SERVER['REMOTE_ADDR'];
                $now = date('Y-m-d H:i:s');
                $ligsession = @mysqli_fetch_assoc($reqsession);

                $sql  = "INSERT INTO actu (id_compte,type,ip,depot,statut_H) VALUES ('".$_SESSION['id']."',6,'$ip','$now','".@mysqli_real_escape_string($db, utf8_decode($_POST['feed']))."')";
                $req  = @mysqli_query($db, $sql);
                $sqll = "UPDATE compte SET statut='".@mysqli_real_escape_string($db, utf8_decode($_POST['feed']))."' WHERE id='".$_SESSION['id']."'";
                $reqq = @mysqli_query($db, $sqll);

                $statut = array();

                $statut[] = array(
                    'photo'  	=> $ligsession['photo'],
                    'prenom' 	=> $ligsession['prenom'],
                    'sexe'   	=> $ligsession['sexe'],
                    'id_compte'	=> $_SESSION['id'],
                    'statut'	=> utf8_decode($_POST['feed'])
                );
                @mysqli_free_result($reqsession);
                @mysqli_free_result($req);
                @mysqli_free_result($reqq);
                
                die($_GET['callback'].'('.json_encode($statut).')');
            }
        }
    }
    
    public function delRemarqueAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){

            
            $sql = "UPDATE compte SET remarque='0' WHERE id='".$_SESSION['id']."'";
            $req = mysqli_query($db, $sql);
            if($req){
                    echo "ok";
            }else echo "not ok";
            mysqli_free_result($req);
            mysqli_close($db);
        }
    }
    
    public function delCAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
            
            $now = date('Y-m-d H:i:s');
            $sqlsuppr = "UPDATE amis SET etat='0',fin='$now' WHERE (id_compte_demande='".$_SESSION['id']."' AND id_compte_accepte='".$_POST['suppr']."') OR (id_compte_demande='".$_POST['suppr']."' AND id_compte_accepte='".$_SESSION['id']."')";
            $reqsuppr = @mysqli_query($db, $sqlsuppr);
            @mysqli_free_result($reqsuppr);
        }
    }
    
    public function delMAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
            
            $sqlsuppr = "SELECT id FROM msg WHERE (id_compte='".$_SESSION['id']."' AND id_dest='".$_POST['suppr']."') OR (id_compte='".$_POST['suppr']."' AND id_dest='".$_SESSION['id']."') AND suppr_first='".$_SESSION['id']."'";
            $reqsuppr = @mysqli_query($db, $sqlsuppr);
            $nbrsuppr = @mysqli_num_rows($reqsuppr);

            if($nbrsuppr==0){

                $sqlsupprr = "SELECT id FROM msg WHERE (id_compte='".$_SESSION['id']."' AND id_dest='".$_POST['suppr']."') OR (id_compte='".$_POST['suppr']."' AND id_dest='".$_SESSION['id']."') AND suppr_seconde='".$_SESSION['id']."'";
                $reqsupprr = @mysqli_query($db, $sqlsupprr);
                $nbrsupprr = @mysqli_num_rows($reqsupprr);
                if($nbrsupprr==0){
                    $sqlsupprA = "UPDATE msg SET suppr_first='".$_SESSION['id']."' WHERE (id_compte='".$_SESSION['id']."' AND id_dest='".$_POST['suppr']."') OR (id_compte='".$_POST['suppr']."' AND id_dest='".$_SESSION['id']."')";
                    $reqsupprA = @mysqli_query($db, $sqlsupprA);
                    @mysqli_free_result($reqsupprA);
                }else{
                    $sqlsupprB = "UPDATE msg SET suppr_seconde='".$_SESSION['id']."' WHERE (id_compte='".$_SESSION['id']."' AND id_dest='".$_POST['suppr']."') OR (id_compte='".$_POST['suppr']."' AND id_dest='".$_SESSION['id']."')";
                    $reqsupprB = @mysqli_query($db, $sqlsupprB);
                    @mysqli_free_result($reqsupprB);
                }
                @mysqli_free_result($reqsupprr);
            }else{
                $sqlsupprC = "UPDATE msg SET suppr_first='".$_SESSION['id']."' WHERE (id_compte='".$_SESSION['id']."' AND id_dest='".$_POST['suppr']."') OR (id_compte='".$_POST['suppr']."' AND id_dest='".$_SESSION['id']."')";
                $reqsupprC = @mysqli_query($db, $sqlsupprC);
                @mysqli_free_result($reqsupprC);
            }
            @mysqli_free_result($reqsuppr);
        }
    }
    
    public function visiteAction()
    {
        if(isset($_SESSION) && isset($_SESSION['mail']) && isset($_SESSION['mdp']) && !empty($_SESSION['mail']) && !empty($_SESSION['mdp']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['id']>=1){
	
            
            $sqlsession = "SELECT sexe FROM compte WHERE mail='".$_SESSION['mail']."' AND mdp='".$_SESSION['mdp']."' AND id='".$_SESSION['id']."' LIMIT 1";
            $reqsession = @mysqli_query($db,$sqlsession);
            $nbrsession = @mysqli_num_rows($reqsession);
            if($nbrsession == 1){

                $visites    = array();
                $ligsession = @mysqli_fetch_assoc($reqsession);
                $sql        = "SELECT id_dest FROM visite WHERE id_compte='".$_SESSION['id']."' AND vue='1' AND id_dest != '".$_SESSION['id']."' ";
                $req        = @mysqli_query($db, $sql);
                while($lig  = @mysqli_fetch_assoc($req)){

                    $sqldemande = "SELECT id,sexe,nom,prenom,last_connexion,naissance,ville,statut,photo FROM compte WHERE id='".$lig['id_dest']."' LIMIT 1";
                    $reqdemande = @mysqli_query($db, $sqldemande);
                    $ligdemande = @mysqli_fetch_assoc($reqdemande);
                    $sqlami     = "SELECT id FROM amis WHERE ( (id_compte_demande='".$_SESSION['id']."' AND id_compte_accepte='".$lig['id_dest']."') OR (id_compte_demande='".$lig['id_dest']."' AND id_compte_accepte='".$_SESSION['id']."') ) AND etat='1' ORDER BY depot DESC LIMIT 1";
                    $reqami 	= @mysqli_query($db, $sqlami);
                    $nbrami 	= @mysqli_num_rows($reqami);
                    if($ligsession['sexe'] == 'Mr'){
                            if($nbrami==1) $ami='1'; else $ami='0';
                    }else $ami='1';

                    $visites[] = array(
                        'id'        => $ligdemande['id'],
                        'naissance' => $ligdemande['naissance'],
                        'prenom'    => utf8_encode($ligdemande['prenom']),
                        'nom'       => utf8_encode($ligdemande['nom']),
                        'sexe'      => $ligdemande['sexe'],
                        'statut'    => utf8_encode($ligdemande['statut']),
                        'photo'     => $ligdemande['photo'],
                        'ami'       => $ami,
                        'last'      => $ligdemande['last_connexion']
                    ); 

                }
                $sqlu = "UPDATE visite SET vue='0' WHERE id_compte='".$_SESSION['id']."' AND vue='1' LIMIT 20";
                $requ = @mysqli_query($db, $sqlu);
                @mysqli_free_result($reqdemande);
                @mysqli_free_result($reqami);
                @mysqli_free_result($req);
                @mysqli_free_result($requ);
                @mysqli_free_result($reqsession);

                die($_GET['callback'].'('.json_encode($visites).')');
            }
        }
    }
}
