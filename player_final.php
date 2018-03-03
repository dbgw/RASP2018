<?php


//Fonctions php
	function downloadDir($dir,$conn)
	{

		set_time_limit(30) ;
	  ftp_pasv($conn, true);
    $btest = false;  
    
    // Tentative de modification du dossier en "NOM_ETABLISSEMENT"  14/08/2017
      if (	ftp_chdir($conn,$dir)) {
          $a =  "(downloaddir) Le dossier courant est maintenant : " . ftp_pwd($conn) . "\n";
          file_put_contents('logs/trace_player_final.log',$a ,FILE_APPEND);
          if ($btest) echo $a . "\n";
      } else { 
          echo "(downloaddir)Impossible de changer de dossier:".NOM_ETABLISSEMENT . "\n";
          file_put_contents('logs/trace_player_final.log',"\n".getDatetimeNow()."(downloaddir)Impossible de changer de dossier:".$dir ,FILE_APPEND);
          die("(downloaddir)FIN D EXECUTION ANORMALE");
      }        
 
   	$liste = ftp_rawlist($conn,'.');
    $a = var_export($liste, true);
    file_put_contents('logs/trace_player_final.log',"\n".getDatetimeNow()."(downloaddir rawlist)contenu de ftp_rawlist : ".$a ,FILE_APPEND);
    if ($btest) echo $a . "\n";
    $a = ftp_pwd($conn);
    file_put_contents('logs/trace_player_final.log',"\n".getDatetimeNow()."(downloaddir répertoire analysé)contenu de ftp_pwd : ".$a ,FILE_APPEND);
    $a =    substr(ftp_pwd($conn),1);
    if ($btest) echo $a . "\n";
    file_put_contents('logs/trace_player_final.log',"\n".getDatetimeNow()."(downloaddir rawlist)contenu de substr ftp_pwd : ".$a ,FILE_APPEND);
    // le directory local ne comprend le nom de l etablissement
    // supression du nom de letablissement
    $path = substr(ftp_pwd($conn),1);
    $path =  str_replace ( array (NOM_ETABLISSEMENT ."/" ), array("") ,  $path ) ;
			
			if(!is_dir($path))
			{
				mkdir($path,0777);
        $a =   $path;
        if ($btest) echo $a . "\n";
    
        file_put_contents('logs/trace_player_final.log',"\n".getDatetimeNow()."(downloaddir rawlist)creation du répertoire: ".$a ,FILE_APPEND);
  
			}
			foreach($liste as $var)
			{
				$val = explode(" ",$var);
				
				if(substr($var[0],0,1)=='d')
				{
					downloadDir($val[count($val)-1],$conn);
				
				}
				else
				{
					$remoteFile = $val[count($val)-1];
					
          //$localeFile =  substr(ftp_pwd($conn),1)."/".$val[count($val)-1];
		      
          $path = substr(ftp_pwd($conn),1);
          $path =  str_replace ( array (NOM_ETABLISSEMENT ."/" ), array("") ,  $path ) ;
		      $localeFile =  $path."/".$val[count($val)-1];
		
    		  ftp_get($conn,$localeFile,$remoteFile, FTP_BINARY);
          $a = "local file :". $localeFile .", remote file ".$remoteFile  ;
          if ($btest) echo $a . "\n";
    
         file_put_contents('logs/trace_player_final.log',"\n".getDatetimeNow()."(downloaddir rawlist)FGET DES FICHIERS: ".$a ,FILE_APPEND);
  
				}
			}
		ftp_chdir($conn,'..');
	}
	

	function rrmdir($src) {
		$dir = opendir($src);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				$full = $src . '/' . $file;
				if ( is_dir($full) ) {
					rrmdir($full);
				}
				else {
					@unlink($full);
				}
			}
		}
		closedir($dir);
		rmdir($src);
	}
  
   function getDatetimeNow() {
    $tz_object = new DateTimeZone('Brazil/East');
    //date_default_timezone_set('Brazil/East');

    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ h:i:s');
   }


