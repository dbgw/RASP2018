<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
</head>
<body>
<?php

if(isset($_POST['hauteurEcran']))
{
	echo 'Enregistrement config';
	$hauteurEcran      = $_POST["hauteurEcran"];
	$largeurEcran      = $_POST["largeurEcran"];
	$hauteurAffichage  = $_POST["hauteurAffichage"];
	$largeurAffichage  = $_POST["largeurAffichage"];
	$rotationAffichage = $_POST["rotationAffichage"];
	$sconfig = "
		<?php
				define('HAUTEUR_ECRAN'    ,$hauteurEcran); //1080
				define('LARGEUR_ECRAN'    ,$largeurEcran);//1920
				define('HAUTEUR_AFFICHAGE',	$hauteurAffichage );//1060
				define('LARGEUR_AFFICHAGE',$largeurAffichage);//1904000
				define('ROTATION_AFFICHAGE',$rotationAffichage);
				define('PLAYER_ID','play_578397bcad69b');
				?>";
	file_put_contents('config_affichage.php',$sconfig);
	
}
	if (file_exists('config_affichage.php'))
	{
		//si déjà configuré chargement des paramètres
		include('config_affichage.php');
	}

?>
<h1>  PARAMETRAGE ECRAN </h1>
<table> 
<form id="form1" name="form1" method="post" action="">
  <tr><td>
  Hauteur Ecran
  </td><td>
  <input type="text" name="hauteurEcran" id="hauteurEcran" value="<?php echo HAUTEUR_ECRAN ; ?>" />
  </td></tr>
  
  <tr><td>
  Largeur Ecran
  </td>
  <td>
  <input type="text" name="largeurEcran" id="largeurEcran"  value="<?php echo LARGEUR_ECRAN ; ?>"/>
  </td>
  </tr>
  
  
  <tr><td>
    Hauteur Affichage
  </td>
  <td>
  <input type="text" name="hauteurAffichage" id="hauteurAffichage"  value="<?php echo HAUTEUR_AFFICHAGE ; ?>" />
  </td>
  </tr>
  
  <tr>
  <td>
  Largeur Affichage
  </td>
  <td>
  <input type="text" name="largeurAffichage" id="largeurAffichage"  value="<?php echo LARGEUR_AFFICHAGE ; ?>"/>
  </td>
  </tr>
  
  <tr><td> 
	  Rotation Affichage
  </td>
  <td>
  <input type="text" name="rotationAffichage" id="rotationAffichage"   value="<?php echo ROTATION_AFFICHAGE ; ?>"/>
  </td>
  </tr>
  <tr><td>
  <button> Enregistrer</button></td>
  <td>
  <a href="/player_final.php">Redemarrer</a>
  </td></tr>
</form>
	</table>
</body>
</html>
