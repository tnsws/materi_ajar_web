<?php
/**
*  Created by TNS Wong Solo
*  this codes just for learn
*  not for commercial use
*/

// buat konstanta tipe data
define('TIPE_NUMBER', 'int real ');
define('TIPE_TANGGAL', 'datetime timestamp year date time ');
define('TIPE_STRING', 'string blob ');

class db_class extends config
{

	var $db_konek;
	protected $pesan_error = array();
	
	function __construct()
	{
		
	}

	// fungsi untuk menyambungkan ke server database
	function connect($persistant = true)
	{
		if ($persistant == true) {
			$this->db_konek	= @mysql_pconnect($this->db_host, $this->db_user, $this->db_password);
		}else{
			$this->db_konek = @mysql_connect($this->db_host, $this->db_user, $this->db_password);
		}

		if (!$this->db_konek) {
			$this->set_error("Tidak dapat tersambung <br> error :".mysql_error());
			return false;
		}

		if (!$this->select_db($this->db_name)) {
			$this->set_error("Tidak dapat menyambung database <br> error : ".mysql_error());
			return false;
		}
		return $this->db_konek;
	}

	protected function select_db($database)
	{
		if (!@mysql_select_db($database)) {
			return false;
		}else{
			return true;
		}
	}

	/***************************************************
	 * fungsi-fungsi untuk mengambil data dari mysql
	 ***************************************************
	*/
	// mengambil data dari tabel
	// hasil berupa array
	function select($sql)
	{
		$qry = mysql_query($sql);
		if(!$qry){
			$this->set_error("Terjadi kesalahan pada kueri <br>error : ".mysql_error());
			return false;
		}
		return $qry;
	}

	function get_row($result)
	{
		if (!$result) {
			return false;
		}

		$row = mysql_fetch_object($result);

		if (!$row) {
			$this->set_error("Data tidak dapat diambil");
			return false;
		}

		return $row;
	}

	/*******************************************
	**  fungsi-fungsi untuk menyimpan dan
	**  mengupdate data ke mysql
	********************************************
	*/

	protected $tipefield;
	protected $namafield;

	function simpan_data($tabel = "", $data, $kondisi = "" , $is_update = false)
	{
		if ($tabel == "") {
			$this->set_error('Tabel belum dipilih');
			return false;
		}

		if (!$this->get_info_kolom($tabel)) {
			return false;
		}

		$jumlah = count($data);
		$i = $x = 0;
		$sql = (!$is_update) ? "INSERT INTO ".$tabel." SET " : "UPDATE ".$tabel." SET ";
		
		foreach ($data as $nfield => $value) {
			if (!empty($value)) {
				$sql .= $nfield." = ";
				for ($i=0; $i < $jumlah; $i++) { 
					if ($this->namafield[$i] == $nfield) {
						$sql .= $this->get_info_value($value, $i);
						break;
					}
				}
			}
		}

		$sql = rtrim($sql, ',');
		if(!empty($kondisi)) $sql .= " WHERE ".$kondisi;

		unset($data);
		unset($this->namafield);
		unset($this->tipefield);

		return $this->run_sql($sql, $is_update);
	}

	public function run_sql($sql, $is_update)
	{
		$kueri = mysql_query($sql);

		if (!$kueri) {
			$pesan = ($is_update) ? "update" : "insert";
			$this->set_error('Kesalahan pada '.$pesan.' : '.$sql);
			return false;
		}

		if (!$is_update) {
			$id = mysql_insert_id();
			if($id == 0)
				return true;
			else
				return $id;
		}else{
			$rows = mysql_affected_rows();
			if($rows == 0)
				return true;
			else
				return $rows;
		}

	}

	private function get_info_value($value, $i)
	{
		if (substr_count(TIPE_TANGGAL, $this->tipefield[$i])) {
			$sql = "'".$this->format_tanggal($value)."',";
		}elseif (substr_count(TIPE_NUMBER, $this->tipefield[$i])) {
			$sql = $value.",";
		}elseif (substr_count(TIPE_STRING, $this->tipefield[$i])) {
			$sql = "'".$value."',";
		}

		return $sql;
	}

	private function get_info_kolom($tabel)
	{
		$kueri = mysql_query("SELECT * FROM ".$tabel);
		if (!$kueri) {
			$this->set_error("Tidak dapat mengakses tabel ".$tabel);
			return false;
		}

		$nfields = mysql_num_fields($kueri);
		
		$this->namafield = array();
		$this->tipefield = array();

		for ($i=0; $i < $nfields; $i++) { 
			array_push($this->namafield, mysql_field_name($kueri, $i));
			array_push($this->tipefield, mysql_field_type($kueri, $i));
		}

		mysql_free_result($kueri);

		return true;
	}

	private function format_tanggal($tanggal)
	{
		if (!empty($tanggal)) {
			if(gettype($tanggal) == 'string')
				$tanggal = strtotime($tanggal);

			return date('Y-m-d H:i:s', $tanggal);
		}
	}

	// selesai fungsi-fungsi untuk insert/ update data ke tabel
	/**************************************************************/

	/************************************************
	 *  Fungsi untuk menghapus data dari tabel
	 ************************************************/
	function hapus_data($tabel, $kondisi){
		$kueri =mysql_query("DELETE FROM ".$tabel." WHERE ".$kondisi);
		if(!$kueri) {
			$this->set_error("Kesalahan saat menghapus data : <br/>error : ".mysql_error());
			return false;
		}
		return true;
	}
	/***********************************************
	 *  End fungsi hapus data
	 ***********************************************/

	// fungsi untuk menampung error
	protected function set_error($pesan)
	{
		if (is_array($pesan)) {
			foreach ($pesan as $val) {
				$this->pesan_error[] = $val;
			}
		}else $this->pesan_error[] = $pesan;
	}

	// tampilkan error
	function show_error($poin = '-', $jeda = '<br><br>')
	{
		if (count($this->pesan_error) == 0) {
			return false;
		}
		$str = '';
		foreach ($pesan_error as $pesan) {
			$str .= $poin.' '.$pesan.$jeda;
		}

		echo $str;
	}

	function __destruct(){

	}
}
?>