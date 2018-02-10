<?php

//Zpraovani paramatru
$param_help_text="Ahoj jsem paramtert help!"; //TODO
// TODO exit nebo return ???

if( $argv[1] == "--help")
{
	if($argc == 2)
	{
		print ($param_help_text);
		exit (15);
	}
	exit (1); 	//TODO
}

?>







