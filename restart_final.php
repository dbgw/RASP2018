<?php
	//v�rification des param�tres r�seau
	if(file_exists('config/config_reseau.php'))
	{
		//si le fichier de configuration de r�seau existe le charger
		include('config/config_reseau.php');
	}

	//v�rification des param�tres serveurs
	if(file_exists('config/config_serveur.php'))
	{
		include('config/config_serveur.php');
	}
          

  $filename = "/var/www/html/affichagecron.txt";
  chmod($filename, 0777);  //changed to add the zero  
  $handle = fopen($filename, "w");
  fwrite($handle,	"1");
  fclose($handle);
  file_put_contents('logs/trace_player_final.log',"\n restart_final.php Aiguillage � 1 dans:".$filename ,FILE_APPEND);
 
 
  
           
