<?php

//Zpraovani paramatru
$param_help_text="Ahoj jsem paramtert help!"; //TODO
// TODO exit nebo return ???

$STDIN = fopen("input.txt", "r");
$a=5;
/*
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
}*/
 function Get_token()
        {
            global $STDIN;
            $char=fgetc($STDIN);
            while ($char != 'q')
            {
                if(($char == " ") || ($char == "\t"))
                {
                    while(($char == " ") || ($char == "\t"))
                    {
                      $char=fgetc($STDIN); 
                    }
                }
                $token="";
                while(($char != PHP_EOL) && ($char!=' '))
                { 
                    $token=$token.$char;
                    $char=fgetc($STDIN);
                }
                return $token;
            }
            return "KONEC";
        }
        for(  $i=0 ; $i< 4 ; $i++)
        {
            $slovo = Get_token();
            print($slovo);
            print ("\n");
        }
 
    
        
       




	exit(0);
?>







