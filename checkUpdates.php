<?php
	//vérification des paramètres réseau
	if(file_exists('config/config_reseau.php'))
	{
		//si le fichier de configuration de réseau existe le charger
		include('config/config_reseau.php');
	}

	//vérification des paramètres serveurs
	if(file_exists('config/config_serveur.php'))
	{
		include('config/config_serveur.php');
	}
          
          
	//$urlDist='MAJ '.NOM_PLAYER;

  $urlDist= NOM_ETABLISSEMENT .'/MAJ '.NOM_PLAYER;
  //echo $urlDist;
	$url='ftp://'.LOGIN_FTP1.':'.PASS_FTP1.'@'.ADRESSE_FTP1.'/'.$urlDist;
  file_put_contents('logs/trace_player_final.log',"\n CHECKUPDATE:".$url ,FILE_APPEND);
	if(file_exists($url))
	{
		$conn=ftp_connect(ADRESSE_FTP1);
		$login_result=ftp_login($conn,LOGIN_FTP1,PASS_FTP1);
    
		if(ftp_delete($conn,$urlDist))
		{
		
     // $output = exec('php denis.php');
     //  echo (".RETOUR SUDO.".$output);
     echo 'oui';  
     file_put_contents('logs/trace_player_final.log',"\n UPDATE A FAIRE:".$url ,FILE_APPEND);
     $filename = "/var/www/html/affichagecron.txt";
     chmod($filename, 0777);  //changed to add the zero  
     $handle = fopen($filename, "w");
     fwrite($handle,	"1");
     fclose($handle);
     file_put_contents('logs/trace_player_final.log',"\n restart_final.php Aiguillage à 1 dans:".$filename ,FILE_APPEND);     
     
		}
		else
		{
     
			echo 'non';
		}
		
		ftp_close($conn);
	}
	else
	{ 
		echo 'non';
	}
