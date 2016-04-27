<?php
function batas()
{
	echo '<br>===============================<br>';
}

function pangkat($nilai = 0)
{
	$result = $nilai*$nilai;
	
	return $result;
}

echo ' Ini tulisan atas';
batas();
echo pangkat();
batas();
echo pangkat(10);
batas();
echo pangkat(8);
?>