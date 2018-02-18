<?php


$param_help_text="Ahoj jsem paramtert help!"; //TODO
// TODO exit nebo return ???

//Globalni promene 
$STDIN = fopen("input.txt", "r");  //TODO
$citac_poradi=0;
$nuluj_citac=FALSE;
$koment = FALSE;

$gram_nic = array("createframe","pushframe","popframe","return","break");
$gram_var = array("defvar","pops");
$gram_label = array("call","label","jump");
$gram_symbol = array("pushs","write","dprint");
$gram_var_sym_sym = array("add","sub","mul","idiv","lt","gt","eq","and","and","or","not","stri2int","concat","getchar","setchar");
$gram_var_symbol = array("int2char","strlen","type","move");
$gram_var_type = array("read");
$gram_label_sym_sym = array("jumpifeq","jumpifneq");

$var_types = array("int","bool","string");

$global_frame= array();
$local_frame= array();
$temp_frame= array ();


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
    exit(21);   //TODO
}

$IPPCODE_hlavicka= new Tokeny();
$IPPCODE_hlavicka->text = Get_token(); 
$IPPCODE_hlavicka->poradi= $citac_poradi;
if(($IPPCODE_hlavicka->poradi == 1)&& ($IPPCODE_hlavicka->text == ".IPPcode18"))
{
    $token = new Tokeny();  //nactu token
    $token->text = Get_token();
    $token->poradi= $citac_poradi;
    $lower = strtolower($token->text);
    while ($token->text != "#KONEC")    //smycka pro precteni celho vstupu
    {
        if(in_array($lower, $gram_nic)) //Instrukce bey parametru
        {
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
            //TODO generovani XML
        }

        if(in_array($lower, $gram_var))
        {
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 2)
             {
                print("var neni druhy");   //TODO
                exit(21); 
             }
             //TODO validace var
             //TODO genere XML
        }
        
        if(in_array($lower, $gram_label))
        {
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 2)
             {
                print("label neni druhy");   //TODO
                exit(21); 
             }
             //TODO validace label
             //TODO genere XML
        }
        
        if(in_array($lower, $gram_symbol))
        {
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 2)
             {
                print("symbol neni druhy");   //TODO
                exit(21); 
             }
             //TODO validace symbol
             //TODO genere XML
        }
        
        
        if(in_array($lower, $gram_var_symbol))
        {
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 2)
             {
                print("var neni druhy");   //TODO
                exit(21); 
             }
             //TODO validace var
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 3)
             {
                print("symbol neni treti");   //TODO
                exit(21); 
             }
             //TODO validace symbol
             //TODO genere XML
        }
        
        if(in_array($lower, $gram_var_type))
        {
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 2)
             {
                print("var neni druhy");   //TODO
                exit(21); 
             }
             //TODO validace var
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 3)
             {
                print("type neni treti");   //TODO
                exit(21); 
             }
             //TODO validace type
             //TODO genere XML
        }
        
        if(in_array($lower, $gram_var_sym_sym))
        {
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 2)
             {
                print("var neni druhy");   //TODO
                exit(21); 
             }
             //TODO validace var
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 3)
             {
                print("symbol neni treti");   //TODO
                exit(21); 
             }
             //TODO validace symbol
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 4)
             {
                print("symbol neni ctvrty");   //TODO
                exit(21); 
             }
             //TODO validace symbol
             //TODO genere XML
        }
        
        if(in_array($lower, $gram_label_sym_sym))
        {
            printf("nasel sem:%s\n\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 2)
             {
                print("label neni druhy");   //TODO
                exit(21); 
             }
             //TODO validace label
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 3)
             {
                print("symbol neni treti");   //TODO
                exit(21); 
             }
             //TODO validace symbol
             $token->text = Get_token();
             $token->poradi= $citac_poradi;
             if($token->poradi != 4)
             {
                print("symbol neni ctvrty");   //TODO
                exit(21); 
             }
             //TODO validace symbol
             //TODO genere XML
        }




       $token->text = Get_token(); //nakonec nacte dalsi token
       $token->poradi= $citac_poradi;
       $lower = strtolower($token->text);
    }
    valid_konst("strinG@falSe\\211\\555\\552ř");
    exit(0);
}
else
{
    print("NENASEL hlavicku");  //TODO
    exit(21);   //TODO prvni token musi byt hlavicka
}


        // Vraci string tokenu a nastavuje globalni promenou citac_poradi
 function Get_token()
        {
            global $STDIN,$citac_poradi,$nuluj_citac,$koment;   //global promene
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
                if( ($char == 35) || ($koment == TRUE))       // # kometar nebo spapany #
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
                    $koment=FALSE;
                    continue;   // testuj znova
                }
                $token="";
                while(($char >= 33) && ($char != 127) && ($znak !== FALSE)&&($char != 35)  )  // nalezen tiknutelny znak a neni to #
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
                if( $char == 35)    //snedli jsme #
                {
                    $koment= TRUE;
                }
                $citac_poradi++;
                return $token;
            }
            return "#KONEC";        //konec souboru, token nemuze obsahovat #
        }

        
            /* //HELP VYPIS PRO TOKENY
       for(  $i=0 ; $i< 10; $i++)
        {
            $slovo = new Tokeny();
            $slovo->text = Get_token();
            $slovo->poradi = $citac_poradi;
            
   

            printf("%s p:%d\n",$slovo->text,$slovo->poradi);       
        }*/
        
     function get_prefix($text)
     {   
         $poradi=strpos($text,"@");
         if($poradi===FALSE)
         {
             print("nenasel sem @\n");
             return "error";
         }
         $prefix= substr($text,0,$poradi);
         return $prefix;
     }


     function valid_konst ($text)
     {
         global $var_types,$int_types;
         $poradi=strpos($text,"@");
         if($poradi===FALSE)
         {
             print("nenasel sem @\n");
             return FALSE;
         }
         $prefix= substr($text,0,$poradi);
         //printf("poradi:%d , prefix:%s\n",$poradi,$prefix);
         $suffix=substr($text,$poradi+1, strlen($text)-$poradi);
         //printf("poradi:%d , suffix:%s\n",$poradi,$suffix);
         $prefix= strtolower($prefix);  //case sensitive????
         
         if($prefix=="int")
         {
                 $i=0;
                 $asci= ord($suffix[$i]);
                // printf("%d \n",$asci);
                 if(($asci== 43)||($asci== 45))
                 {
                    $i++;
                  //  print("prvni znamenko\n");
                 }
                 while ($i< strlen($suffix))
                 {
                     $asci= ord($suffix[$i]);
                    // printf("%d \n",$asci);
                     if(($asci< 48)||($asci> 57))
                     {
                         print("zly sufix type int \n");    //TODO
                         return FALSE;  
                     }
                     $i++;
                 }
                 return TRUE;
         }
         elseif ($prefix=="bool") {
             $suffix= strtolower($suffix);  //TODO case sensitive???
             if(($suffix!="true")&&($suffix!="false"))
             {
                print("zly sufix type bool \n");    //TODO
                return FALSE;  
             }
             else   return TRUE;
         }
         elseif ($prefix=="string") {
             $zbytek= $suffix;
             $poradi=strpos($zbytek,'\\');
             while ($poradi !== FALSE)
             {
                $str = substr($zbytek,$poradi+1,3);
                if(strlen($str)!=3)
                {
                    print("za lomitkem nejsou 3 znaky\n");
                    return FALSE;
                }
                for($i=0;$i<3;$i++)
                {
                    $str_ascii=ord($str[$i]);
                    if(($str_ascii<48)||($str_ascii>57))
                    {
                         print("zly suffix za lomitkem nejsou cisla\n");    //TODO
                        return FALSE;
                    }
                }

                $zbytek = substr($zbytek,$poradi+1, strlen($zbytek)-$poradi);
                $poradi=strpos($zbytek,'\\');
             }
             print($zbytek);
             return TRUE;
         }
         else
         {
             print("Zly prefix var\n");     //TODO
             return false;
         }
     }
?>







