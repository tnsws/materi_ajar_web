<?php
require 'assets/config.php';
require 'assets/db_class.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Contoh PHP MySQL dengan OOP</title>
	<link href="assets/jquery-ui.css" rel="stylesheet" type="text/css">
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
		$data = array(
			'idkategori'	=> '',
			'kategori'		=> $_POST['kategori'],
			'jmlberita'		=> ''
		);

		switch ($aksi) {
			case 'add':
				$db->simpan_data('tb_kategori', $data);
				break;
			
			case 'update':
				$id 				= $_POST['idkategori'];
				$data['idkategori']	= $_POST['idkategori'];
				$data['jmlberita']	= $_POST['jmlberita'];
				$kondisi 			= "idkategori = '".$id."'";
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

	<div class="tabel">
		<table cellpadding="3" cellspacing="1" border="0" width="100%">
			<caption>Data Administrators</caption>
			<tr>
				<td colspan="7">
					<span class="head">
						Kueri : <?php echo $sql ?> 
						<a href="#" id="tambah" class="link">&laquo; Tambah data baru &raquo;</a>
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
			<tr class="<?php echo $style ?>" id="rw_<?php echo $index ?>">
				<?php
				$m = 0;
				$key = '';
				foreach ($row as $value) {
					if ($m == 0) {
						$key = $value;
					}
				?>
					<td><span class="detail col_<?php echo $m ?>"><?php echo $value ?></span></td>
				<?php
					$m++;
				}
				?>
				<td>
					<span class="detail">
						<a href="#" id="<?php echo $index ?>" class="edit">Edit</a> |
						<a href="<?php echo $_SERVER['PHP_SELF'] ?>?aksi=hapus&amp;id=<?php echo $key ?>" class="button" onclick="return confirm('Hapus data?')">Hapus</a>
					</span>
				</td>
			</tr>
		<?php
		}
		?>
		</table>
	</div>

	<div id="formAdd" title="Kategori">
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
			<label for="kategori">Nama Kategori</label>
			<input type="text" name="kategori" id="kategori" value="" placeholder="Nama Kategori" class="text ui-widget-content ui-corner-all">
			<input type="hidden" id="idkategori" name="idkategori" value="">
			<input type="hidden" id="jmlberita" name="jmlberita" value="0">
			<input type="hidden" id="aksi" name="aksi" value="">

			<input id="simpan" type="submit" name="submit" value="Simpan">

		</form>
	</div>

	<script src="assets/jquery.js"></script>
	<script src="assets/jquery-ui.js"></script>
	<script>
	$(document).ready(function() {
		$("input[type=submit]").button()

		var box_add = $( "#formAdd" ).dialog({
			autoOpen: false,
			width: 280,
	      	modal: true
		});

		$( "#tambah" ).click(function( event ) {
			$( "#formAdd" ).dialog( "open" );

			$("#aksi").val("add");
			$("#kategori").val("");
		});

		$(".edit").click(function(event) {
			$("#formAdd").dialog("open");
			
			var row_id = $(this).attr('id');
			var id_kat = $("#rw_" + row_id + " .col_0").html();
			var kat = $("#rw_" + row_id + " .col_1").html();
			var jml = $("#rw_" + row_id + " .col_2").html();

			$("#idkategori").val(id_kat);
			$("#aksi").val("update");
			$("#kategori").val(kat);
			$("#jmlberita").val(jml);
		});
	});
	</script>

</body>
</html>