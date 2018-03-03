<?php
$filename = "/var/www/html/affichagecron.txt";
if (file_exists($filename)) {
  $handle = fopen($filename, "r");
  $contents = fread($handle, filesize($filename));
  fclose($handle);
  $a = trim($contents) ;
  echo  " valeur lu dans le fichier /var/www/html/affichagecron.txt :". $a;
  chmod($filename, 0777);  //changed to add the zero  
  $handle = fopen($filename, "w");
  fwrite($handle,       "0");
  fclose($handle);
  echo "\naiguillage rearmé à zero.";
  if ($a == "1" )
    {
//       shell_exec ("sudo reboot");
       shell_exec ("sudo service lightdm stop");
       shell_exec (" ps aux  |  grep -i omxp  |  awk '{print $2}'  |  xargs sudo kill -9");
       shell_exec("sudo service lightdm start");

       echo "\n REBOOT DEMANDE";
   }
} else {
    echo "\npas de commande pour le moment.";
}
?>
