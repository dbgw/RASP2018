<?php
$servFtp=$_POST['FTP'];
$urlDist=$_POST['urlDist'];
$urlLocale=$_POST['urlLocale'];
$time = date('Y-m-d : H-i-s');

	//vérification des paramètres serveurs
	if(file_exists('config/config_serveur.php'))
	{
		include('config/config_serveur.php');
	}
	else
	{
		echo 'Le fichier serveur n\'existe pas<br>';
	}

	//infos connexion
	
	if($servFtp =="FTP1")
	{
		$serv = ADRESSE_FTP1;
		$login = LOGIN_FTP1;
		$pass = PASS_FTP1;
	
	}
	else
	{
		$serv = ADRESSE_FTP2;
		$login = LOGIN_FTP2;
		$pass = PASS_FTP2;
	}

	$conn = ftp_connect($serv);
			if($conn!=FALSE)
			{
				if(@ftp_login($conn,$login,$pass))
				{
					ftp_pasv($conn, true);
					set_time_limit(0);
					ftp_get($conn,$urlLocale,$urlDist, FTP_BINARY);	
					echo '<font color=blue>'.$urlLocale.' téléchargé vers '. $urlDist .' </font><br>';
					file_put_contents('logs/'.date('Ymd').'_downloads.log',$time.' : '.$urlLocale.' téléchargé ;'."\n",FILE_APPEND);
				}
			}
					ftp_close($conn);


?>