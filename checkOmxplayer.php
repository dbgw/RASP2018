<?php
	//vérification omxplayer is not running
	
    exec('pgrep omxplayer', $pids);  //omxplayer
	if ( empty($pids) ) {
	    echo 'non'; 
	} else {
	    echo 'oui';
	}
	
	
?>
