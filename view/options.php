<?php $targets = MetathesisPlugin::targets(); ?>
<style type="text/css" media="screen">
	#icon-metathesis {
		background: url("<?php echo plugin_dir_url(__FILE__); ?>img/backyard-view_32.png") no-repeat center center;
	}
</style>
<div class="wrap">
	<div class="icon32" id="icon-metathesis"><br></div>
	<h2>Metathesis</h2>
	<p>Migrate your SEO goodness and other metadata from one theme or plugin to another WordPress theme or plugin.</p>
	
	<h3>Supported Plugins and Themes</h3>
	
	<table cellspacing="0" class="widefat metathesis fixed">
		<thead>
			<tr>
				<th scope="col" style="width: 50%">Target</th>
				<th scope="col">Type</th>
				<th scope="col">Source</th>
				<th scope="col">Import/Export</th>
			</tr>
		</thead>

		<tfoot>
			<tr>
				<th scope="col">Target</th>
				<th scope="col">Type</th>
				<th scope="col">Source</th>
				<th scope="col">Import/Export</th>
			</tr>
		</tfoot>
		<tbody>
			<?php $i = 0; foreach ( $targets as $target ): $class = ( $i % 2 ) ? 'class="alternate"' : ''; ?>
			<tr <?php echo $class; ?>>
				<td>
					<?php echo $target['target']; ?>
					<br /><small><?php echo $target['desc']; ?></small>
				</td>
				<td><?php echo $target['type']; ?></td>
				<td><?php echo $target['source']; ?></td>
				<td>
					<form action="" method="post" accept-charset="utf-8">
						<?php wp_nonce_field('metathesis_nonce', 'metathesis_nonce', true, true ); ?> 
						<input type="hidden" name="metathesis_class" value="<?php echo $target['class']; ?>" />
						<input type="submit" name="metathesis_submit" value="<?php echo $target['button']; ?>" class="button" />
					</form>
				</td>
			</tr>
			<?php $i++; endforeach; ?>
		</tbody>
	</table>
</div>