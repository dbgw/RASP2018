<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php   
die ("jedi");
$test = false;
	if(file_exists('config/config_reseau.php'))
	{
		//si le fichier de configuration de réseau existe le charger
		include('config/config_reseau.php');
	}
	
	if (file_exists('config/config_affichage.php'))
	{
		//si déjà configuré chargement des paramètres
		include('config/config_affichage.php');
	}

  if (ROTATION_AFFICHAGE!=1)
{
	$largeur = HAUTEUR_AFFICHAGE;
	$hauteur = LARGEUR_AFFICHAGE;
	$ratio   = HAUTEUR_AFFICHAGE/LARGEUR_AFFICHAGE;
	$largeurecran = HAUTEUR_ECRAN ;
	$decy    = $largeurecran - $largeur;
	$hauteurecran = LARGEUR_ECRAN ;
	$decx    = $hauteurecran - $hauteur;
  $left =    HAUTEUR_AFFICHAGE;
  $top =   LARGEUR_AFFICHAGE;
}
else
{
// affichage TV
	$largeur=LARGEUR_AFFICHAGE;
	$hauteur=HAUTEUR_AFFICHAGE;
	$largeurecran = LARGEUR_ECRAN ;
	$hauteurecran = HAUTEUR_ECRAN ;
	$decx    = $largeurecran - $largeur;
	$decy    = $hauteurecran - $hauteur;
	$ratio=1;
  $top =    HAUTEUR_AFFICHAGE;
  $left =   LARGEUR_AFFICHAGE;
}

	
?>
<title><?php echo NOM_PLAYER; ?></title>
<style type="text/css">
<!--
body {
	background-color: #000000;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	overflow-x: hidden;
	overflow-y: hidden;
}
body,td,th {
	color: #FFFFFF;
}
-->
</style></head>

<body>
<script type="text/javascript">
<?php
if(!isset($_GET["index"]))
{
	echo 'var index=-1;';
}
else
{
	echo 'var index='.$_GET["index"];
}
?>
  
function checkOmxplayer()
{
	return false;
	console.log ( "checkOmxplayer()JS");
	var xhrUp=getXhr();
	
		xhrUp.onreadystatechange = function(){
		
			if(xhrUp.readyState == 4 && xhrUp.status == 200){
			   
				var str=xhrUp.responseText;
					if(str=='oui')
					{
					 return true;
					}
			}
		}
    console.log ( "checkOmxplayer.php");
	xhrUp.open("POST","checkOmxplayer.php",true);
	xhrUp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xhrUp.send();
}


function nextPage()
{
	
	 var adresse='player.php?index='+index;
	 document.location.href=adresse;
}

function next()
	{

		checkUpdate();

		if  (checkOmxplayer() == true)  {
		    alert ('omxplayer is running');
		    return;
		}	 	
		index++;
			if(index < obj.ELEMENT.length)
			{
			
					if(obj.ELEMENT[index].TYPE=='VID'||obj.ELEMENT[index].TYPE=='AUT_VID')
					{
						logElement(obj.ELEMENT[index]);
						playVid(obj.ELEMENT[index]);
					}
					else if(obj.ELEMENT[index].TYPE=='IMA'||obj.ELEMENT[index].TYPE=='AUT_IMA')
					{
						logElement(obj.ELEMENT[index]);
						playIma(obj.ELEMENT[index]);
 
					}
					else if(obj.ELEMENT[index].TYPE=='HTML')
					{
						playHTML(obj.ELEMENT[index]);
					}
					else
					{
					next();
					}
			}
			else
			{
				index=-1;
				next();
			}
	}

function checkUpdate()
{
	var xhrUp=getXhr();
		xhrUp.onreadystatechange = function(){
		
		
			if(xhrUp.readyState == 4 && xhrUp.status == 200){
				
				var str=xhrUp.responseText;
				//console.log ("onreadystatechange"+xhrUp.readyState+" "+str );
         // alert("checkupdate step2...."+ str+ "+++++");
   				if(str=='oui')
					{
             //alert(" http://127.0.0.1/player_final.php checkupdate step3 127.0.0.1/player_final.php"+ str);
               file_put_contents('logs/trace_player_final.log',"\n restart_final fonction lancée" ,FILE_APPEND);
               restart_final();
					}
			}
		}
    
	xhrUp.open("POST","checkUpdates.php",true);
	xhrUp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xhrUp.send();
}

function restart_final()
{
	var xhrUp=getXhr();
		xhrUp.onreadystatechange = function(){
		
		
			if(xhrUp.readyState == 4 && xhrUp.status == 200){
				 file_put_contents('logs/trace_player_final.log',"\n restart_final fonction ok 200 ou 4 " ,FILE_APPEND);
				var str=xhrUp.responseText;
				//alert("result restart"+ str+ "+++++");
        
			}
		}
           //window.location = "player_final.php";
	xhrUp.open("POST","restart_final.php",true);
	xhrUp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xhrUp.send();
}


function logElement(element)
	{
		var elementPost =JSON.stringify(element);
		var xhrLog=getXhr();
		xhrLog.onreadystatechange = function(){
		
			if(xhrLog.readyState == 4 && xhrLog.status == 200){
			
				var str=xhrLog.responseText;
			}
		}
	xhrLog.open("POST","log.php",true);
	xhrLog.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xhrLog.send("element="+elementPost);
		
	}	
	
