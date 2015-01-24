// Refresh et affiche la liste des messages 
function refreshlistmsg1(){
          
            timermsg++;
            alert(timermsg);
            if(timermsg>=2){ timermsg = 1; setTimeout("refreshlistmsg2()",20000); } //else refreshlistmsg1();

}
function refreshlistmsg2(){

			timermsg++;
            alert('oki');
            if(timermsg>=2){ timermsg = 1; setTimeout("refreshlistmsg1()",20000); } //else refreshlistmsg2();

}
var timermsg = 1;
setTimeout("refreshlistmsg1()",20000);