<h3><?php LocalizedString($sectionHeaderLanguageString); ?></h3>
<section class="registered-complains <?php echo $css; ?>">
	<section class="header">
		<div>#</div><div>Dato sendt inn</div><div>Kundenavn</div><div>Modellnummer</div><div>Serienummer</div><div>Kommentarer</div><div>Montør</div>
	</section>
	<section class="body">
		<?php foreach($complaints as $complaint ) { ?>
		<a class="complaint" href="admin.php?id=<?php echo $complaint->GetID(); ?>">
			<div class="id"><?php echo $complaint->GetID(); ?></div>
			<div><?php echo $complaint->GetInsertDateTime(); ?></div>
			<div><?php echo $complaint->GetCustomerFirstName().' '.$complaint->GetCustomerLastName(); ?></div>
			<div>
				<?php
				$unit = $waterPumpModelManager->GetFirstWaterPumpByComplaintId($complaint->GetID())->GetModelNumber();
				if( $unit != '') {
					echo $unit;
				} else {
					echo '###';
				}
				?>
			</div>
			<div>
				<?php
				$unit = $waterPumpModelManager->GetFirstWaterPumpByComplaintId($complaint->GetID())->GetSerialNumber();
				if( $unit != '') {
					echo $unit;
				} else {
					echo '###';
				}
				?>
			</div>
			<div><?php echo $complaint->GetDescriptionOfError(); ?></div>
			<div><?php echo $complaint->GetResellerName(); ?></div>
		</a>
		<?php } ?>
	</section>
</section>