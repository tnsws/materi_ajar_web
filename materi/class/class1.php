<?php
class Inventaris
{
	var $kode;
	var $nama;
	var $qty;
	
	function tampil()
	{
		$str ='';
		$str .= 'Kode = '.$this->kode.'<br>';
		$str .= 'nama = '.$this->nama.'<br>';
		$str .= 'Jml = '.$this->qty.'<br>';
		return $str;
	}
}

$alattulis = new Inventaris;
$alattulis->kode = 'SP001';
$alattulis->nama = 'Sapidol';
$alattulis->qty = 10;

echo $alattulis->tampil();
?>