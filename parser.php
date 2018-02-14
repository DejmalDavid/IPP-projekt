<?php


$param_help_text="Ahoj jsem paramtert help!"; //TODO
// TODO exit nebo return ???

//Globalni promene 
$STDIN = fopen("input2.txt", "r");
$citac_poradi=0;
$nuluj_citac=FALSE;

//simulace struktury tokeny
class Tokeny{
    public $text;
    public $poradi;
}

//Zpraovani paramatru
if($argc == 2)
{
	if( $argv[1] == "--help")
	{
		print ($param_help_text);
		exit (0);
	}
}
elseif ($argc > 2) {
    exit(42);
}



// Vraci string tokenu a nastavuje globalni promenou citac_poradi
 function Get_token()
        {
            global $STDIN,$citac_poradi,$nuluj_citac;
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
                if($nuluj_citac== TRUE)
                {
                    $nuluj_citac=FAlSE;
                    $citac_poradi=0;
                }
                if(($char == 10)|| ($char == 13)) 
                {
                   $nuluj_citac=TRUE;
                }
                $citac_poradi++;
                return $token;
            }
            return "KONEC";
        }
  
    
       for(  $i=0 ; $i< 50; $i++)
        {
            $slovo = new Tokeny();
            $slovo->text = Get_token();
            $slovo->poradi = $citac_poradi;
            
   

            printf("%s p:%d\n",$slovo->text,$slovo->poradi);       
        }
       
        /*
            $slovo1 = new Tokeny();
            $slovo1->text = Get_token();
            $slovo1->poradi = $citac_poradi;
            printf("%s p:%d\n",$slovo1->text,$slovo1->poradi); 
        
                        $slovo9 = new Tokeny();
            $slovo9->text = Get_token();
            $slovo9->poradi = $citac_poradi;
            printf("%s p:%d\n",$slovo9->text,$slovo9->poradi);
                        $slovo2 = new Tokeny();
            $slovo2->text = Get_token();
            $slovo2->poradi = $citac_poradi;
            printf("%s p:%d\n",$slovo2->text,$slovo2->poradi);
                        $slovo3 = new Tokeny();
            $slovo3->text = Get_token();
            $slovo3->poradi = $citac_poradi;
            printf("%s p:%d\n",$slovo3->text,$slovo3->poradi);
                        $slovo4 = new Tokeny();
            $slovo4->text = Get_token();
            $slovo4->poradi = $citac_poradi;
            printf("%s p:%d\n",$slovo4->text,$slovo4->poradi);
                        $slovo5 = new Tokeny();
            $slovo5->text = Get_token();
            $slovo5->poradi = $citac_poradi;
            printf("%s p:%d\n",$slovo5->text,$slovo5->poradi);
                        $slovo6 = new Tokeny();
            $slovo6->text = Get_token();
            $slovo6->poradi = $citac_poradi;
            printf("%s p:%d\n",$slovo6->text,$slovo6->poradi);
                                 $slovo7 = new Tokeny();
            $slovo7->text = Get_token();
            $slovo7->poradi = $citac_poradi;
            printf("%s p:%d\n",$slovo7->text,$slovo7->poradi);
                                             $slovo8 = new Tokeny();
            $slovo8->text = Get_token();
            $slovo8->poradi = $citac_poradi;
            printf("%s p:%d\n",$slovo8->text,$slovo8->poradi);
        */
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







