<?php
?>
<h1>Leer sesiones</h1>
<table class="wp-list-table widefat fixed striped table-view-list post">
	<tr>
		<th><b>IP</b></th>
		<th><b>Fecha y Hora</b></th>
		<th><b>Variables</b></th>
		<th><b>Acciones</b></th>
	
	</tr>
	<?php 
	$carpeta=ABSPATH."wp-content/plugins/wortev-tracking/sesiones/";
	$listas=scandir($carpeta);
	 
	 
	$contar_listas=count($listas);
	for ($i=0; $i < $contar_listas; $i++) { 
		if ($listas[$i]!="." && $listas[$i]!="..") {
		?><tr><td><?php 
		$archivo=$listas[$i];
		$archivo=explode("_", $archivo);
		echo $archivo[0]; 
		?></td>
		<td><?php echo $archivo[1]; ?> / <?php echo $archivo[2]; ?>:<?php echo $archivo[3]; ?></td>
		<td><?php 
		$archivo_json=file_get_contents($carpeta.$listas[$i]); 
		$variable=json_decode($archivo_json);
		print_r($variable);
	?></td>
		</tr><?php
	} }
	 
	?>
</table>