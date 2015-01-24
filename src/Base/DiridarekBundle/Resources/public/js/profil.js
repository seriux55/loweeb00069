function bascule(elem){

    etat=document.getElementById(elem).style.display;
    if(etat=="none"){
   		document.getElementById(elem).style.display="block";
    }
    else{
   		document.getElementById(elem).style.display="none";
    }
}


$(function(){
	
	// prénom obligatoire
	$("#infossM").on('click', function(){
	
		if($("#prenom").val() == ""){
			//alert($("#prenom").val());
			$("#prenom").css("border","1px solid #FF0000");
			return false;		
		}
	});
	
	// affiche le detail pour signaler
	$(".adc").on('click', function(){
		smi = this.id;
		if(smi != 'photo inapproprié'){ 
			$("#seconde_report").slideDown();
			$("#third_report").slideDown();
		}else{
			$("#seconde_report").slideUp();
			$("#third_report").slideDown();
		}
		$("#azi").val(smi);
	});
	// submiter le signal report avec un merci
	$("#signa").on('click', function(){
		$("#signo").slideUp();
		$("#merSign").show();
		//alert($("#azi").val());
		
		// envoi du formulaire
		var textin = $("#textin").val();
		if(textin=="Exprimez vous") textin = "";
		$.ajax({
			type: 	 "POST",
   			url: 	 "../controllers/profil/signaler.php",
   			data: 	 { receive: gett,type: smi,report: textin },
   			success: function(msg){
    			//alert( smi + ' && ' + textin );
   			}
		});
		
	});
	
	
	// affiche le detail pour commenter
	$(".adb").on('click', function(){
		smo = this.id;
		$("#seconde_comment").slideDown();
		$("#third_comment").slideDown();
		$("#aze").val(smo);
	});	
	// submiter le commentaire avec un merci
	$("#publi").on('click', function(){
		var texti = $("#texti").val();
		//alert(texti);
		if(texti!="" && texti!="Donnez votre avis sur ce profil"){
			$("#commoo").slideUp();
			$("#merComm").show();
			//alert($("#aze").val());
			smo  = $("#aze").val();
			smoo = smo.substr(5); 
			// envoi du formulaire
			
			$.ajax({
				type: 	 "POST",
   				url: 	 "../controllers/profil/commentaire.php",
   				data: 	 { receive: gett,smily: smoo,comment: texti },
   				success: function(msg){
    				//alert( smo + ' && ' + texti );
   				}
			});
			
		}else{
			$("#texti").css("border","1px solid #FF0000");
		}
	});
	
	$("#cbon").on("click", function(){
	
		$("#azr").slideUp();
	});
	
	$("#cbonne").on("click", function(){
	
		$("#azz").slideUp();
	});
	
	
	/*
	$("#smily2").on('click', function(){
		smo = "2";
		$("#seconde_comment").slideDown();
		
		// submiter le commentaire avec un merci
		$("#publi").on('click', function(){
			if($("#texti").val()!=""){
				$("#commoo").slideUp();
				$("#merComm").show();
				alert(smo);
			}else{
				$("#texti").css("border","1px solid #FF0000");
			}
		});
	});
	$("#smily3").on('click', function(){
		smo = "3";
		$("#seconde_comment").slideDown();
		
		// submiter le commentaire avec un merci
		$("#publi").on('click', function(){
			if($("#texti").val()!=""){
				$("#commoo").slideUp();
				$("#merComm").show();
				alert(smo);
			}else{
				$("#texti").css("border","1px solid #FF0000");
			}
		});
	});	
	*/

	

	
	/*
	//alert('ok');
	$("#infosM").on('click', function(){
		//alert('ok');
		nom       = $("#nom").val();
		prenom    = $("#prenom").val();
		naissance = $("#naissance").val();
		//alert(nom+' '+prenom+' '+naissance);
		$.ajax({
			type:     'POST',
			url:      '../controllers/profil/info.php',
			data:     {nom: nom, prenom: prenom, naissance: naissance},
			success:  function() {
				//window.location = "http://www.diridarek.com/view/profil.php";
			}
		});
		//alert('ok');
		$("#infos").hide();
	});

	$("#infossM").on('click', function(){
		villeA = $("#villeA").val();
		villeB = $("#villeB").val();
		func   = $("#func").val();
		$.ajax({
			type:     'POST',
			url:      '../controllers/profil/information.php',
			data:     {villeA: villeA, villeB: villeB, func: func},
			success:  function() {
				//window.location = "http://www.diridarek.com/view/profil.php";
			}
		});
		$("#infoss").hide();
	});	
	
	$("#statutM").on('click', function(){
		statut   = $("#stt").val();
		$.ajax({
			type:     'POST',
			url:      '../controllers/profil/statut.php',
			data:     { statut: statut },
			success:  function() {
				//window.location = "http://www.diridarek.com/view/profil.php";
			}
		});
		$("#statut").hide();
	});	
	
	
	
	$("#tofPM").on('click', function(){
		//alert('ok');
		$("#tofP").hide();
	});
	$("#picM").on('click', function(){
		//alert('ok');
		$("#tofC").hide();
	});	
	*/





/*	
	$(document).keypress(function(e) {
    	//alert('ok');
    	if(e.which == 27) {
        	//alert('You pressed enter!');
        	$("#infos").hide();
        	$("#infoss").hide();
        	$("#statut").hide();
        	$("#tofP").hide();
        	$("#tofC").hide();
    	}
	});
*/

});