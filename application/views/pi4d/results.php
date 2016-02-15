<?php if(!$success) { ?>
<div class="row">
	<div class="col-xs-12 text-center">
		<h1>4D Results<br><span class="text-muted">Results Retrieval Failed</span></h1>
		<span class="text-muted">
		Reason: <?php echo($reason); ?>
		<br>
		Last Updated <?php echo(date("H:i:s d/m/Y")); ?>
		</span>
	</div>
</div>
<?php } else { ?>
<div class="row">
	<div class="col-xs-12 text-center">
		<h1>4D Results<br><span class="text-muted"><?php echo(date("D, d M Y", $resulttimestamp)); ?></span></h1>
		<span class="text-muted">Last Updated <?php echo(date("H:i:s d/m/Y")); ?></span>
	</div>
</div>
<div class="row text-center top3">
	<div class="col-xs-4 top3-1st">
		<h3>1st Prize</h3>
		<h3><?php echo($data['top3'][0]); ?></h3>
	</div>
	<div class="col-xs-4 top3-2nd">
		<h3>2nd Prize</h3>
		<h3><?php echo($data['top3'][1]); ?></h3>
	</div>
	<div class="col-xs-4 top3-3rd">
		<h3>3rd Prize</h3>
		<h3><?php echo($data['top3'][2]); ?></h3>
	</div>
</div>

<div class="row starters">
	<div class="col-xs-12">
		<h3>Starters</h3>
	</div>
</div>

<div class="text-center starters">
	
	<?php for($i = 0; $i < count($data['starters']); $i++) { ?>
		<?php if($i == 0 || $i == 5) { ?>
		<div class="row">
			<div class="col-xs-1"></div>
		<?php } ?>
			<div class="col-xs-2">
				<h3><?php echo($data['starters'][$i]); ?></h3>
			</div>
		<?php if($i == 4 || $i == 9) { ?>
			<div class="col-xs-1"></div>
		</div>
		<?php } ?>
	<?php } ?>
	
</div>

<div class="row consolation">
	<div class="col-xs-12">
		<h3>Consolation</h3>
	</div>
</div>

<div class="text-center consolation">

	<?php for($i = 0; $i < count($data['consolation']); $i++) { ?>
		<?php if($i == 0 || $i == 5) { ?>
		<div class="row">
			<div class="col-xs-1"></div>
		<?php } ?>
			<div class="col-xs-2">
				<h3><?php echo($data['consolation'][$i]); ?></h3>
			</div>
		<?php if($i == 4 || $i == 9) { ?>
			<div class="col-xs-1"></div>
		</div>
		<?php } ?>
	<?php } ?>
	
</div>

<?php } ?>