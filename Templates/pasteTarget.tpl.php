<div id="target_popup_c">
	<div id="title">
		<?php $this->lblTitle->Render();?>
	</div>	
	<div id="target_list_popup">
		<form name="target_popup_form" action="target_popup.php" method="post">
			<input type="hidden" name="pop" value="2">
			<?php $this->txtStrings->Render(); ?>
			<div id="submit">
				<?php $this->btnSubmit->Render(); ?></td><td>&nbsp;<a href="javascript: self.close ()">cancel</a>
			</div>	
		</form>
	</div>	
</div>