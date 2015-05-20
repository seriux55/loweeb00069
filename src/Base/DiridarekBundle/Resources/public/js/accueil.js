/*
 * le main
 */ 
var msgajax, id, iddd, idc;
var tab, ligne = new Array(), idPage=10;

/*
 * function qui affiche les emoticons
 */
function replaceEmoticons(text) {
    var emoticons = {
        ':)'    : 'smiling36.png',
        ':-)'   : 'smiling36.png',
        ';)'    : 'wink9.png',
        ';-)'   : 'wink9.png',
        ':p'    : 'emoticon94.png',
        ':-p'   : 'emoticon94.png',
        ':D'    : 'smiling40.png',
        ':-D'   : 'smiling40.png',
        ':o'    : 'surprised19.png',
        ':-o'   : 'surprised19.png',
        ':('    : 'sad39.png',
        ':-('   : 'sad39.png',
        '^^'    : 'smiley40.png',
        '^_^'   : 'smiley40.png',
        ':B'    : 'emoticons11.png',
        ':\'('  : 'teardrop4.png',
        ':-\'(' : 'teardrop4.png',
        ':*'    : 'kiss1.png',
        '<3'    : 'love1.png',
        ':-@'   : 'bad5.png',
        ':@'    : 'bad5.png',
        '(y)'   : 'thumbup.png'
    }, url = "http://www.diridarek.com/images/emoticons/";
    // a simple regex to match the characters used in the emoticons
    return text.replace(/[-:;\')@D(*pB^yo]+/g, function (match) {
        return typeof emoticons[match] !== 'undefined' ?
        '<img src="'+url+emoticons[match]+'" height="20" width="20" alt="" />' : match;
  });
}

/*
 *  La fonction qui affiche la liste des messages //new
 */
function newrefreshlistmsg(){
    $("#loadmessages").show();
    jQuery.ajax({
        type: 	  'POST',
        url:  	  Routing.generate('ajax_diridarek_messages'),
        cache:    false,
        success:  function(data) {
            $("#lesmessages").empty().html(data);
            $("#loadmessages").hide();
        }
    });
}

/*
 *  La fonction qui affiche la liste des contacts //new
 */
function newrefreshcontact(){
	
    $('#contactfriend').show();
    jQuery.ajax({
        type: 	  'POST',
        url:  	  Routing.generate('ajax_diridarek_contacts'),
        cache:    false,
        success:  function(data) {
            $("#lescontactss").empty().html(data);
            $('#contactfriend').hide();
            
            $( "body" ).on( "click", "#contproff", function(){
                $("#profil").show();
            	$("#allmessage").hide();
            	$("#enligne").hide();
            	$("#message").hide();
            	$("#demande").hide();
            	$("#visite").hide();
            });
        }
    });
};

/*
 *  La fonction qui refrech et affiche les messages d'un seul utilisateur
 *  @param int idd L'id du message
 */
function refreshmsg(idd,first,one){
	
    if(one === 'a') $('#loadmsg').show();
    var photoo,messaGe,photooo;

    eraseCookie(iddd);
    createCookie(iddd,idd,5);
    jQuery.ajax({
        type: 	  'GET',
        url:  	  '../controllers/accueil/msg.php?callback=?',
        data: 	  { id: idd, first: first }, 
        cache:    false,
        async: 	  true,
        dataType: 'jsonp',
        success:  function(json) {
            if(json !== 'null'){
                var pseud;
                var msgajx = '<ul>';
                for( var x in json ) {
                    var ligne = json[x];
                    if(ligne.photo !== ""){ photoo = "<div class='ameima'><img src='../img/profil/"+ ligne.photo +"' alt='' /></div>"; }else{
                        if(ligne.sexe === 'Mr') photoo = '<div class="ameima"><img src="../images/man.jpg" alt="" /></div>'; 
                        else if(ligne.sexe === 'Mlle') photoo = '<div class="ameima"><img src="../images/woman.png" alt="" /></div>';
                    }
                    if(ligne.last !== null) msgajx += '<li><div class="amessage">' + photoo + '<div class="amgcont"><div class="amesshead"><h3>'+ stripslashes(htmlspecialchars(utf8_encode(ligne.prenom), "ENT_QUOTES")) +'</h3><h6>'+ ligne.depot +'</h6></div><p class="inpros">'+ ligne.msg +'</p></div></div></li>';
                    if(ligne.pseudo === '0') pseud = 'Votre message'; else if(ligne.pseudo !== '') pseud  = '<a href="profil.php?dar='+ idd +'">' + stripslashes(htmlspecialchars(utf8_encode(ligne.pseudo), "ENT_QUOTES")) + '</a>';
                }
                msgajx += '<li><div id="tmer"></div></li>';
                msgajx += '</lu>';

                msgajx = replaceEmoticons(msgajx);
                $("#msgajax").html(msgajx);

                $("#pseud").empty().html(pseud);
                var idBut = "sendMessage" + idd;
                var butum = '<input class="formes" id="sendMessage" type="button" value="Envoyer" name="valider">';
                var pho, tmer = '';
                $("#butum").empty().html(butum);
			
                $('#sendMessage').on('click', function(){
                    $("#butum").hide();
                    $("#messagesend").show();
                    messaGe = $('#boxMessage').val();
                    if(messaGe !== ''){
                        jQuery.ajax({
                            type:     'POST',
                            url:      '../controllers/accueil/poster.php?callback=?',
                            data:     { dest: idd, msg: messaGe }, 
                            cache:    false,
                            async:    true,
                            dataType: 'jsonp',
                            success:  function(json) {
                                if(photo !== ""){ photooo = '<div class="ameima"><img src="../img/profil/'+ photo +'" alt="" /></div>'; }else{
                                    if(sexe === 'Mr') photooo = '<div class="ameima"><img src="../images/man.jpg" alt="" /></div>'; 
                                    else if(sexe === 'Mlle') photooo = '<div class="ameima"><img src="../images/woman.png" alt="" /></div>';
                                }
                                tmer = '<div class="amessage">' + photooo + '<div class="amgcont"><div class="amesshead"><h3>' + prenom + '</h3><h6> à l\'instant</h6></div><p class="inpros">'+ messaGe +'</p></div></div>';

                                $("#messagesend").hide();
                                $("#butum").show();

                                $('#boxMessage').val('');
                                tmer = replaceEmoticons(tmer);
                                $("#tmer").empty().html(tmer);
                                $( '#msgajax' ).scrollTop( $( '#msgajax' ).prop( 'scrollHeight' ) ) ;
                            }
                        });
                    }
                    return false;
                });	
            }																			 
        }
    });
    if(one === 'a') $( '#msgajax' ).scrollTop( $( '#msgajax' ).prop( 'scrollHeight' ) ) ;
    if(one === 'b') $('#loadmsg').hide();		
    $("#demandeG").on("click", function(){ suppr(timer); });
    $("#visiteG") .on("click", function(){ suppr(timer); });
    $('#loadmsg').hide();
    timer = setTimeout(function(){ refreshmsg(readCookie(iddd),first,'b'); }, 2750);
}

