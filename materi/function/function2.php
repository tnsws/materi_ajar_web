<?php
function batas()
{
	echo '<br>===============================<br>';
}

function bulan($num_bulan = 0)
{
	$strbulan = array(
			'',
			'Januari', 
			'Februari', 
			'Maret', 
			'April', 
			'Mei', 
			'Juni', 
			'Juli', 
			'Agustus', 
			'September', 
			'Oktober', 
			'November', 
			'Desember'
		);
	
	return $strbulan[$num_bulan];
}



function format_tanggal($tanggal)
{
	$sdate = explode('-',$tanggal);
	$bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September');
	$hari = array(
		'Sun' => 'Minggu', 
		'Mon' => 'Senin', 
		'Tue' => 'Selasa', 
		'Wed' => 'Rabu',
		'Thu' => 'Kamis',
		'Fri' => "Jum'at",
		'Sat' => 'Sabtu'
	);
	
	$shari = $hari[$sdate[0]];
	$stgl = $sdate[1];
	$sbln = $bulan[$sdate[2]];
	$sthn = $sdate[3];
	
	return $shari.', '.$stgl.' '.$sbln.' '.$sthn;
}


echo 'hari ini adalah '.format_tanggal(date('D-d-n-Y'));





?>