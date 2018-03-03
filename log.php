<?php
$donnees=json_decode ($_POST['element'],true);
if ($donnees["TYPE"]=='VID' || $donnees["TYPE"]=='AUT_VID')
	{
		$dir='VIDEOS';
	}
elseif ($donnees["TYPE"]=='IMA' || $donnees["TYPE"]=='AUT_IMA')
	{
		$dir='img';
	}
else
	{
	$dir='test';
	}
$time = date('Y-m-d : H-i-s');
$nom = $dir.'/'.$donnees["FICHIER"];


if(file_exists($nom))
	{
		file_put_contents('logs/'.date('Ymd').'_diffusion.log',"\n".$time.' : '.$dir.'/'.$donnees["FICHIER"].';',FILE_APPEND);
	}
else
	{
		file_put_contents('logs/'.date('Ymd').'_erreurs.log',"\n".$time.' : '.$dir.'/'.$donnees["FICHIER"].' manquant ;',FILE_APPEND);
	}
?>