/*
 *  La fonction qui supprime le setTimeOut
 *  @param var time Le nom de la variable setTimeOut
 */
function suppr(time){
    clearTimeout(time);
}

/*
 *  La fonction qui refresh les nombres des notifications messages et demandes
 */
$.PeriodicalUpdater(Routing.generate('ajax_diridarek_getMA'), 
    {
        method:     'POST',
        minTimeout: 39000,
        maxTimeout: 43000,
        multiplier: 2,			
        cache:      false,
        autoStop:   0
    }, function(json, success, xhr, handle) {
        var nbr1, nbr2, son;
        for( var x in json ) {
            var ligne = json[x];
            nbr1 = ligne.nbr1;
            nbr2 = ligne.nbr2;
            son  = ligne.son;
        }
        if(son  === 1) { $('#sonson')[0].play();     }
        if(nbr1 >= 1)  { $('#messages') .show(nbr1); } else{ $('#messages').hide(); }
        if(nbr2 >= 1)  { $('#contac')   .show(nbr2); } else{ $('#contac')  .hide(); }
    }
);

/*
 *  La fonction qui refresh les nombres des notifications visites et demandes acceptées
 */
$.PeriodicalUpdater(Routing.generate('ajax_diridarek_getVD'), 
    {
        method:     'POST',
        minTimeout: 59800,
        maxTimeout: 64000,
        multiplier: 2,
        cache:      false,
        autoStop:   0
    }, function(json, success, xhr, handle) {
        var nbr1,nbr2,son;
        for( var x in json ) {
            var ligne = json[x];
            nbr1 = ligne.nbr1;
            nbr2 = ligne.nbr2;
            son  = ligne.son;
        }
        if(son === 1){ $('#sonson')[0].play();    }
        if(nbr1 >= 1){ $('#demandes').show(nbr1); }else{ $('#demandes').hide(); }
        if(nbr2 >= 1){ $('#visites') .show(nbr2); }else{ $('#visites') .hide(); }
    }
);

/*
 *  La fonction qui supprime au moment du clique sur le menu contacts
 */
$('#con').on('click',function(){
    suppr(timer);
});	

/*
 *  La fonction qui s'execute au moment du clique sur message pour avoir la liste des messages
 */
$("#miss").on('click',function(){
    newrefreshlistmsg();
});

/* 
 *  La fonction qui affiche les messages d'un contact au clique sur un contact de la liste des messages
 */
$( "body" ).on( "click", ".aa", function(){	
    if(timer !==''){ suppr(timer); timer=''; }
    var idd = this.id;
    var first   = this.name;
    $("#allmessage") .css('display','block');
    $("#contgu")     .css('display','block');
    $("#message")    .css('display','block');
    $("#allcontact") .css('display','none');
    $("#enligne")    .css('display','none');
    $("#demande")    .css('display','none');
    $("#visite")     .css('display','none');
    $("#profil")     .css('display','none');
    $("#ligneee")    .css('display','none');
    refreshmsg(idd, first, 'a');
});	

/*
 *  La fonction qui affiche les messages d'un contact au clique sur messages en général
 */
$( "body" ).on( "click", ".aab", function(){
    if(timer !==''){ suppr(timer); timer=''; }
    var ide = this.id;
    var idd = ide.substr(1);
    var first   = this.name;
    $("#allmessage") .css('display','block');
    $("#contgu")     .css('display','block');
    $("#message")    .css('display','block');
    $("#allcontact") .css('display','none');
    $("#enligne")    .css('display','none');
    $("#demande")    .css('display','none');
    $("#visite")     .css('display','none');
    $("#profil")     .css('display','none');
    $("#ligneee")    .css('display','none');
    refreshmsg(idd, first, 'a');
});	

