// Refresh et affiche la liste des messages 
function refreshlistmsg(){
		
	var idm, msgajax;
    var tab, ligne = new Array();

	$('#miss').PeriodicalUpdater('controllers/accueil/messages.php', 
		{
				method: 'GET',          // méthode; get ou post
				//data: {},               // tableau de valeurs passées à l'URL - e.g. {nom: "Yriase", msg: "Hello World"}
				minTimeout: 10000,       // valeur de départ du timeout en millisecondes
				maxTimeout: 11000,       // valeur maximum du timeout en millisecondes
				multiplier: 2,          // valeur pour incrémenter le timeout si la réponse n'a pas changé (jusqu'à maxTimeout)
				type: 'json',           // type de la réponse : text, xml, json, etc.  Voir $.ajax
				//maxCalls: 0,            // nombre maximum d'appels. 0 = pas de limite.
				autoStop: 15,            // arrête automatiquement la requête après plusieurs retours renvoyant les mêmes données. 0 = désactivé.
				//autoStopCallback: function() { ... } // Callback a exécuter quand l'autoStop est déclenché
				//cookie: {},             // configuration du cookie pour stocker le timeout
				//verbose: 0             // niveau de verbosité des logs : 0=aucuns, 1=moyen, 2=tout

		}, function(data, success, xhr, handle) {

			msgajax='';
			for( var x in data ) {            
            	var lignes = data[x];
            	if(lignes.de != lignes.session) id = lignes.de; else id = lignes.a;
				idm  = 'msg' + id;
				msgajax +='<li>';
				msgajax +='    <a href="" onClick="return false;"><img class="lasup" src="images/Delete-icon.png" alt="" /></a>';
				msgajax +='    <a id="'+ idm +'" onClick="return false;" href="" >';															
				msgajax +='	       <div class="cprofil">';
				msgajax +='			   <img src="images/man.jpg" alt="" />';
				msgajax +='					<div class="cpcont">';
				msgajax +='						<div class="cpconthead">';
				msgajax +='							<h3>Zinedine Zidane</h3>';
				msgajax +='							<p>En ligne</p>';
				msgajax +='						</div>';
				msgajax +='					</div>';
				msgajax +='		   </div>';
				msgajax +='    </a>';
				msgajax +='</li>';	
				
				getget(id, handle);
            }
            $("#lesmessages").empty().html(msgajax);
            
			$('#con').on('click',function(){
				handle.stop();		
			});
			
			$('#miss').on('click',function(){
				handle.restart();				
			});

	});
}


// Refrech et affiche les messages d'un seul utilisateur
function refreshmsg(id, handle){
															
	
	$.getJSON('controllers/accueil/msg.php?id='+ id,function(json){
			
			if(idd !='' && idd !=null) eraseCookie(idd);
			createCookie(idd,id,5);
			var msgajx = '<ul>';
			for( var x in json ) {
				var ligne = json[x];
				msgajx += '<li><div class="amessage"><img src="images/man.jpg" alt="" /><div class="amgcont"><div class="amesshead"><h3>Zinedine Zidane</h3><a>'+ ligne.depot +'</a><a>En ligne</a></div><p class="inpros">'+ ligne.msg +'</p></div></div></li>';
			}
			msgajx += '<li><div id="tmer"></div></li>';
			msgajx += '</lu>';
			$('#msgajax').html(msgajx);	
			
			//var idBut = "sendMessage" + id;
			var butum = '<input class="formes" id="sendMessage" type="button" value="Répondre" name="valider">';
			//var tmer = '';
			$("#butum").empty().html(butum);
					
			
			/*
			$('#' + idBut).on('click', function(){
				var messaGe = $('#boxMessage').val();
				if(messaGe!=''){
					
					
					/*
					$('#tmer').load("controllers/accueil/poster.php", {dest: id, msg: messaGe}, function(data) {
						if(data=='ok'){ 						
							//alert(data +' ok');
							tmer += '<div class="amessage"><img src="images/man.jpg" alt="" /><div class="amgcont"><div class="amesshead"><h3>Zinedine Zidane</h3><a> à l\'instant</a><a>En ligne</a></div><p class="inpros">'+ messaGe +'</p></div></div>';
								
							$('#boxMessage').val('');
							//$("#tmer").html(tmer);
						}
					});
					*/
				
				/*
					jQuery.ajax({
						type: 'POST',
						url:  'controllers/accueil/poster.php',
						data: { dest: id, msg: messaGe }, 
						success: function(data) {
							if(data=='ok'){ 						
								//alert(data +' ok');
								tmer += '<div class="amessage"><img src="images/man.jpg" alt="" /><div class="amgcont"><div class="amesshead"><h3>Zinedine Zidane</h3><a> à l\'instant</a><a>En ligne</a></div><p class="inpros">'+ messaGe +'</p></div></div>';
								
								$('#boxMessage').val('');
								$("#tmer").html(tmer);
							}
						}
					});
				*/ /*
				}
				//handle.restart();
				return false;
			});	
			*/																	 
	});				
	$("#demandeG").on("click", function(){ suppr(timer); });
	$("#visiteG") .on("click", function(){ suppr(timer); });	
	timer = setTimeout(function(){ refreshmsg(readCookie(idd)); }, 20000);
}

