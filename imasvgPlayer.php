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
      
echo '<div style="position: absolute;top:0 ;"> <span style="display:table-cell; width:'.$largeurecran.'px; height:'.$hauteurecran.'px; vertical-align:middle; text-align:center">
		<img id="affImage" src="img/'.$donnees["FICHIER"].'" style="height:'.$hauteurecran.'px; width:'.$largeurecran.'px; object-fit: contain;">
	</span></div>';
  
  echo '<div style="position: absolute;top:0 ;"> 
		<img id="affImage" src="img/'.$donnees["FICHIER"].'" style="height:'.$hauteurecran.'px; width:'.$largeurecran.'px; object-fit: contain;">
	</div>';

?>
