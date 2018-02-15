<?php


$param_help_text="Ahoj jsem paramtert help!"; //TODO
// TODO exit nebo return ???

//Globalni promene 
$STDIN = fopen("input3 - kopie", "r");
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
            global $STDIN,$citac_poradi,$nuluj_citac;   //global promene
            $znak=fgetc($STDIN);    
            $char=ord($znak);
            while ($znak !== FALSE)     //konec souboru
            {
                if(($char <= 32))   // bile znaky
                {
                    while(($char <= 32) && ($znak !== FALSE) )      //precte vsechny bile znaky
                    {
                        $znak=fgetc($STDIN);
                        $char=ord($znak);
                       // printf("ASCII:%d \n",$char);  //help vypis
                        if(($char == 10)|| ($char == 13))   // byl tam EOL dalsi token bude prvni
                        {
                           $citac_poradi=0;
                        }
                    }
                    continue;   //vse se otestuje znova
                }
                if( $char == 35)        // # kometar
                {
                    while(($char != 10) && ($znak !== FALSE))   // precte do konce radku
                    {
                        
                        $znak=fgetc($STDIN);
                        $char=ord($znak);
                       // printf ("%d;",$char);     //help vypis
                    }
                    $znak=fgetc($STDIN);    // nacte prvni znak na novem radku
                    $char=ord($znak);
                   // printf (" tady %d;",$char);       //help vypis
                    $citac_poradi=0;    // novy radek - token bude prvni
                    continue;   // testuj znova
                }
                $token="";
                while(($char >= 33) && ($char<= 126) && ($znak !== FALSE))  // nalezen tiknutelny znak
                { 
                    $token=$token.$znak;    //konkaterace
                    $znak=fgetc($STDIN);
                    $char=ord($znak); 
                    //printf("ASCII:%d \n",$char);       //help vypis
                }
                if($nuluj_citac== TRUE) // predchozi token snedl EOL, vynulovat citac
                {
                    $nuluj_citac=FAlSE;
                    $citac_poradi=0;
                }
                if(($char == 10)|| ($char== 13))    // snedli jsme EOL pro dalsi token
                {
                   $nuluj_citac=TRUE;
                }
                $citac_poradi++;
                return $token;
            }
            return "#KONEC";        //konec souboru, token nemuze obsahovat #
        }
  
    
       for(  $i=0 ; $i< 10; $i++)
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







