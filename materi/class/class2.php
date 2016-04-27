<?php
// Kelas induk
class Inventaris
{
	public $kode;
	protected $nama;
	private $qty;
}

// Kelas turunan dari Inventaris
class Alatkantor extends Inventaris
{
	function tampil()
	{
		$this->nama = 'Sapidol';
		$str ='';
		$str .= 'Kode = '.$this->kode.'<br>';
		$str .= 'nama = '.$this->nama.'<br>';
		$str .= 'Jml = '.$this->qty.'<br>';
		return $str;
	}
}

$alattulis = new Alatkantor;
$alattulis->kode = 'SP001';
//$alattulis->nama = 'Sapidol';
$alattulis->qty = 10;

echo $alattulis->tampil();

?>