function suppr(time){
	clearTimeout(time);
}


// refresh NUM
function refreshGet(){
															
	jQuery.ajax({
		type:    'GET',
		url:     'controllers/accueil/get.php?&callback=?',
		cache:   false,
		async:   true,
		dataType: 'jsonp',
		success: function(json) {

			var nbr1,nbr2,nbr3;
			for( var x in json ) {
				var ligne = json[x];
				nbr1 = ligne.nbr1;
				nbr2 = ligne.nbr2;
				nbr3 = ligne.nbr3;		
			}
			$('#demandes').html(nbr1);
			$('#messages').html(nbr2);
			$('#visites').html(nbr3);
		}
	});
	timerGet = setTimeout(function(){ refreshGet(); }, 90000);
}

/*
function refreshlistmsg(){

	var idm, msgajax, id;
    var tab, ligne = new Array();
	$('#foo').smartupdater(`{`
			url					: 'controllers/accueil/messages.php',		// see jQuery.ajax for details
			type				: 'get', 	// see jQuery.ajax for details
			data				: '',   	// see jQuery.ajax for details
			dataType			: 'json', 	// see jQuery.ajax for details
								
			minTimeout			: 6000, 	// 1 minute
			maxFailedRequests 	: 10, 		// max. number of consecutive ajax failures
			maxFailedRequestsCb	: false, 	// falure callback function
			httpCache 			: false,	// http cache 
			rCallback			: false,	// remote callback functions
			selfStart			: true,		// start automatically after initializing
			smartStop			: { active:			false, 	//disabled by default
									monitorTimeout:	2500, 	// 2.5 seconds
									minHeight:		1,	  	// 1px
									minWidth:		1	  	// 1px	
								  } 
											  										  
			`}`, function (data) `{`
				$('#foo').html(data);
				
				msgajax='';
				for( var x in data ) {            
					var lignes = data[x];
					if(lignes.de != lignes.session) id = lignes.de; else id = lignes.a;
					idm  = 'msg' + id;
					msgajax += '<li>';
					msgajax += '        <a href="" onClick="return false;"><img class="lasup" src="images/Delete-icon.png" alt="" /></a>';
					msgajax += '        <a id="'+ idm +'" onClick="return false;" href="" >';															
					msgajax += '<div class="cprofil">';
					msgajax +='					<img src="images/man.jpg" alt="" /> ';
					msgajax +='						<div class="cpcont">';
					msgajax +='							<div class="cpconthead">';
					msgajax +='								<h3>Zinedine Zidane</h3>';
					msgajax +='								<p>En ligne</p>';
					msgajax +='							</div>';
					msgajax +='						</div>';
					msgajax +='				</div>';
					msgajax +='				</a>';
					msgajax +='			</li>';	
				
					getget(id);
				}
				
				$("#lesmessages").empty().html(msgajax);
				$( "#con" ).on('click',function(){
					ListeMessages.stop();
				});	
								
			`}`
	`)`;
}

*/

/*

function refreshlistmsg(){

		
	var idm, msgajax, id;
    var tab, ligne = new Array();

	$('#miss').PeriodicalUpdater('controllers/accueil/messages.php', 
		{
				method: 'get',          // méthode; get ou post
				data: {},               // tableau de valeurs passées à l'URL - e.g. {nom: "Yriase", msg: "Hello World"}
				minTimeout: 20000,       // valeur de départ du timeout en millisecondes
				maxTimeout: 35000,       // valeur maximum du timeout en millisecondes
				multiplier: 2,          // valeur pour incrémenter le timeout si la réponse n'a pas changé (jusqu'à maxTimeout)
				type: 'json',           // type de la réponse : text, xml, json, etc.  Voir $.ajax
				maxCalls: 0,            // nombre maximum d'appels. 0 = pas de limite.
				autoStop: 0,            // arrête automatiquement la requête après plusieurs retours renvoyant les mêmes données. 0 = désactivé.
				//autoStopCallback: function() { ... } // Callback a exécuter quand l'autoStop est déclenché
				//cookie: {},             // configuration du cookie pour stocker le timeout
				verbose: 0              // niveau de verbosité des logs : 0=aucuns, 1=moyen, 2=tout 

		}, function(data, success, xhr, ListeMessages) {

			
			//alert(ListeMessages);
			msgajax='';
			for( var x in data ) {            
            	var lignes = data[x];
            	if(lignes.de != lignes.session) id = lignes.de; else id = lignes.a;
				idm  = 'msg' + id;
				msgajax += '<li>';
				msgajax += '        <a href="" onClick="return false;"><img class="lasup" src="images/Delete-icon.png" alt="" /></a>';
				msgajax += '        <a id="'+ idm +'" onClick="return false;" href="" >';															
				msgajax += '<div class="cprofil">';
				msgajax +='					<img src="images/man.jpg" alt="" /> ';
				msgajax +='						<div class="cpcont">';
				msgajax +='							<div class="cpconthead">';
				msgajax +='								<h3>Zinedine Zidane</h3>';
				msgajax +='								<p>En ligne</p>';
				msgajax +='							</div>';
				msgajax +='						</div>';
				msgajax +='				</div>';
				msgajax +='				</a>';
				msgajax +='			</li>';	
				
				getget(id);
            }
            $("#lesmessages").empty().html(msgajax);
            
            $( "#con" ).on('click',function(){
				ListeMessages.stop();
			});	
			
			$( "#miss" ).on('click',function(){
				ListeMessages.restart();
			});		
			
	});

}

*/




