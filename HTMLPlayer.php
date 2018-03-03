<?php
//$donnees=json_decode ($_POST['element'],true);


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
$current = '<iframe src="FICHIERS HTML/'.$_POST['url'].'" width="'.$largeurecran.'px" height="'.$hauteurecran.'px" frameborder="0"></iframe>';
$file = 'trace2017.txt';
   // Écrit le résultat dans le fichier
   file_put_contents($file, "html processes;");   
  echo '<iframe  src="FICHIERS HTML/'.$_POST['url'].'" width="'.$largeurecran.'px" height="'.$hauteurecran.'px" frameborder="0"></iframe>';
?>