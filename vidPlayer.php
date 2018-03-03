<?php
$donnees=json_decode ($_POST['element'],true);

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

}
else
{
	$largeur=LARGEUR_AFFICHAGE;
	$hauteur=HAUTEUR_AFFICHAGE;
	$largeurecran = LARGEUR_ECRAN ;
	$hauteurecran = HAUTEUR_ECRAN ;
	$decx    = $largeurecran - $largeur;
	$decy    = $hauteurecran - $hauteur;
	$ratio=1;
}
$taillePolice=round($ratio*60);
if(file_exists('logo/logo.png'))
{
   echo '<div style="display:block; z-index:2; width:150px; position:absolute; top:10px; left:10px; text-align=center;"><img src="logo/logo.png" style="width:150px"></div>';
}

if(isset($donnees["BANDEAU_HAUT"]))
{
	echo '<div id="bandeau_haut" style="z-index:1; width:'.$largeur.'px; position:absolute; top:0px; left:0px; height:150px; background-color:rgba(0,0,0,0.5); vertical-align:top" >
    <p id="titre" style="width:100%; font-size:'.$taillePolice.'px; color:#FFFFFF; text-align:center; font-weight:bolder; font-family:Verdana, Arial, Helvetica, sans-serif; b">'.$donnees["TEXTE_HAUT"].'</p>
    </div>';
}

/*
echo '<video id="videoPlayer" src="VIDEOS/'.$donnees["FICHIER"].'" autoplay="true"  style="display:block; z-index:0; width:'.$largeur.'px; height:'.$hauteur.'px; vertical-align:middle;">
</video>';
*/


echo '<video id="videoPlayer"  autoplay="true"  style="display:block; z-index:0; width:'.$largeur.'px; height:'.$hauteur.'px; vertical-align:middle;">
</video>';


$file = "VIDEOS/".$donnees['FICHIER'];
//echo "/juggler/omxplayer-web-controls-php/getID3-1.9.14/demos/demo.browse.php?filename=".  $file;
  
/// ATTENTION DEVELOPPEMENT EN COURS

    require_once 'juggler/omxplayer-web-controls-php/cfg.php';
    exec('pgrep omxplayer', $pids);  //omxplayer	
    

	//if ( empty($pids) ) {
	   @unlink (FIFO);
	   posix_mkfifo(FIFO, 0777);
	   chmod(FIFO, 0777);
	   
	   
	
	   $cmd = "juggler/omxplayer-web-controls-php/omx_php.sh  --win \"$largeur $hauteur	 $largeurecran $hauteurecran\" ".escapeshellarg($file)  ;
	   
	  $output =   shell_exec( $cmd );
    
	// } else {
	     	$err = 'omxplayer is already runnning';
	//  }
   

//// FIN DEV EN COURS	    
	    
	    
	    
if(isset($donnees["BANDEAU_BAS"]))
{
	echo'<div id="bandeau_bas" style="z-index:1; width:'.$largeur.'px; position:absolute; bottom:0px; left:0px; height:150px; background-color:rgba(0,0,0,0.5); vertical-align:middle" >
<p id="texte_bas" style="width:100%; font-size:'.$taillePolice.'px; color:#FFFFFF; text-align:center; font-weight:bolder; font-family:Verdana, Arial, Helvetica, sans-serif; b">'.$donnees["TEXTE_BAS"].'</p>
</div>';
}

echo '<script type="text/javascript">

document.getElementById("videoPlayer").addEventListener("ended",next);
</script>';



?>