/*
 *  La fonction affiche les messages d'un contact au clique sur un contact de la liste des contacts
 */
$( "body" ).on( "click", ".bb", function(e){		
    if(timer !== ''){ suppr(timer); timer=''; }
    var idd 	= this.id; // Récupère l'id du message
    var first   = this.name;
    $("#allcontact") .css('display','block');
    $("#contgu")     .css('display','block');
    $("#message")    .css('display','block');
    $("#allmessage") .css('display','none');
    $("#enligne")    .css('display','none');
    $("#demande")    .css('display','none');
    $("#visite")     .css('display','none');
    $("#profil")     .css('display','none');
    $("#ligneee")    .css('display','none');
    refreshmsg(idd, first, 'a');
});	

/*
 *  La fonction qui refresh l'etat de connexion de l'utilisateur En ligne ou Hors ligne
 */
$.PeriodicalUpdater(Routing.generate('ajax_diridarek_enLigne'), 
    {
        method:     'POST',
        minTimeout: 6000,
        maxTimeout: 650000,
        multiplier: 1
    }, function(json, success, xhr, handle) {
        if(json.data !== 'yes') window.location.href = 'http://www.diridarek.com/'; 
    }
);

/*
 *  La fonction qui refuse la demande d'amis dans l'onglet visite 
 */
$( "body" ).on( "click", ".demandi", function(){
    var idd = this.id;
    jQuery.ajax({
        type: 	  'POST',
        url:  	  '../controllers/accueil/demande.php?callback=?',
        data: 	  { dest: idd },
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success:  function(json) {
            if(json !== ''){
            }
        }
    });
});

/*
 *  La fonction qui accepte la demande d'amis
 */
$( "body" ).on( "click", ".ouiami", function(){
    var ide = this.id; // Récupère l'id du message
    $.ajax({
        type:     'GET',
        url:      '../controllers/accueil/ouiami.php?ami='+ide+'&callback=?',
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success:  function(data) {
    	}
    });
});

/*
 *  La fonction qui refuse la demande d'amis
 */
$( "body" ).on( "click", ".nonami", function(){
    var ide = this.id; // Récupère l'id du message
    $.ajax({
        type:     'GET',
        url:      '../controllers/accueil/nonami.php?ami='+ide+'&callback=?',
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success:  function() {
        }
    });
});

/*
 *  La fonction qui permet de créer un cookie 
 *  @param var name Le nom du cookie
 *  @param var value La valeur du cookie
 *  @param int minutes La durée de vie du cookie en minutes
 */
