<div id="mail-form">
	<div class="background"></div>
	<div id="content">
		<h1><?php LocalizedString('CONTACT'); ?></h1>
		<div id="text">
			<div id="form">
			
				<div><?php LocalizedString('NAME'); ?></div>
				<input id="input-name" type="text" name="name" value="" />
				
				<div><?php LocalizedString('EMAIL'); ?></div>
				<input id="input-email" type="text" name="email" value="" />
				
				<div><?php LocalizedString('MESSAGE'); ?></div>
				<textarea id="input-message" name="message" rows="10" cols="60"></textarea>
			
				<div id="submit-button"><?php LocalizedString('SEND'); ?></div>
			
				<div id="status-message"></div>
			</div>
		</div>
	</div>
</div>