// check configuration

		file_put_contents('logs/trace_player_final.log',"
		Lancement de playerfinal.php a l heure du fichier
    ");
	//verification de l'affichage
	if (file_exists('config/config_affichage.php'))
	{
		//si déjà configuré chargement des paramètres
		include('config/config_affichage.php');
	}
	else
	{
		//si non renvoi vers la page de configuration
		file_put_contents('config/config_affichage.php',"
		<?php
        define('HAUTEUR_ECRAN',540); //1080
        define('LARGEUR_ECRAN',960);//1920
        define('HAUTEUR_AFFICHAGE',530);//1060
        define('LARGEUR_AFFICHAGE',950);//1900
        define('ROTATION_AFFICHAGE',0);
        define('PLAYER_ID','play_578397bcad69b');
        ?>");
		include('config/config_affichage.php');
		echo 'Fichier affichage creer avec les valeurs par défaut.<br>';	
	}

	//vérification des paramètres réseau
	if(file_exists('config/config_reseau.php'))
	{
		//si le fichier de configuration de réseau existe le charger
		include('config/config_reseau.php');
	}
	else
	{
		//si non renvoi vers la page de configuration réseau
		echo 'Le fichier réseau existe pas.<br>';
		echo getHostByName(getHostName()).'<br>';
		echo getHostName().'<br>';
		//echo utf8_encode(shell_exec('ipconfig')).'<br>';
		
	}

	//vérification des paramètres serveurs
	if(file_exists('config/config_serveur.php'))
	{
		include('config/config_serveur.php');
	}
	else
	{
		echo 'Le fichier serveur n\'existe pas<br>';
	}

//recuperation des elements FTP1
$conn_FTP1 = ftp_connect(ADRESSE_FTP1);
$a = "tentative de connexion Player final".ADRESSE_FTP1 ;
file_put_contents('logs/trace_player_final.log',"\n".getDatetimeNow().$a ,FILE_APPEND);
	if($conn_FTP1!=FALSE)
	{
		if(@ftp_login($conn_FTP1,LOGIN_FTP1,PASS_FTP1))
		{
		
			ftp_pasv($conn_FTP1, true);
      
      // Tentative de modification du dossier en "NOM_ETABLISSEMENT"  14/08/2017
      if (ftp_chdir($conn_FTP1, NOM_ETABLISSEMENT)) {
          $a =  "Le dossier courant est maintenant : " . ftp_pwd($conn_FTP1) . "\n";
          file_put_contents('logs/trace_player_final.log',$a ,FILE_APPEND);
      } else { 
          echo "Impossible de changer de dossier:".NOM_ETABLISSEMENT . "\n";
          file_put_contents('logs/trace_player_final.log',"\n".getDatetimeNow()."Impossible de changer de dossier:".NOM_ETABLISSEMENT ,FILE_APPEND);
          die("FIN D EXECUTION ANORMALE");
      }        

				if(is_dir('FICHIERS HTML'))
				{
					rrmdir('FICHIERS HTML');
        
				}
        mkdir('FICHIERS HTML',0777);
        
			
			downloadDir('FICHIERS HTML',$conn_FTP1);
      
                         
                               
     
			$buff = ftp_nlist($conn_FTP1,"BOUCLES");
     
			$dateBoucle=date('dmY');
      file_put_contents('logs/trace_player_final.log',"/nBOUCLE RECHERCHEE".'BOUCLE_'.NOM_PLAYER.'_'.$dateBoucle     ,FILE_APPEND);
			foreach ($buff as $nomBoucle)
			{
				if(strrpos($nomBoucle,'BOUCLE_'.NOM_PLAYER.'_'.$dateBoucle)!==false)
				{
					ftp_get($conn_FTP1,'BOUCLES/'.$nomBoucle,'BOUCLES/'.$nomBoucle, FTP_BINARY);
        
					$boucleTelechargee=$nomBoucle;
					$listeBoucles=scandir('BOUCLES');
						foreach ($listeBoucles as $nomFile)
						{
            
							if($nomFile!=$nomBoucle && $nomFile!='.' && $nomFile!='..')
							{
                file_put_contents('logs/trace_player_final.log',"/nUNLINK:BOUCLES/".$nomFile ,FILE_APPEND);
								unlink('BOUCLES/'.$nomFile);
							}
						}
				}
			}
      
			
			ftp_get($conn_FTP1,'LISTE_FICHIERS.XML','LISTE_FICHIERS.XML',FTP_BINARY);
			ftp_get($conn_FTP1,'films_a_recuperer.xml','films_a_recuperer.xml',FTP_BINARY);    
   
		}
		else
		{
			echo 'login pass refusé';
      die( "login mot de passe erronés");
		}
	}
	else
	{
		echo 'echec de la connexion';
    //die( "connection en echec");
	}
	
	ftp_close($conn_FTP1);
	


 
	header('location: DownloadAjax.php');

?>