function createCookie(name,value,minutes) {
    var expires = "";
    if (minutes) {
        var date = new Date();
        date.setTime(date.getTime()+(minutes*60*1000));
        expires = "; expires="+date.toGMTString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

/*
 *  La fonction qui lit un cookie
 *  @param var name Le nom du cookie a lire
 *  @return la valeur du cookie  
 */
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0) ===' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

/*
 *  La fonction qui supprime un cookie
 *  @param var name Le nom du cookie supprimer
 */
function eraseCookie(name) {
    createCookie(name, "", -1);
}

/*
 *  La fonction qui calcule la difference entre deux dates >> onligne/hors ligne
 *  @param datetime date Date de pubication aaaa-MM-dd hh:mm:ss
 *  @return int r Difference en minute entre Date et le moment d'exécution de la fonction  
 */
function dateDiff(date,sexe){
    var r;
    datedebut = new Date();
    datedebut.setDate(date.substring(8,10));
    datedebut.setMonth(date.substring(5,7)-1);
    datedebut.setFullYear(date.substring(0,4));
    datedebut.setHours(date.substring(11,13));
    datedebut.setMinutes(date.substring(14,16));
    datefin = new Date();
    var resultat = datefin.getTime() - datedebut.getTime();
    r = Math.round(resultat/60000);
    if(r>10 || r<0){ if(sexe === 'Mr') r = '<h4><img class="stitio" src="../images/off_ligne_man.png" alt="" /></h4>'; else if(sexe === 'Mlle') r = '<h4><img class="stitia" src="../images/off_ligne_woman.png" alt="" /></h4>'; }
    else 		   { if(sexe === 'Mr') r = '<h4><img class="stitio" src="../images/en_ligne_man.png"  alt="" /></h4>'; else if(sexe === 'Mlle') r = '<h4><img class="stitia" src="../images/en_ligne_woman.png"  alt="" /></h4>'; }
    return r;
}

/*
 *  La fonction qui envoi la demande d'ami
 */
$( "body" ).on( "click", ".cdemande", function(){
    var iddd = this.id;
    var idd  = iddd.substr(1);
    jQuery.ajax({
        type: 	  'POST',
        url:  	  '../controllers/accueil/demande.php?callback=?',
        data: 	  { dest: idd },
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success:  function(json) {
            if(json !==''){
                $("#"+ iddd).empty().html('<a href="" class="envoee" onClick="return false;"><img class="bou" src="../images/envoie.png" alt="" />Envoyée</a>').show();
            }
        }
    });
});

/* 
 *  La fonction qui envoi la demande d'ami au nouveau refresh
 */
$( "body" ).on( "click", ".ddemande", function(){
    var idd  = this.id;
    var iddd = idd.substr(1);
    jQuery.ajax({
        type: 	  'POST',
        url:  	  '../controllers/accueil/demande.php?callback=?',
        data: 	  { dest: iddd },
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success:  function(json) {
            if(json !== ''){
                $("#"+idd).empty().html('Demande envoyée');
            }
        }
    });
});

/*
 *  La fonction qui supprime les messages dans l'onglet messages
 */
$( "body" ).on( "click", ".supprM", function(){
    var idd = this.id;
    var idM = idd.substr(8);
    jQuery.ajax({
	type: 	  'POST',
	url:  	  '../controllers/accueil/supprM.php',
	data: 	  { suppr: idM },
        datatype: 'html',
	complete:  function(){
            $("#missage" + idM).hide();
	}
    });    
});

/*
 *  La fonction qui affiche le profil
 */
function profil(idd){
    $("#contgu").css('display','block');
    $('#profilload').show();
    var profil='';
    var demande, couverture, photo, nom, lien;
    jQuery.ajax({
        type: 	  'POST',
        url:  	  '../controllers/accueil/profil.php?callback=?',
        data: 	  { dest: idd },
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success:  function(json) {
            if(json['ami'] === 1) demande='Demande envoyé'; else if(json['ami'] === 0) demande='Demander';
            lien = "'profil.php?dar="+idd+"'";
            if(json['photo'] !== ""){ photo = "<div class='imdpo'><img src='../img/profil/"+ json['photo'] +"' alt='' /></div>"; }else{
                if(json['sexe'] === 'Mr') photo = '<div class="imdpo"><img src="../images/man.jpg" alt="" /></div>'; 
                else if(json['sexe'] === 'Mlle') photo = '<div class="imdpo"><img src="../images/woman.png" alt="" /></div>';
            }
            if(json['couverture'] !== ""){ couverture = "<img src='../img/couverture/"+ json['couverture'] +"' alt='' />"; }else{
                couverture = '<img src="../images/saddam.jpg" alt="" />';
            }
            if(json['nom'] === '') 	 nom = stripslashes(htmlspecialchars(utf8_encode(json["prenom"]), "ENT_QUOTES")); else nom = stripslashes(htmlspecialchars(utf8_encode(json["prenom"]), "ENT_QUOTES")) + ' ' + stripslashes(htmlspecialchars(utf8_encode(json["nom"]), "ENT_QUOTES"));
            profil +='		<div class="dphome">';
            profil +=couverture;
            profil +='		</div>';
            profil +='		<div class="dprofil">';
            profil +=photo;
            profil +='			<div class="dpprofi">';
            profil +='				<div class="dpconthead">';
            profil +='					<h3>'+ nom +'</h3>';
            profil +='					<a href="#" onClick="return false;">' + dateDiff(json["last"],json["sexe"]) + '</a>';
            profil +='					<p>'+ age(json['naissance']) +'ans, '+ stripslashes(htmlspecialchars(utf8_encode(json["ville"]), "ENT_QUOTES")) +'</p>';
            profil +='				</div>';
            profil +='				<p class="inpros">'+ stripslashes(htmlspecialchars(utf8_encode(json['statut']), "ENT_QUOTES")) +'</p>';
            profil +='				<p class="inpro">';
            profil +='					Derniere connexion : ' + json['last'];
            profil +='				</p>';
            profil +='				<div class="dpcontfoot">';
            if(json['ami'] === "1" || json['pers'] === 'Mlle') 
            profil +=' <a href="" class="aab" id="i'+idd+'" name="'+stripslashes(htmlspecialchars(utf8_encode(json['prenom']), "ENT_QUOTES"))+'" onClick="return false;">Message</a>';
            profil +='					<a href="profil.php?dar='+idd+'">Détail</a>';
            profil +='				</div>';
            profil +='			</div>';
            profil +='		</div>';
            profil +='		<div class="fheader">';
            profil +='			<div class="fhheader">';
            profil +='			</div>';
            profil +='		</div>';
            profil +='		<div class="formb">';
            if(json['ami'] === "1" || json['pers'] === 'Mlle') 
                profil += '<input class="forpro" type="submit" onClick="document.location.href='+ lien +';" value="Détail">';
            else                    
                profil +='			<input class="forpro" id="dem'+ idd +'" type="submit" onClick="demande('+idd+'); return false;" value="'+ demande +'" name="valider">';
            profil +='		</div>';

            $("#profili").empty().html(profil);
            $('#profilload').hide();
            $('#i'+idd).on('click', function(){
                $("#message")    .css('display','block');
                $("#profil")     .css('display','none');
            });
            $('#dem'+ idd).on('click', function(){
                $('#dem'+ idd).val('Demande envoyée');
            });
        }
    });
}

/*
 *  La fonction qui envoi la demande d'ami en mode procedural
 */
function demande(idd){ 
    jQuery.ajax({
        type: 	  'POST',
        url:  	  '../controllers/accueil/demande.php?callback=?',
        data: 	  { dest: idd },
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success:  function(json) {
            if(json !== ''){
            }
        }
    });
};

/*
 *  La fonction qui supprime les messages dans l'onglet messages
 */
$( "body" ).on( "click", ".supprC", function(){
    var idd = this.id;
    var idM = idd.substr(8);
    jQuery.ajax({
        type: 	  'POST',
        url:  	  '../controllers/accueil/supprC.php',
        data: 	  { suppr: idM },
    	datatype: 'html',
        complete:  function(){
            $("#cintact" + idM).hide();
        }
    });    
});

/*
 *  La function qui affiche les demandes d'amis
 */
function demandes(){
    
    var nbrD = 0;
    demandes = '';
    var photo, ville, sexe;
    $("#demandeload").show();
    $.ajax({
        type:     'POST',
        url:      '../controllers/accueil/demandes.php?callback=?',
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success: function(data) {
            var demandes;
            demandes='';
            for( var x in data ) {     

                var lignes = data[x];
                if(lignes.photo !== ""){ photo = "<div class='imdpo'><img src='../img/profil/"+ lignes.photo +"' alt='' /></div>"; }else{
                        if(lignes.sexe === 'Mr') photo = '<div class="imdpo"><img src="../images/man.jpg" alt="" /></div>'; 
                        else if(lignes.sexe === 'Mlle') photo = '<div class="imdpo"><img src="../images/woman.png" alt="" /></div>';
                }
                if(lignes.ville !== "") ville = ', '+ lignes.ville; else ville = "";
                demandes += '<li id="dimama'+ lignes.id +'">';
                demandes += '   <div class="dprofil">';
                demandes += photo;
                demandes += '       <div class="dpcont">';
                demandes += '           <div class="dpconthead">';
                demandes += '               <h5>'+ stripslashes(htmlspecialchars(utf8_encode(lignes.prenom), "ENT_QUOTES")) +'</h5>';
                demandes += '               ' + dateDiff(lignes.last,lignes.sexe);
                demandes += '               <p class="stiop"><img class="stitig" src="../images/age.png" alt="" />'+ age(lignes.naissance) +'ans</p>'; //visites += ville +'</p>';
                demandes += '           </div>';
                demandes += '           <p class="inpros">'+ stripslashes(htmlspecialchars(utf8_encode(lignes.statut), "ENT_QUOTES")) +'</p>';
                demandes += '           <p class="inpro">Derniere connexion : '+ lignes.last +'</p>';
                demandes += '           <div class="dptfoot">';
                demandes += '               <a href="" id="'+ lignes.id +'" class="nonami" onClick="return false;">Refuser</a>';
                demandes += '               <a href="" id="'+ lignes.id +'" class="ouiami" onClick="return false;">Accepter</a>';
                if(sexe==='Mlle') demandes += '               <a class="aa" id="'+lignes.id+'" name="'+ stripslashes(htmlspecialchars(utf8_encode(lignes.prenom), "ENT_QUOTES")) +'" href=""  onClick="afficheMsg(); return false;">Message</a>';
                demandes += '               <a href="profil.php?dar='+ lignes.id +'">Profil</a>';
                demandes += '           </div>';
                demandes += '       </div>';
                demandes += '   </div>';
                demandes += '</li>';
                nbrD++;
            }
            $("#demandes").hide();
            $("#dimane").empty().html(demandes);
            $("#demandeload").hide();
            if(nbrD === 0) $("#dimo").show(); else if(nbrD > 0) $("#dimo").hide();
            
            $( "body" ).on( "click", ".nonami", function(){
                var idd = this.id;
                $("#dimama"+idd).hide();
            });
            
            $( "body" ).on( "click", ".ouiami", function(){
                var idd = this.id;
                $("#dimama"+idd).hide();
            });
            
            $( "body" ).on( "click", "#mimiA", function(){
                $("#demande")    .css('display','none');
                $("#message")    .css('display','block');
            });
            
            $( "body" ).on( "click", "#proA", function(){
                $("#demande")    .css('display','none');
                $("#profil")     .css('display','block');
            }); 
        }
    });
}

function afficheMsg(){
    $("#demande")    .css('display','none');
    $("#message")    .css('display','block');
}

/*
 *  La function qui afirme la vision de l'acceptation des demandes d'amis
 */
function demand(){
    $.ajax({
        type:     'POST',
        url:      '../controllers/accueil/demandeOk.php',
        dataType: 'html',
        success:  function() {
            $('#contac').hide();
        }
    });
}

/*
 *  La fonction qui clacule l'age
 */
function age(data){
    dat      = new Date();
    var year = '1' + dat.getYear();
    var Y    = '20' + year.substr(2);
    r        = Y - data;
    return r;
}

/*
 *  La function qui affiche les visites de profil
 */
function visites(){
    $("#visiteload").show();
    $.ajax({
        type:     'POST',
        url:      '../controllers/accueil/visites.php?callback=?',
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success: function(data) {
            var visites,photo,ville;
            visites='';
            if(data === '') $("#pasdevisite").show(); else $("#pasdevisite").hide();
            for( var x in data ) {  
                var lignes = data[x];
                if(lignes.photo !== ""){ photo = "<div class='imdpo'><img src='../img/profil/"+ lignes.photo +"' alt='' /></div>"; }else{
                    if(lignes.sexe === 'Mr') photo = '<div class="imdpo"><img src="../images/man.jpg" alt="" /></div>'; 
                    else if(lignes.sexe === 'Mlle') photo = '<div class="imdpo"><img src="../images/woman.png" alt="" /></div>';
                }
                if(lignes.ville !== "")  ville = ', '+ lignes.ville; else ville = "";
                visites += '<li>';
                visites += '   <div class="dprofil">';
                visites += photo;
                visites += '       <div class="dpcont">';
                visites += '           <div class="dpconthead">';
                visites += '               <h5>'+ stripslashes(htmlspecialchars(utf8_encode(lignes.prenom), "ENT_QUOTES")) +'</h5>';
                visites += '               ' + dateDiff(lignes.last,lignes.sexe);
                visites += '               <p class="stiop"><img class="stitig" src="../images/age.png" alt="" />'+ age(lignes.naissance) +'ans</p>'; //visites += ville +'</p>';
                visites += '           </div>';
                visites += '           <p class="inpros">'+ stripslashes(htmlspecialchars(utf8_encode(lignes.statut), "ENT_QUOTES")) +'</p>';
                visites += '           <p class="inpro">Derniere connexion : '+ lignes.last +'</p>';
                visites += '           <div class="dptfoot">';
                visites += '<a href="" class="cdemande" id="'+ lignes.id +'" onClick="return false;">Demander</a>';
                if(lignes.ami === '1' && lignes.sexe === 'Mr') visites += '               <a href="" class="aa" id="'+ lignes.id +'" onClick="afficheMsg(); return false;" name="'+ lignes.prenom +'">Message</a>';
                visites += '               <a href="profil.php?dar='+ lignes.id +'">Profil</a>';
                visites += '           </div>';
                visites += '       </div>';
                visites += '   </div>';
                visites += '</li>';
            }
            $('#visites').hide();
            $("#visitesss").hide();
            $("#visitess").empty().html(visites);
            $("#visiteload").hide();
            
            $(".cdemande").on("click", function(){		
                var idd  = this.id;
                $("#"+ idd).empty().html('Envoyée').show();
            });
            
            $( "body" ).on( "click", "#proB", function(){
                $("#visite")     .css('display','none');
                $("#profil")     .css('display','block');
            });
        }
    });
}

/*
 *  L'envoi d'un feedback
 */
$("#subfeedback").on("click", function(){
    
    var feed     = $("#feedback").val();
    var feedback = '<img src="../images/check.png" /><input type="button" value="Message envoyé, merci." class="avias">';
    var lolll    = $("#lolll").val();
    if(feed !== '' && feed !== 'Donnez votre avis, signalez un problème,...' && lolll === 'azerty'){
        $.ajax({
            type:     'POST',
            data:	  { feed: feed },
            url:      '../controllers/accueil/feedback.php',
            datatype: 'html',
            success:  function(data) {
                if(data === 'ok'){
                    $("#subfeedback").hide().empty();
                    $("#feedmerci").html(feedback);					
                }
            }
        });
    }
});

/*
 *  L'envoi d'un statut
 */
$("#substatut").on("click", function(){
    $("#substatut").hide();
    $("#statutmerci").show();
    var photo;
    var actu = "";
    var feed     = $("#statut").val();
    var feedback = '<img src="../images/check.png" /><input type="button" value="Statut envoyé, merci." class="avias">'; //alert(feedback);
    var lollll   = $("#lollll").val();
    if(feed !== '' && feed !== 'Écrire un message...' && lollll === 'azerty'){
    	$.ajax({
            type:     'POST',
            data:     { feed: feed },
            url:      '../controllers/accueil/statut.php?callback=?',
            cache:    false,
            async:    true,
            dataType: 'jsonp',
            success:  function(data) {
                for( var x in data ) {
                    var lignes = data[x];
                    actu += "<li>";
                    if(lignes.photo !== ""){ photo = stripslashes(htmlspecialchars(lignes.photo, "ENT_QUOTES"));
                        actu += '<img class="achead" src="../img/profil/'+ photo +'" alt="" />';
                    }else{
                        if(lignes.sexe === "Mr") photo = 'man.jpg'; else if(lignes.sexe === 'Mlle') photo = "woman.png";
                        actu += '<img class="achead" src="../images/'+ photo +'" alt="" />';
                    }
                    actu += '<div class="boactu">';
                    actu += '<div class="foactu">';
                    actu += '<h3><a href="profil.php?dar=' + lignes.id_compte +'">'+ stripslashes(htmlspecialchars(lignes.prenom, "ENT_QUOTES")) + ' </a> </h3> ';
                    actu += '</div>';
                    actu += '<p>Il y a 1h</p>';
                    actu += '<div class="ctuco">';
                    actu += '<div class="ctuco">';
                    actu += '<h5>'+ stripslashes(htmlspecialchars(lignes.statut, "ENT_QUOTES")) +'</h5>';
                    actu += '</div>';
                    actu += '</div>';
                    actu += '</div>';
                    actu += "</li>";
					
                    $('#ligneee').show();
                    $('#actu').show();
                    $('#allmessage').hide(); 
                    $('#allcontact').hide();
                    $('#demande').hide();
                    $('#tout').hide();
                    $('#enligne').hide();
                    $('#visite').hide();
                    $('#messages').hide();

                    $("#actutu").html(actu).slideDown('slow');
                    $("#statut").val("");

                    $("#statutmerci").hide();
                    $("#substatut").show();			
                }
            }
        });
    }
});

/*
 *  Supprime le message remarque
 */
$("#cbon").on("click", function(){
    $("#remarque").slideUp();
    $.ajax({
        type:     'POST',
        url:      '../controllers/accueil/suppr_remarque.php',
        success:  function() {
        }
    });
});

/*
 *  La fonction qui refresh les en lignes sur le site
 */
$("#refresh").on("click", function(){
    $('#membresenligne').show();
    $.ajax({
        type:     'POST',
        url:      '../controllers/accueil/refresh.php?callback=?',
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success:  function(data) {
            if(data !== '' && data !== null){
                var refresh,photo,ville;
                refresh='';
                for( var x in data ) {    
                    var lignes = data[x];
                    if(lignes.photo !== ""){ photo = "<img src='../img/profil/"+ lignes.photo +"' alt='' />"; }else{
                        if(lignes.sexe === 'Mr') photo = '<img src="../images/man.jpg" alt="" />'; 
                        else if(lignes.sexe === 'Mlle') photo = '<img src="../images/woman.png" alt="" />';
                    }
                    if(lignes.statut !== '' || lignes.statut !== null) statut = stripslashes(htmlspecialchars(utf8_encode(lignes.statut), "ENT_QUOTES")); else statut='';
                    if(lignes.ville !== "")  ville = ', '+ lignes.ville; else ville = "";
                    refresh += '<li>';
                    refresh += '	<div class="dpmem">';
                    refresh += '		<div class="prlim">'+ photo +'</div>';
                    refresh += '        	<div class="dpcomem">';
                    refresh += '				<div class="dpconthead">';
                    refresh += '                	<h3><div class="limit"><a href="profil.php?dar='+ lignes.id +'">' + stripslashes(htmlspecialchars(utf8_encode(lignes.prenom), "ENT_QUOTES")) + '</a></div>, '+ age(lignes.naissance) +'</h3>';
                    refresh += '               		<a>' + dateDiff(lignes.last,lignes.sexe) + '</a>';
                    if(lignes.ville !== '') refresh += '<p class="stiop"><img class="stitiv" src="../images/situ.png" alt="" />'+ stripslashes(htmlspecialchars(utf8_encode(lignes.ville), "ENT_QUOTES")); refresh +='</p>';
                    refresh += '				</div>';
                    refresh += '			<div class="dpcontfoot">';
                    if(lignes.ami === '0'){ 
                        if(lignes.demande === "0" ){ 
                            refresh += '<a href="" class="cdemande" id="k'+ lignes.id +'" onClick="return false;"><img class="bou" alt="" src="../images/ajou.png"> Demander</a>'; 
                        }else{
                            refresh += '<a href="" class="envoee" onClick="return false;"><img class="bou" src="../images/envoie.png" alt="" /> Envoyée</a>';
                        }
                    }
                    if(lignes.ami === '1' || bit === 'Mlle') refresh += '<a href="" class="aa" id="'+ lignes.id +'" name="'+ stripslashes(htmlspecialchars(utf8_encode(lignes.prenom), "ENT_QUOTES")) +'" onClick="afficheMsg(); return false;">Message</a>';
                    refresh += '			</div>';
                    refresh += '    	</div>';
                    refresh += '	</div>';
                    refresh += '</li>';
                }

                $("#ajenligne").hide();
                $("#ajaxenligne").empty().html(refresh).show();
                $('#membresenligne').hide();

                $(".cdemande").on("click", function(){
                    var idd  = this.id;
                    $("#"+ idd).empty().html('<a href="" class="envoee" onClick="return false;"><img class="bou" src="../images/envoie.png" alt="" /> Envoyée</a>').show();
                });

                $( "body" ).on( "click", "#proD", function(){
                    $("#enligne")    .css('display','none');
                    $("#profil")     .css('display','block');
                });
            }
        }
    });
});

/*
 *  La fonction qui affiche la suite de la liste d'actualite
 */
$( "body" ).on( "click", ".plus", function(){
    $("#plus").hide();
    $("#plus_loading").show();
    jQuery.ajax({
        type: 	  'POST',
        url:  	  Routing.generate('ajax_diridarek_news'),
        data: 	  { pg: idPage },
        cache:    false,
        success:  function(data) {
            $("#plus_loading").hide();
            $("#suiteActu").append(data);
            $("#plus").show();
            idPage = idPage+10;
        }
    });
});

/*
 *  La fonction de pagination
 */
$(".pagination").on("click", function(){
    $('#membresenligne').show();
    var idd = this.id;
    var id  = (idd.substr(3)*15)-15;
    $.ajax({
        type:     'POST',
        url:      '../controllers/accueil/pagination.php?callback=?',
        data:	  { p:id },
        cache:    false,
        async:    true,
        dataType: 'jsonp',
        success:  function(data) {
            if(data !== '' && data !== null){
                var refresh,photo,ville,pre;
            	refresh='';
            	for( var x in data ) {
                    var lignes = data[x];
                    pre = lignes.prenom;
                    if(lignes.photo !== ""){ photo = "<img src='../img/profil/"+ lignes.photo +"' alt='' />"; }else{
                        if(lignes.sexe === 'Mr') photo = '<img src="../images/man.jpg" alt="" />'; 
                        else if(lignes.sexe === 'Mlle') photo = '<img src="../images/woman.png" alt="" />';
                    }
                    if(lignes.statut !== '' || lignes.statut !== null) statut = stripslashes(htmlspecialchars(utf8_encode(lignes.statut), "ENT_QUOTES")); else statut='';
                    if(lignes.ville !== "")  ville = ', '+ stripslashes(htmlspecialchars(utf8_encode(lignes.ville), "ENT_QUOTES")); else ville = "";
                    refresh += '<li>';
                    refresh += '	<div class="dpmem">';
                    refresh += '		<div class="prlim">'+ photo +'</div>';
                    refresh += '        	<div class="dpcomem">';
                    refresh += '				<div class="dpconthead">';
                    refresh += '                	<h3><div class="limit"><a href="profil.php?dar='+ lignes.id +'">' + stripslashes(htmlspecialchars(utf8_encode(lignes.prenom), "ENT_QUOTES")) + '</a></div>, '+ age(lignes.naissance) +'</h3>';
                    refresh += '               		<a>' + dateDiff(lignes.last,lignes.sexe) + '</a>'; 
                    if(lignes.ville !== '') refresh += '<p class="stiop"><img class="stitiv" src="../images/situ.png" alt="" />'+ stripslashes(htmlspecialchars(utf8_encode(lignes.ville), "ENT_QUOTES")); refresh +='</p>';
                    refresh += '				</div>';
                    refresh += '			<div class="dpcontfoot">';
                    if(lignes.ami === '0'){ 
                        if(lignes.demande === "0" ){ 
                            refresh += '<a href="" class="cdemande" id="k'+ lignes.id +'" onClick="return false;"><img class="bou" alt="" src="../images/ajou.png"> Demander</a>'; 
                        }else{
                            refresh += '<a href="" class="envoee" onClick="return false;"><img class="bou" src="../images/envoie.png" alt="" /> Envoyée</a>';
                        }
                    }
                    if(lignes.ami === '1' || bit === 'Mlle') refresh += '<a href="" class="aa" id="'+ lignes.id +'" onClick="afficheMsg(); return false;" name="'+ stripslashes(htmlspecialchars(utf8_encode(lignes.prenom), "ENT_QUOTES")) +'"><img class="bou" alt="" src="../images/mes.png"> Message</a>';
                    refresh += '			</div>';
                    refresh += '    	</div>';
                    refresh += '	</div>';
                    refresh += '</li>';
                }
				
                $("#ajenligne").hide();
                $("#ajaxenligne").empty().html(refresh).show();

                $('#membresenligne').hide();

                $(".cdemande").on("click", function(){
                    var idd  = this.id;
                    $("#"+ idd).empty().html('<a href="" class="envoee" onClick="return false;"><img class="bou" src="../images/envoie.png" alt="" />Envoyée</a>').show();
                });
                $( "body" ).on( "click", "#proD", function(){
                    $("#enligne").css('display','none');
                    $("#profil") .css('display','block');
                });
            }	
        }
    });
});

/*
 *  La fonction equivalente a utf8_encode en php
 */
function utf8_encode(argString) {
    //  discuss at: http://phpjs.org/functions/utf8_encode/
    if (argString === null || typeof argString === 'undefined') {
        return '';
    }
    var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
    var utftext = '',
    start, end, stringl = 0;
    start = end = 0;
    stringl = string.length;
    for (var n = 0; n < stringl; n++) {
        var c1 = string.charCodeAt(n);
        var enc = null;
        if (c1 < 128) {
            end++;
        } else if (c1 > 127 && c1 < 2048) {
            enc = String.fromCharCode(
                (c1 >> 6) | 192, (c1 & 63) | 128
            );
        } else if ((c1 & 0xF800) !== 0xD800) {
            enc = String.fromCharCode(
                (c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
            );
        } else { // surrogate pairs
            if ((c1 & 0xFC00) !== 0xD800) {
                throw new RangeError('Unmatched trail surrogate at ' + n);
            }
            var c2 = string.charCodeAt(++n);
            if ((c2 & 0xFC00) !== 0xDC00) {
                throw new RangeError('Unmatched lead surrogate at ' + (n - 1));
            }
            c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
            enc = String.fromCharCode(
                (c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
            );
        }
        if (enc !== null) {
            if (end > start) {
                utftext += string.slice(start, end);
            }
            utftext += enc;
            start = end = n + 1;
        }
    }
    if (end > start) {
      utftext += string.slice(start, stringl);
    }
    return utftext;
}

/*
 *  La fonction equivalente a htmlspecialchars en php
 */
function htmlspecialchars(string, quote_style, charset, double_encode) {
  //       discuss at: http://phpjs.org/functions/htmlspecialchars/
    var optTemp = 0,
    i = 0,
    noquotes = false;
    if (typeof quote_style === 'undefined' || quote_style === null) {
        quote_style = 2;
    }
    string = string.toString();
    if (double_encode !== false) { // Put this first to avoid double-encoding
        string = string.replace(/&/g, '&amp;');
    }
    string = string.replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
    var OPTS = {
        'ENT_NOQUOTES': 0,
        'ENT_HTML_QUOTE_SINGLE': 1,
        'ENT_HTML_QUOTE_DOUBLE': 2,
        'ENT_COMPAT': 2,
        'ENT_QUOTES': 3,
        'ENT_IGNORE': 4
    };
    if (quote_style === 0) {
        noquotes = true;
    }
    if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
        quote_style = [].concat(quote_style);
        for (i = 0; i < quote_style.length; i++) {
            // Resolve string input to bitwise e.g. 'ENT_IGNORE' becomes 4
            if (OPTS[quote_style[i]] === 0) {
                noquotes = true;
            } else if (OPTS[quote_style[i]]) {
                optTemp = optTemp | OPTS[quote_style[i]];
            }
        }
        quote_style = optTemp;
    }
    if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
        string = string.replace(/'/g, '&#039;');
    }
    if (!noquotes) {
        string = string.replace(/"/g, '&quot;');
    }
    return string;
}

/*
 *  La fonction equivalente a stripslashes en php
 */
function stripslashes(str) {
  //       discuss at: http://phpjs.org/functions/stripslashes/
  return (str + '')
    .replace(/\\(.?)/g, function(s, n1) {
        switch (n1) {
            case '\\':
                return '\\';
            case '0':
                return '\u0000';
            case '':
                return '';
            default:
            return n1;
        }
    });
}
