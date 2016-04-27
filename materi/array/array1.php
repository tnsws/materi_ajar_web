<?php
$bilangan = array();
$bilangan[] = 1;
$bilangan[] = 2;
$bilangan[] = 3;
$bilangan[] = 4;
$bilangan[] = 5;

// definisi array 2
$hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu');

$abjad = array(
		'A'		=> 'Ani',
		'B'		=> 'Budi',
		'C'		=> 'Cici',
		'D'		=> 'Dedi',
		'E'		=> 'Eka'
	);

foreach($abjad as $row => $val)
{
	echo $row.' - '.$val;
	echo '<br>';
}

print_r($abjad);

/*
$jml = count($bilangan);
for($i=0; $i<$jml; $i++)
{
	echo $bilangan[$i];
	echo '<br>';
}
*/


	

?>