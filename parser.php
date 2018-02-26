
<?php


$param_help_text="Ahoj jsem paramtert help!"; //TODO
// TODO exit nebo return ???

//Globalni promene 
$STDIN = fopen("input2.txt", "r");  //TODO
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

$konst_types = array("int","bool","string");

$var_chars = array(95,45,36,38,37,42);

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
    $xml = new DOMDocument("1.0","UTF-8");
    $xml_program = $xml->createElement("program");
    $xml_program->getAttribute("language"); 
    $xml->appendChild( $xml_program);
    $xml_program->setAttribute("language","IPPcode18");
 
    $token = new Tokeny();  //nactu token
    $token2 = new Tokeny();
    $token3 = new Tokeny();
    $token4 = new Tokeny();
    $token->text = Get_token();
    $token->poradi= $citac_poradi;
    $lower = strtolower($token->text);
    while ($token->text != "#KONEC")    //smycka pro precteni celho vstupu
    {
        if(in_array($lower, $gram_nic)) //Instrukce bey parametru
        {
            $name = $token->text;   //TODO
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
            printf("Nalezeny je OK:%s\n",$name);
            //generovani XML
	    $xml_instrukce = $xml->createElement("instruction");
	    $xml_program->appendChild($xml_instrukce);
	    $xml_instrukce->setAttribute("order", $token->poradi);
	    $xml_instrukce->setAttribute("opcode", $token->text);
	    
        }

        else if(in_array($lower, $gram_var))
        {
            $name = $token->text;   //TODO
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
	     
             $token2->text = Get_token();
             $token2->poradi= $citac_poradi;
             if($token2->poradi != 2)
             {
                print("var neni druhy");   //TODO
                exit(21); 
             }
             if(valid_variable($token2->text)===FALSE)
             {
                print("var neni validni");   //TODO
                exit(21); 
             }
             printf("Nalezeny je OK:%s\n",$name);
             //TODO genere XML
	    $xml_instrukce = $xml->createElement("instruction");
	    $xml_program->appendChild($xml_instrukce);
	    $xml_instrukce->setAttribute("order", $token->poradi);
	    $xml_instrukce->setAttribute("opcode", $token->text);
	    
	    $xml_arg1 = $xml->createElement("arg1", $token2->text);
	    $xml_arg1->setAttribute("type","var");
	    $xml_instrukce->appendChild($xml_arg1);
        }
        
        else if(in_array($lower, $gram_label))
        {
            $name = $token->text;   //TODO
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
	    
             $token2->text = Get_token();
             $token2->poradi= $citac_poradi;
             if($token2->poradi != 2)
             {
                print("label neni druhy");   //TODO
                exit(21); 
             }
             printf("Nalezeny je OK:%s\n",$name);
             if(valid_label($token2->text)===FALSE)
             {
                print("label neni validni");   //TODO
                exit(21); 
             }
             //TODO genere XML
	    $xml_instrukce = $xml->createElement("instruction");
	    $xml_program->appendChild($xml_instrukce);
	    $xml_instrukce->setAttribute("order", $token->poradi);
	    $xml_instrukce->setAttribute("opcode", $token->text);
	    
	    $xml_arg1 = $xml->createElement("arg1","$token2->text");
	    $xml_arg1->setAttribute("type","label");
	    $xml_instrukce->appendChild($xml_arg1);
        }
        
        else if(in_array($lower, $gram_symbol))
        {
            $name = $token->text;   //TODO
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
	    
	    $xml_instrukce = $xml->createElement("instruction");
	    $xml_program->appendChild($xml_instrukce);
	    $xml_instrukce->setAttribute("order", $token->poradi);
	    $xml_instrukce->setAttribute("opcode", $token->text);

             $token2->text = Get_token();
             $token2->poradi= $citac_poradi;
             if($token2->poradi != 2)
             {
                print("symbol neni druhy");   //TODO
                exit(21); 
             }
	     
	    
	     
             if(valid_variable($token2->text)===TRUE)
             {
		 $xml_arg1 = $xml->createElement("arg1","$token2->text");
		 $xml_arg1->setAttribute("type","var");
             }
	     elseif (valid_konst($token2->text)===TRUE)
	     {   
		$xml_arg1 = $xml->createElement("arg1",get_suffix($token2->text));
		$xml_arg1->setAttribute("type", get_prefix($token2->text));   
	     }
	     else
	     {
		print("symbol neni validni");   //TODO
                exit(21);    
	     }
             printf("Nalezeny je OK:%s\n",$name);
             //genere XML
	     $xml_instrukce->appendChild($xml_arg1);

        }
        
        
        else if(in_array($lower, $gram_var_symbol))
        {
            $name = $token->text;   //TODO
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
	    
	    $xml_instrukce = $xml->createElement("instruction");
	    $xml_program->appendChild($xml_instrukce);
	    $xml_instrukce->setAttribute("order", $token->poradi);
	    $xml_instrukce->setAttribute("opcode", $token->text);
	    
	    
             $token2->text = Get_token();
             $token2->poradi= $citac_poradi;
             if($token2->poradi != 2)
             {
                print("var neni druhy");   //TODO
                exit(21); 
             }
            if(valid_variable($token2->text)===FALSE)
             {
                print("var neni validni");   //TODO
                exit(21); 
             }
	     
	    $xml_arg1 = $xml->createElement("arg1", $token2->text);
	    $xml_arg1->setAttribute("type","var");
	    $xml_instrukce->appendChild($xml_arg1);
	    
	    
	   
             $token3->text = Get_token();
             $token3->poradi= $citac_poradi;
             if($token3->poradi != 3)
             {
                print("symbol neni treti");   //TODO
                exit(21); 
             }
	    
	     
             if(valid_variable($token3->text)===TRUE)
             {
		 $xml_arg2 = $xml->createElement("arg2","$token3->text");    
		 $xml_arg2->setAttribute("type","var");
             }
	     elseif (valid_konst($token3->text)===TRUE)
	     {   
		  $xml_arg2 = $xml->createElement("arg2",get_suffix($token3->text));
		  $xml_arg2->setAttribute("type", get_prefix($token3->text));     
	     }
	     else
	     {
		print("symbol neni validni");   //TODO
                exit(21);    
	     }
             printf("Nalezeny je OK:%s\n",$name);
             //TODO genere XML
	     $xml_instrukce->appendChild($xml_arg2);
        }
        
        else if(in_array($lower, $gram_var_type))
        {
            $name = $token->text;   //TODO
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
	   
	    $xml_instrukce = $xml->createElement("instruction");
	    $xml_program->appendChild($xml_instrukce);
	    $xml_instrukce->setAttribute("order", $token->poradi);
	    $xml_instrukce->setAttribute("opcode", $token->text);
	    
	    
             $token2->text = Get_token();
             $token2->poradi= $citac_poradi;
             if($token2->poradi != 2)
             {
                print("var neni druhy");   //TODO
                exit(21); 
             }     
            if(valid_variable($token2->text)===FALSE)
             {
                print("var neni validni");   //TODO
                exit(21); 
             }
	     
	    $xml_arg1 = $xml->createElement("arg1", $token2->text);
	    $xml_arg1->setAttribute("type","var");
	    $xml_instrukce->appendChild($xml_arg1);
	     
             $token3->text = Get_token();
             $token3->poradi= $citac_poradi;
             if($token3->poradi != 3)
             {
                print("type neni treti");   //TODO
                exit(21); 
             }
             printf("Nalezeny je OK:%s\n",$name);
             if(valid_type($token3->text)===FALSE)
             {
                print("type neni validni");   //TODO
                exit(21); 
             }

	    $xml_arg2 = $xml->createElement("arg2", $token3->text);
	    $xml_arg2->setAttribute("type","type");
	    $xml_instrukce->appendChild($xml_arg2);
	     
        }
        
        else if(in_array($lower, $gram_var_sym_sym))
        {
            $name = $token->text;   //TODO
            printf("nasel sem:%s\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
	    
	    $xml_instrukce = $xml->createElement("instruction");
	    $xml_program->appendChild($xml_instrukce);
	    $xml_instrukce->setAttribute("order", $token->poradi);
	    $xml_instrukce->setAttribute("opcode", $token->text);
	    
             $token2->text = Get_token();
             $token2->poradi= $citac_poradi;
             if($token2->poradi != 2)
             {
                print("var neni druhy");   //TODO
                exit(21); 
             }
            if(valid_variable($token2->text)===FALSE)
             {
                print("var neni validni");   //TODO
                exit(21); 
             }
	     
	    $xml_arg1 = $xml->createElement("arg1", $token2->text);
	    $xml_arg1->setAttribute("type","var");
	    $xml_instrukce->appendChild($xml_arg1);
	     
             $token3->text = Get_token();
             $token3->poradi= $citac_poradi;
             if($token3->poradi != 3)
             {
                print("symbol neni treti");   //TODO
                exit(21); 
             }
             if(valid_variable($token3->text)===TRUE)
             {
		 $xml_arg2 = $xml->createElement("arg2","$token3->text");    
		 $xml_arg2->setAttribute("type","var");
             }
	     elseif (valid_konst($token3->text)===TRUE)
	     {   
		  $xml_arg2 = $xml->createElement("arg2",get_suffix($token3->text));
		  $xml_arg2->setAttribute("type", get_prefix($token3->text));     
	     }
	     else
	     {
		print("symbol neni validni");   //TODO
                exit(21);    
	     }
	     $xml_instrukce->appendChild($xml_arg2);
	     
             $token4->text = Get_token();
             $token4->poradi= $citac_poradi;
             if($token4->poradi != 4)
             {
                print("symbol neni treti");   //TODO
                exit(21); 
             }
            if(valid_variable($token4->text)===TRUE)
             {
		 $xml_arg3 = $xml->createElement("arg3","$token4->text");    
		 $xml_arg3->setAttribute("type","var");
             }
	     elseif (valid_konst($token4->text)===TRUE)
	     {   
		  $xml_arg3 = $xml->createElement("arg3",get_suffix($token4->text));
		  $xml_arg3->setAttribute("type", get_prefix($token4->text));     
	     }
	     else
	     {
		print("symbol neni validni");   //TODO
                exit(21);    
	     }
             printf("Nalezeny je OK:%s\n",$name);
             $xml_instrukce->appendChild($xml_arg3);
        }
        
        else if(in_array($lower, $gram_label_sym_sym))
        {
            $name = $token->text;   //TODO
            printf("nasel sem:%s\n\n",$token->text);    //TODO
            if($token->poradi != 1)     //musi byt prvni
            {
                print("Instukce neni prvni");   //TODO
                exit(21);
            }
	    
	    $xml_instrukce = $xml->createElement("instruction");
	    $xml_program->appendChild($xml_instrukce);
	    $xml_instrukce->setAttribute("order", $token->poradi);
	    $xml_instrukce->setAttribute("opcode", $token->text);
	    
             $token2->text = Get_token();
             $token2->poradi= $citac_poradi;
             if($token2->poradi != 2)
             {
                print("label neni druhy");   //TODO
                exit(21); 
             }
             if(valid_label($token2->text)===FALSE)
             {
                print("label neni validni");   //TODO
                exit(21); 
             }
	     
	    $xml_arg1 = $xml->createElement("arg1","$token2->text");
	    $xml_arg1->setAttribute("type","label");
	    $xml_instrukce->appendChild($xml_arg1);
	     
             $token3->text = Get_token();
             $token3->poradi= $citac_poradi;
             if($token3->poradi != 3)
             {
                print("symbol neni treti");   //TODO
                exit(21); 
             }
             if(valid_variable($token3->text)===TRUE)
             {
		 $xml_arg2 = $xml->createElement("arg2","$token3->text");    
		 $xml_arg2->setAttribute("type","var");
             }
	     elseif (valid_konst($token3->text)===TRUE)
	     {   
		  $xml_arg2 = $xml->createElement("arg2",get_suffix($token3->text));
		  $xml_arg2->setAttribute("type", get_prefix($token3->text));     
	     }
	     else
	     {
		print("symbol neni validni");   //TODO
                exit(21);    
	     }
	     $xml_instrukce->appendChild($xml_arg2);
	     
             $token4->text = Get_token();
             $token4->poradi= $citac_poradi;
             if($token4->poradi != 4)
             {
                print("symbol neni treti");   //TODO
                exit(21); 
             }
            if(valid_variable($token4->text)===TRUE)
             {
		 $xml_arg3 = $xml->createElement("arg3","$token4->text");    
		 $xml_arg3->setAttribute("type","var");
             }
	     elseif (valid_konst($token4->text)===TRUE)
	     {   
		  $xml_arg3 = $xml->createElement("arg3",get_suffix($token4->text));
		  $xml_arg3->setAttribute("type", get_prefix($token4->text));     
	     }
	     else
	     {
		print("symbol neni validni");   //TODO
                exit(21);    
	     }
	     $xml_instrukce->appendChild($xml_arg3);
             //TODO genere XML
        }
        else
        {
            print("Neznamy token! konec\n");
            exit(21);
        }

       $token->text = Get_token(); //nakonec nacte dalsi token
       $token->poradi= $citac_poradi;
       $lower = strtolower($token->text);
    }
    $xml->formatOutput = true;	//TODO
    $xml->save("./test.xml");

    
    echo $xml->saveXML() ;
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
     
     function valid_type($text)
     {
       $text= strtolower($text);
       if(($text=="int")||($text=="bool")||($text=="string"))
       {
           return TRUE;
       }
       else     
       {
           return FALSE;
       }
     }


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
     
     function get_suffix($text)
     {   
         $poradi=strpos($text,"@");
         if($poradi===FALSE)
         {
             print("nenasel sem @\n");
             return "error";
         }
         $suffix=substr($text,$poradi+1, strlen($text)-$poradi);
         return $suffix;
     }
     

     function valid_label($text)
     {
         global $var_chars;
         $asci_var=ord($text[0]);
         if((in_array($asci_var, $var_chars)===FALSE)&& (($asci_var < 65) || ($asci_var > 90)) && (($asci_var <97) || ($asci_var>122)))
         {
             print("label zacina spatne\n");
             return FALSE;
         }
         for($i=1;$i< strlen($text);$i++)
         {
            $asci_var=ord($text[$i]);
            if((in_array($asci_var, $var_chars)===FALSE)&& (($asci_var < 48) || ($asci_var > 57))&&(($asci_var < 65) || ($asci_var > 90)) && (($asci_var <97) || ($asci_var>122)))
            {
                print("label je spatne\n");
                return FALSE;
            } 
         }
         return TRUE;
     }
     
     
     function valid_variable($text)
     {
         global $var_chars;
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
         //$prefix= strtolower($prefix);  //case sensitive???? asi ne
         if(strlen($suffix)==0)
         {
             print("suffix nesmi byt nulovy\n");
             return FALSE;
         }
         if(($prefix != "GF")&&($prefix != "TF") && ($prefix != "LF"))
         {
             print("prefix neni validni oznaceni ramce\n");
             return FALSE;
         }
         $asci_var=ord($suffix[0]);
         if((in_array($asci_var, $var_chars)===FALSE)&& (($asci_var < 65) || ($asci_var > 90)) && (($asci_var <97) || ($asci_var>122)))
         {
             print("var zacina spatne\n");
             return FALSE;
         }
         for($i=1;$i< strlen($suffix);$i++)
         {
            $asci_var=ord($suffix[$i]);
            if((in_array($asci_var, $var_chars)===FALSE)&& (($asci_var < 48) || ($asci_var > 57))&&(($asci_var < 65) || ($asci_var > 90)) && (($asci_var <97) || ($asci_var>122)))
            {
                print("var je spatne\n");
                return FALSE;
            } 
         }
         return TRUE;
     }


     function valid_konst ($text)
     {
         global $konst_types,$int_types;
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
         //$prefix= strtolower($prefix);  //case sensitive???? asi ne
         if($prefix=="int")
         {
                if(strlen($suffix)==0)
                {
                    print("suffix nesmi byt nulovy pro int\n");
                    return FALSE;
                }
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
                if(strlen($suffix)==0)
                {
                    print("suffix nesmi byt nulovy pro bool\n");
                    return FALSE;
                }
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