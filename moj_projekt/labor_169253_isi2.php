<?php
	$nr_indeksu = '169253';
	$nrGrupy = '2';

	echo 'Mariusz Karczykowski '.$nr_indeksu.' isi '.$nrGrupy.'<br/><br/>';

	echo 'Zastosowanie metody include() <br/>';
	include('stopka.php');

	echo '<br/><br/>Zastosowanie metody require_once(). Podobne działanie do include(), z tą różnicą, że jeśli jest już załadowany to nie ładuje ponownie <br/>';
	require_once('stopka.php');

	echo '<br/><br/>Zastosowanie if, else, elseif<br/>';
	if($nr_indeksu > 169250)
	{
		echo 'nr indeksu jest wieksze od 169250';
	}
	elseif($nr_indeksu < 169250)
	{
		echo 'nr indeksu jest mniejsze od 169250';
	}
	else
	{
		echo 'nr indeksu jest rowny 169250';
	}
	
	echo '<br/><br/>Zastosowanie switch<br/>';
	switch($nr_indeksu){
		case 169253:
			echo 'Jestes Mariusz';
			break;
		case 169260:
			echo 'Jestes Jan';
			break;
		case 169240:
			echo 'Jestes Marian';
			break;
		default:
			echo 'Nie znaleziono twojego nr indeksu';
	}
		
	echo '<br/><br/>Zastosowanie while()<br/>';
	$i = 0;
	while($i < 11)
	{
		echo $i.'<br/>';
		$i++;
	}

	echo '<br/><br/>Zastosowanie for()<br/>';
	for($i=0;$i<11;$i++)
	{
		echo $i.'<br/>';
	}

	echo '<br/><br/>$_GET służy do jawnego pobierania danych poprzez adres URL';
	echo '<br/><br/>$_POST służy do pobierania danych z metody post. Na przykład z formularzy';
	echo '<br/><br/>$_SESSION służy do przetrzymywania danych użytkownika pomiędzy różnymi stronami. Zaczynamy od napisania session_start()';
?>