// Refresh et affiche la liste des messages 
/*
function refreshlistmsg(){

		var idm, msgajax, id;
        var tab, ligne = new Array();
        $.getJSON('controllers/accueil/messages.php',function(data){
			msgajax='';
			for( var x in data ) {            
            	var lignes = data[x];
            	if(lignes.de != lignes.session) id = lignes.de; else id = lignes.a;
				idm  = 'msg' + id;
				msgajax += '<li>';
				msgajax += '        <a href="" onClick="return false;"><img class="lasup" src="images/Delete-icon.png" alt="" /></a>';
				msgajax += '        <a id="'+ idm +'" onClick="return false;" href="" >';															
				msgajax += '<div class="cprofil">';
				msgajax +='					<img src="images/man.jpg" alt="" /> ';
				msgajax +='						<div class="cpcont">';
				msgajax +='							<div class="cpconthead">';
				msgajax +='								<h3>Zinedine Zidane</h3>';
				msgajax +='								<p>En ligne</p>';
				msgajax +='							</div>';
				msgajax +='						</div>';
				msgajax +='				</div>';
				msgajax +='				</a>';
				msgajax +='			</li>';	
				
				getget(id);
            	//ligne += id + ',';
            }
            //ligne = ligne.substring(0,ligne.length-1); 

            //alert(ligne);
            //alert(item);
            $("#lesmessages").empty().html(msgajax);
        });
		timermsg = setTimeout(function(){ refreshlistmsg(); }, 20000);
}
*/







/*
// Refresh et affiche le nombre de visite du profil
function refreshVisite(){
															
	$.getJSON('controllers/accueil/getVisites.php',function(json){

			var msgajx = '';
			for( var x in json ) {
				var ligne = json[x];
				msgajx += ligne.nbr;
			}
			$('#visites').html(msgajx);
	});
	timerVisite = setTimeout(function(){ refreshVisite(); }, 100000);
}
// Refresh et affiche les demandes d'amis
function refreshDemande(){
															
	$.getJSON('controllers/accueil/getFriends.php',function(json){
	
			var msgajx = '';
			for( var x in json ) {
				var ligne = json[x];
				msgajx += ligne.nbr;
			}
			$('#demandes').html(msgajx);
	});
	timerDemande = setTimeout(function(){ refreshDemande(); }, 100000);
}
// Refresh et affiche le nombre de nouveaux messages
function refreshNbrMsg(){
															
	$.getJSON('controllers/accueil/getNbrMessages.php',function(json){
			
			var msgajx = '';
			for( var x in json ) {
				var ligne = json[x];
				msgajx += ligne.nbr;
			}
			$('#messages').html(msgajx);
	});
	timerNbrMessages = setTimeout(function(){ refreshNbrMsg(); }, 30000);
}
*/

var msgajax, id, idd;
var tab, ligne = new Array();

// le main
refreshGet();

//$("#sendMessage").on('click', function(){
$( "body" ).on( "click", "#sendMessage",function(){

	//alert('ok');
	var messaGe = $('#boxMessage').val();
	if(messaGe!=''){
		jQuery.ajax({
			type: 'POST',
			url:  'controllers/accueil/poster.php',
			data: { dest: id, msg: messaGe }, 
			success: function(data) {
				if(data=='ok'){ 						
					//alert(data +' ok');
					tmer += '<div class="amessage"><img src="images/man.jpg" alt="" /><div class="amgcont"><div class="amesshead"><h3>Zinedine Zidane</h3><a> à l\'instant</a><a>En ligne</a></div><p class="inpros">'+ messaGe +'</p></div></div>';			
					$('#boxMessage').val('');
					$("#tmer").empty().html(tmer);
				}
			}
		});
	}
	return false;
});

$('#con').on('click',function(){
	suppr(timermsg);
});	

$("#miss").one('click',function(){
//$( "body" ).one( "click", "#miss",function(){

	if(timermsg !='') suppr(timermsg); timermsg='';
	refreshlistmsg();
});

// récupérer le message grace a l'id
function getget(id, handle){
				
	$( "body" ).on( "click", "#msg"+id, function(){
				
		if(timer !=''){ suppr(timer); timer=''; }
					
		$("#allmessage").css('display','block');
		$("#message").css('display','block');
		$("#allcontact").css('display','none');
		$("#enligne").css('display','none');
		$("#demande").css('display','none');
		$("#visite").css('display','none');
		$("#profil").css('display','none');
		refreshmsg(id, handle);
	});		
}

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}
