
<?php
// Script example.php

$help_paramter = "Parametr help\n";
$rekurze = false ;
$direktor = false;
$cesta_direktor = "";
$parse=false;
$cesta_parse=".";
$interpret=false;
$cesta_interpret=".";


$longopts  = array(
    "help",    
    "directory:",   
    "recursive",       
    "parse-script:",          
    "int-script:",       

);
$options = getopt("", $longopts);

foreach($options as $arg => $value)
{
	if(strcmp($arg,"help")==0)
	{
		print($help_paramter);
		exit(0);
	}
	else if(strcmp($arg,"recursive")==0)
	{	
		$rekurze=true;
	}
	else if(strcmp($arg,"directory")==0)
	{	
		$direktor=true;
		$cesta_direktor=$value;
	}
	else if(strcmp($arg,"parse-script")==0)
	{	
		$parse=true;
		$cesta_parse=$value;
	}
	else if(strcmp($arg,"int-script")==0)
	{	
		$interpret=true;
		$cesta_interpret=$value;
	}	
	else
	{
		print("Neznamy parametr chyba\n");
		exit(1);	
	}
}


if($rekurze)
	print("print rekuzre jede\n");
if($direktor)
	print("director on cesta:$cesta_direktor\n");
if($interpret)
	print("interpret on cesta:$cesta_interpret\n");
if($parse)
	print("parse on cesta:$cesta_parse\n");

echo getcwd() . "\n";

if($direktor)
{
	$cesta_direktor=$cesta_direktor."/";
}

$hledej=$cesta_direktor."*.src";

if($rekurze)
{
	$soubory=rglob($hledej);
}
else
{
	$soubory = glob($hledej) ;
}

$xmlfile=tmpfile();
$final=tmpfile();
$pole=array();
foreach($soubory as $soubor)
{
	$name=basename($soubor,".src");
	$cesta=dirname($soubor);
	$cesta=$cesta."/";
	print("\nNazev souboru:".$name);
	print("\nCEsta souboru:".$cesta);
	print("\n");

	/* Hledam .out */
	$out_soubor = glob($cesta.$name.".out");
	if(count($out_soubor)>1)
	{
		print("\n2x in soubor:".$name);
		//TODO error test
	}
	if(count($out_soubor)==0)
	{
		if((touch($cesta.$name.".out"))==FALSE)
		{
			print("Nepovedlo se vytvorit soubor $name");
			//TODO error test
		}
		$out_soubor = glob($cesta.$name.".out");
	}

	/*Hledam .in*/
	$in_soubor = glob($cesta.$name.".in");
	if(count($in_soubor)>1)
	{
		print("\n2x in soubor:".$name);
		//TODO error test
	}
	if(count($in_soubor)==0)
	{
		if((touch($cesta.$name.".in"))==FALSE)
		{
			print("Nepovedlo se vytvorit soubor $name");
			//TODO error test
		}
		$in_soubor = glob($cesta.$name.".in");

	}

	/* hledam .src */
	$src_soubor = glob($cesta.$name.".rs");
	if(count($src_soubor)>1)
	{
		print("\n2x in soubor:".$name);
		//TODO error test
	}
	if(count($src_soubor)==0)
	{
		if(($file_write=fopen($cesta.$name.".rs","w"))==FALSE)
		{
			print("Nepovedlo se vytvorit soubor $name");
			//TODO error test
		}
		if((fwrite($file_write,'0'))!=1)
		{
			print("Nepovedlo se zapsat 0 do souboru $name");
			//TODO error test
		}	
		fclose($file_write);
		$src_soubor = glob($cesta.$name.".src");
	}


//v *_soubor jsou soubory vzdy
//spustit diff uz jen a vygenerovat html




	exec("php56 $cesta_parse/parse.php < $soubor > $xmlfile");
	exec("python interpret.py > $final",$pole,$python_return);
	exec("diff return.rs - <<<\"$python_return\"",$pole,$diff_return);
	print("Diff return:$diff_return");

	//exec($text,$pole,$diff_out);
	//printf("Python:%d ; Diff vystup:%d ; Diff return:%d",$python_return,$diff_out,$diff_return); 
}





/*Funkce pro rekurentni prochazeni adresaru
* Zdroj: https://stackoverflow.com/questions/17160696/php-glob-scan-in-subfolders-for-a-file
*/
function rglob($pattern, $flags = 0) {
    $files = glob($pattern, $flags); 
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}

fclose($final);
fclose($xmlfile);

?>

