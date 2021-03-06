<?php require_once('includes/header.inc.php'); ?>
<?php require_once(__TEMPLATES__ . "/body.global.tpl.php") ?>
	<?php $select_home = "0" ;?>
	<?php $select_allies = "0" ;?>
	<?php $select_threads = "0" ;?>
	<?php $select_targets = "here" ;?>
<?php $this->RenderBegin(); ?>
	    
<div class="container" id="targets">
	<?php require_once(__TEMPLATES__ . "/header_new.tpl.php") ?>
	
	<div id="add_target">
		<h2>Add Target Accounts</h2>
				
		<div class="popup">  
			<a href="javascript:void(0)" onclick="window.open('target_popup.php','targets',
			'width=500, height=500, screenX=600')" class="button positive">
 				Cut and Paste More Targets
				(Pop-Up)
			</a>			
		</div>	
		  
			<span id="loader_ctl" style="display: none;">
				<img src="images/loader.gif" id="loader">
			</span>
		  
			<?php $this->pnlAddTarget->Render(); ?>			
	</div> <!--add_target-->
	
	<div id="target_explain">
		<h2>Why Add Target Accounts?</h2>
		<p><span>Target Accounts</span> are those companies that you would like your allies to
		give you contacts and insight into.  The more you have, the better.</p>
		
		<p>To add <span>Target Accounts</span> by cutting and pasting a list (one company per line),
		click on the link below.</p>
	
	</div>	  
	
	 <div id="target_list">		

       	<?php $this->dtgTargets->Render(); ?>
        
     </div><!-- /target-list-->

   	<?php require_once(__TEMPLATES__ . "/footer.global.tpl.php") ?>
	<?php $this->RenderEnd(); ?> 
</div><!-- container-->
</body>
</html>