function getXhr()
	{
		var xhr = null; 
		if(window.XMLHttpRequest) // Firefox et autres
	  	 xhr = new XMLHttpRequest(); 
			else if(window.ActiveXObject){ // Internet Explorer 
			   try {
		              xhr = new ActiveXObject("Msxml2.XMLHTTP");
		            } catch (e) {
		               xhr = new ActiveXObject("Microsoft.XMLHTTP");
					}
		}
		else { // XMLHttpRequest non supporté par le navigateur 
		   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
		   xhr = false; 
		} 
   	return xhr
	}
	
function playIma(element)
	{
		var elementPost =JSON.stringify(element);
		var xhrIma=getXhr();
    //alert("TRACEPLAYIMA"+elementPost);	
		xhrIma.onreadystatechange = function(){
		
			if(xhrIma.readyState == 4 && xhrIma.status == 200){
			
				var str=xhrIma.responseText;
				document.getElementById("player").innerHTML = str;
				var duree=element.DUREE*1000;	
				setTimeout(nextPage,duree);

			}
		}
	xhrIma.open("POST","imaPlayer.php",true);
	xhrIma.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xhrIma.send("element="+elementPost);
	
	}

function playHTML(element)
	{
		var elementPost =JSON.stringify(element);
    //alert("TRACEPLAYHTML"+elementPost);	
 
		var url = encodeURIComponent(element.FICHIER);
              
    
    var xhrHTML=getXhr();
		xhrHTML.onreadystatechange = function(){
		
			if(xhrHTML.readyState == 4 && xhrHTML.status == 200){
			
				var str=xhrHTML.responseText;
				document.getElementById("player").innerHTML = str;
				var duree=element.DUREE*1000;
          //20172407  
          if (duree < 0)  duree = - duree * 10000;
        
				setTimeout(nextPage,duree);

			}
		}
       
	xhrHTML.open("POST","HTMLPlayer.php",true);
	xhrHTML.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xhrHTML.send("url="+url);
 // alert("lacement du timer sur checkupdate player html");
    console.log("initCheckUpdate");
  var duree = 10 * 1000;	
  setInterval(checkUpdate,duree);
  
  
	
	}

function playVid(element)
	{
		
		var elementPost =JSON.stringify(element);
		//alert("TRACEPLAYVID"+elementPost);	
		var xhrVid=getXhr();
		xhrVid.onreadystatechange = function(){
		
			if(xhrVid.readyState == 4 && xhrVid.status == 200){
			
				var str=xhrVid.responseText;
				//alert("etat de vid a changer",str);	
				document.getElementById("player").innerHTML = str;	
				nextPage();
				document.getElementById("videoPlayer").addEventListener("ended",nextPage);

			}
		}
	xhrVid.open("POST","vidPlayer.php",true);
	xhrVid.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

	xhrVid.send("element="+elementPost);
	}
</script>

<div id="player" style="position:absolute;top:<?php echo $top; ?>px; left:<?php echo $left; ?>px; width:<?php echo $largeur; ?>px; height:<?php echo $hauteur; ?>px;<?php $rotation=0;echo $rotation; ?>"></div>
<?php

	//etude du contenu de la boucle
	
	//chargement des medias
	//$xmlFichiers = simplexml_load_file('LISTE_FICHIERS.XML');
	
	$btest = false;
	//definir la boucle en cours
	$boucleNow='';
	$boucles= scandir('BOUCLES');
	
	$heureNow =date('Hi');
	
	$vids = array();
	$aut_vids = array();
	$ima = array();
	$aut_ima = array();
	
  $waitingBoucle = "../WAITINGBOUCLE.XML";
  foreach($boucles as $var)
  {
  	if($var!='.' && $var!='..')
  	{
  		$tab = explode('_',$var);
      $tab4 = explode('.',  $tab[4]);
      $tab[4] = $tab4[0];
      // TRACE TEST
    file_put_contents('logs/trace_player_final.log',"/nBOUCLE:/".$var ,FILE_APPEND);
  
    if ($test) $boucleNow = $var;
    if ($btest) {
      echo "<br>trace de débugage BEFORE"."/n";
      echo  "<br>/ndate debut tab3 :".$tab[3] ;
      echo  "<br>/ndate fin   tab4 :".$tab[4] ;
      
      file_put_contents('logs/trace_player_final.log',"/ndate:/".var_export($tab, true) ,FILE_APPEND);
  
     }
    // rahjour du 02022018
    if ($tab[4]<$tab[3])  $tab[4] = $tab[4] + 2400;
    if ($btest) {
      echo "<br>AFTER date +2400 "."/n";
      echo  "<br>/n date debut tab3 :".$tab[3] ;
      echo  "<br>/n date fin   tab4 :".$tab[4] ;
      file_put_contents('logs/trace_player_final.log',"/ndate recalculée:/".var_export($tab, true) ,FILE_APPEND);

    }
    
  
    if($tab[3]<$heureNow && $tab[4]>$heureNow)
    {
    	$boucleNow = $var;
    }
    else 
      $boucleNow = $waitingBoucle;
    }
  }


  //charger le XML

	$xml=file_get_contents('BOUCLES/'.$boucleNow);
	$xml = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $xml); //réencodage des & en &amp;
	$xmlBoucle= simplexml_load_string($xml);
	$xmlBoucleJs=json_encode($xmlBoucle);
	if(count($xmlBoucle)==1)
	{
		$xmlBoucleJs=str_replace('"ELEMENT":{','"ELEMENT":[{',$xmlBoucleJs);
		$xmlBoucleJs=str_replace('}}','}]}',$xmlBoucleJs);
	}
	
?>
<script type="text/javascript">
var boucle =' <?php echo $xmlBoucleJs; ?>';
var obj = JSON.parse(boucle);
next();
</script>
</body>
</html>
