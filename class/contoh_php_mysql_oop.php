<?php
require 'assets/config.php';
require 'assets/db_class.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Contoh PHP MySQL dengan OOP</title>
	<link href="assets/sample.css" rel="stylesheet" type="text/css">
</head>
<body>
	<p>Contoh penggunaan pemrograman OOP pada PHP dan MySQL.</p>
	<p>
	<?php

	$db = new db_class();
	if (!$db->connect()) {
		$db->show_error();
	}

	$sql = "SELECT * FROM tb_kategori";

	if (isset($_POST['aksi'])) {
		$aksi = $_POST['aksi'];
		// value yang disimpan dijadikan array
		$data = array(
			'idkategori'	=> '',
			'kategori'		=> $_POST['kategori'],
			'jmlberita'		=> '0'
		);

		switch ($aksi) {
			case 'add':
				$db->simpan_data('tb_kategori', $data);
				break;
			
			case 'update':
				$id 				= $_POST['idkategori'];
				// idkategori & jmlberita diambil dari data di tabel
				$data['idkategori']	= $_POST['idkategori'];
				$data['jmlberita']	= $_POST['jmlberita'];

				$kondisi 			= "idkategori = ".$id;

				$db->simpan_data('tb_kategori', $data, $kondisi, true);
				break;
		}
	}

	// hapus data
	if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
		$idkat = $_GET['id'];
		$kondisi = 'idkategori = '.$idkat;
		$db->hapus_data('tb_kategori', $kondisi);

		header('location:'.$_SERVER['PHP_SELF']);
	}

	if (!$db->select($sql)) {
		$db->show_error();
		return false;
	}
	?>
	</p>

	<?php 

	if (isset($_GET['aksi'])) {
		$editstatus = false;
		$aksi = $_GET['aksi'];

		if ($aksi == 'edit') {
			$row = $db->get_row($db->select($sql." WHERE idkategori=".$_GET['id']));
			$editstatus = true;
		}
	 ?>

	<div style="width:400px">
		<fieldset>
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				<label for="kategori">Nama Kategori</label>
				<input type="text" name="kategori" id="kategori" value="<?php if($editstatus == true) echo $row->kategori ?>" placeholder="Nama Kategori" class="text ui-widget-content ui-corner-all">
				<input type="hidden" id="idkategori" name="idkategori" value="<?php if($editstatus == true) echo $row->idkategori ?>">
				<input type="hidden" id="jmlberita" name="jmlberita" value="<?php if($editstatus == true) echo $row->jmlberita ?>">
				<input type="hidden" id="aksi" name="aksi" value="<?php if($editstatus == true) echo "update"; else echo "add"; ?>">

				<input id="simpan" type="submit" name="submit" value="Simpan">

			</form>
		</fieldset>
	</div>
	<?php } ?>

	<div class="tabel">
		<table cellpadding="3" cellspacing="1" border="0" width="100%">
			<caption>Data Kategori</caption>
			<tr>
				<td colspan="7">
					<span class="head">
						Kueri : <?php echo $sql ?> 
						<a href="<?php echo $_SERVER['PHP_SELF'] ?>?aksi=new" id="tambah" class="link">&laquo; Tambah data baru &raquo;</a>
					</span>
				</td>
			</tr>
		<?php
		$i = $index = 0;
		$qry=$db->select($sql);
		if(!$qry) $db->show_error();
		while($row = $db->get_row($qry)){
			if ($i == 0) {
		?>
			<tr class="head">
				<?php
				foreach ($row as $col => $val) {
				?>
					<td><span class="field"><?php echo ucwords(str_replace("_", ' ', $col)) ?></span></td>
				<?php
				}
				?>
				<td><span class="field">Aksi</span></td>
			</tr>
			<?php
			}
			$index = $i;
			$i++;
			if ($i % 2 != 0) $style = 'even';
			else $style = 'odd';
			?>
			<tr class="<?php echo $style ?>">
				<?php
				$m = 0;
				$key = '';
				foreach ($row as $value) {
					if ($m == 0) {
						$key = $value;
					}
				?>
					<td><span class="detail"><?php echo $value ?></span></td>
				<?php
					$m++;
				}
				?>
				<td>
					<span class="detail">
						<a href="<?php echo $_SERVER['PHP_SELF'] ?>?aksi=edit&amp;id=<?php echo $key ?>" class="edit">Edit</a> |
						<a href="<?php echo $_SERVER['PHP_SELF'] ?>?aksi=hapus&amp;id=<?php echo $key ?>" class="button" onclick="return confirm('Hapus kategori?')">Hapus</a>
					</span>
				</td>
			</tr>
		<?php
		}
		?>
		</table>
	</div>

</body>
</html>