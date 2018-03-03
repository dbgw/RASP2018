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
  
   	include('config/config_reseau.php');

	//infos connexion
	
	if($servFtp =="FTP1")
	{
    //DBG 08/2017 
    if (NOM_ETABLISSEMENT != "")
		   $serv = ADRESSE_FTP1 ;//. "/" .NOM_ETABLISSEMENT;
    else
       $serv = ADRESSE_FTP1;
    file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : Serveur FTP1 "'.$serv.'"" est le serveur distant ;'."\n",FILE_APPEND);  
		$login = LOGIN_FTP1;
		$pass = PASS_FTP1;

   	$url='ftp://'.$login.':'.$pass.'@'.$serv.'/'.NOM_ETABLISSEMENT.'/'.$urlDist;
	}
	else
	{
		$serv = ADRESSE_FTP2;
		$login = LOGIN_FTP2;
		$pass = PASS_FTP2;
    $url='ftp://'.$login.':'.$pass.'@'.$serv.'/'.$urlDist;
     file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : Serveur FTP2 "'.$serv.'"" est le serveur distant ;'."\n",FILE_APPEND);  
	}



	
	if(file_exists($url))
	{
		if(file_exists($urlLocale))
		{
			$t = "<br>(downElement T1)Le fichier  distant déja présent distant sur le Rasp(FTP):  ".$serv.'/'.$urlDist." :".$urlLocale;
		  file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time."-".$t."\n",FILE_APPEND);	
     
		}
		else
		{       
    	    $t =  "<br>(downElement T2)Le fichier distant  est à télécharger :  ".$serv.'/'.$urlDist." :".$urlLocale;
          file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time."-".$t."\n",FILE_APPEND);
					echo 'tel;'.$servFtp.";".$urlLocale.";".$urlDist.";";
        
			/*  les lignes entre la xox46 et xox60 etait prealabelemtn commenté au 31052017*/
            
            echo '<font color=aqua>'.$urlLocale.' à télécharger</font><br>';
            file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : ftp_connect sur SERV  en cours ;'.$serv ,FILE_APPEND);
            $conn = ftp_connect($serv);
            if($conn!=FALSE)
            {
                
              
                   
                
                
                file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : Connection reussie ftp_connect sur SERV ;'.$serv.":",FILE_APPEND);
                
                if(@ftp_login($conn,$login,$pass))
                {
                    file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : login password reussie sur SERV ;'.$serv ,FILE_APPEND);
                    ftp_pasv($conn, true);
                  
                    if (NOM_ETABLISSEMENT != ""  && (	$serv == ADRESSE_FTP1) ) 
                    
                    {
                     if (ftp_chdir ( $conn ,NOM_ETABLISSEMENT ))
                      {
                        file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : Changement repertoire OK ;'.NOM_ETABLISSEMENT ,FILE_APPEND);
                        file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' :  repertoire COURANT;'.NOM_ETABLISSEMENT ,FILE_APPEND)  ;
                         }
                     else
                      {
                        file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : Changement repertoire IMPOSSIBLE'.NOM_ETABLISSEMENT ,FILE_APPEND);
                        file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' :  repertoire COURANT inconnu;'.NOM_ETABLISSEMENT ,FILE_APPEND) ;
                       }  
                    }
                    file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : Settimemlimit 0 FTPGET; locale '.$urlLocale."dist".$urlDist ,FILE_APPEND) ;
                    set_time_limit(0);
                    if (ftp_get($conn,$urlLocale,$urlDist, FTP_BINARY)) 
                    {
                       $res = $time.'<font color=blue>FTP GET OK'.$urlLocale.' téléchargé</font><br>';
                    }
                    else
                    { 
                       $res =  $time.'<font color=RED>FTP GET  A ECHOUE Login '.$login. "pass".$pass.' </font><br>';
                    }
                    ftp_close($conn);
                    file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : '.$urlLocale. $res .";",FILE_APPEND);
                }
                else
                  file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : login password ECHOUE sur SERV ;'.$serv ,FILE_APPEND);
                  
            }
            else
            {
                   $res = "FPT_CONNECT A ECHOUE SUR LE SERVEUR ".$serv  ;
                   file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time.' : '. $res .";",FILE_APPEND);
            }
            //xox60//xox46
			
			
		}
	
		
	}
	else
	{
		$t  =  '<br>(downElement T3)<font color=red>Le fichier distant ( FTP) :'.$serv.'/'.$urlDist.' n\'existe pas<br>';
		file_put_contents('logs/'.date('Ymd').'_downloads.log',"\n".$time."-".$t,FILE_APPEND);
   
	}
  //echo $t.";";
  echo ".";
?>
