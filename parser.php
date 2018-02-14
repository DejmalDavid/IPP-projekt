<?php

//Zpraovani paramatru
$param_help_text="Ahoj jsem paramtert help!"; //TODO
// TODO exit nebo return ???

$STDIN = fopen("input.txt", "r");
$citac_poradi=0;

class Tokeny{
    public $text;
    public $poradi;
}

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
            global $STDIN,$citac_poradi;
            $znak=fgetc($STDIN);
            $char=ord($znak);
            while ($znak !== FALSE)
            {
                if(($char == 10) || ($char == 9) || ($char == 32)|| ($char == 13))
                {
                    while(($char == 10) || ($char == 9) || ($char == 32)|| ($char == 13))
                    {
                        $znak=fgetc($STDIN);
                        $char=ord($znak);
                        //printf("ASCII:%d \n",$char);
                        if(($char == 10)|| ($char == 13)) 
                        {
                           $citac_poradi=0;
                        }
                    }
                }
                while( $char == 35)
                {
                    while(($char != 10))
                    {
                       // print ($char);
                        $znak=fgetc($STDIN);
                        $char=ord($znak);
                    }
                    if($char == 13)
                    {
                       $znak=fgetc($STDIN); 
                    }
                    $znak=fgetc($STDIN);
                    $char=ord($znak);
                    $citac_poradi=0;
                }
                $token="";
                while(($char != 10) && ($char!=32) && ($char != 13) && ($znak !== FALSE))
                { 
                   // printf("ASCII:%d \n",$char);
                    $token=$token.$znak;
                    $znak=fgetc($STDIN);
                    $char=ord($znak); 
                }
                
                if(($char == 10)|| ($char == 13)) 
                {
                   $citac_poradi=0;
                }
                
                return $token;
            }
            return "KONEC";
        }
  
    
        for(  $i=0 ; $i< 12; $i++)
        {
            $slovo = new Tokeny();
            $slovo->text = Get_token();
            $slovo->poradi = $citac_poradi;
            $citac_poradi++;
   

            printf("%s p:%d\n",$slovo->text,$slovo->poradi);       
        }
        
        //TODO pokayde volat ord($char) a podminka konce je FALSE === $char
        /*
    $char=fgetc($STDIN);
    printf("CODE : %d",$char);
    if($char == 13)
    {
        print("enter");
    }
    print("\n");
    $char=ord($char);
    print($char);
        */
	exit(0);
?>







