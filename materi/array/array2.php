<?php
$mhs = array(
		array(
			'nama'	=> 'Ani',
			'kelas'	=> '12.2A'
		),
		array(
			'nama'	=> 'Budi',
			'kelas'	=> '13.2A'
		),
		array(
			'nama'	=> 'Cici',
			'kelas'	=> '12.2B'
		)
	);

foreach($mhs as $data)
{
	echo $data['nama'].' | '.$data['kelas'];
	echo '<br>';
}

var_dump($mhs);
?>