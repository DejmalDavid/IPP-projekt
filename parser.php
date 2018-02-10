<?php

//Zpraovani paramatru
$param_help_text="Ahoj jsem paramtert help!"; //TODO
// TODO exit nebo return ???


if( $argv[1] == "--help")
{
	if($argc == 2)
	{
		print ($param_help_text);
		exit (0);
	}
 	else 
	{
		exit (10); 	
	}
}
	$token="";
	print("ctu");
	$char=fgetc(STDIN);
	while(($char!=PHP_EOL) || ($char!=' '));
	{
		$token=$token+$char;
		$char=fgetc(STDIN);	
	}
	print($token);
	exit(0);
?>







