<?php
	$targets = Metathesis::getTargets();
?>
<style type="text/css" media="screen">
	#icon-metathesis {
		background: url("<?php echo plugin_dir_url(__FILE__); ?>img/backyard-view_32.png") no-repeat center center;
	}
</style>
<div class="wrap">
	<div class="icon32" id="icon-metathesis"><br></div>
	<h2>Metathesis: Export</h2>
	<p>Easily export the metadata stored in custom fields by the Thesis theme into other formats used by supported plugins and themes.</p>
	
	<h3>Supported Plugins and Themes</h3>
	
	<table cellspacing="0" class="widefat metathesis fixed">
		<thead>
		<tr>
			<th scope="col">Target</th>
			<th scope="col">Type</th>
			<th scope="col">Import</th>
		</tr>
		</thead>

		<tfoot>
		<tr>
			<th scope="col">Target</th>
			<th scope="col">Type</th>
			<th scope="col">Import</th>
		</tr>
		</tfoot>
		<tbody>
			<?php foreach ( $targets as $target ): ?>
			<tr>
				<td><?php echo $target['name']; ?></td>
				<td><?php echo $target['type']; ?></td>
				<td><?php echo $target['class']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
</div>