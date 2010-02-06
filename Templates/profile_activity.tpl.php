<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<?php require_once('includes/stylesheets.inc.php'); ?>
	 
<!-- note: change the root directory to correspond to CONFIGURATION.INC.PHP files -->

<title>Profile Activity - <? echo $this->objAllyUser->FullName;?> </title>
</head>
<body>
<?php $this->RenderBegin(); ?>
<?$this->accountRequestPopup->Render();?>
<?$this->completeProfilePopup->Render();?>
<?$this->addAllyPopup->Render();?>


<div class="container prepend-top">
	
	<?php require_once('header_new.tpl.php'); ?>
	<!--convert the ally email into a gravatar md5 hash-->	
			
	<!-- this is a CONDITIONAL DIV: IF User.Ally.Contacts.Sent.Count < User.Ally.Contacts.Received.Count -->
	<!---
	<div class='span-18 push-1 box byellow' id='give_accounts'>
		<h3 class='red'>You Owe This Ally Some Contacts!</h3>
		<p>This ally has <strong>given</strong> you more contacts that you have given.  Make sure 
		you don't get known as a Taker and start losing opportunities to meet quota.  <strong>Give
		a contact right now, today!</strong></p><br />
		
		<div class='span-10'>
			<label>Account Name:</label>&nbsp;&nbsp; <input type='text' class='span-6'></input>&nbsp;
		</div>
		
		<div class='span-4 moveup5px'>
			<button type='submit'><img src='../css/blueprint/plugins/link-icons/icons/email.png'/>Send Contact</button>
		</div>
	</div> --->
	
	<div class="span-6 push-1" id="left-margin">
	<div class="span-6">
		<fieldset>
		<legend> <?= $this->objAllyUser->FullName ?> Profile </legend>
		<div class="span-5">
			<div class="span-3">
										
		<img src="http://www.gravatar.com/avatar?d=monsterid&gravatar_id=<?php md5( strtolower($this->objAllyUser->Username));?>">
			</div>
		
			<div class="span-2 last">
			    <? 
			        if(!$this->IsMyAlly()) {
                        $this->btnInviteAsAlly->Render();
                    }  
                ?>

			</div>
		</div>
		<div class="span-5">
			<hr class="space"></hr>
		</div>
		<div class="span-2 quiet" align="right">
		Company:<br /><br />
		
		Title:<br /><br />
		
		Territory:<br /><br />

		City:
		</div> <!--labels-->
		
		<div class="span-3 last">
			<strong><?= $this->objAllyAccount->Name ?></strong><br /><br />
			
			<strong><?= $this->objAllyUser->UserDetail->Territory ?></strong><br /><br />
			
			<strong><?= $this->objAllyUser->UserDetail->Region ?></strong><br /><br />
			
			<strong><?= $this->objAllyUser->UserDetail->City ?></strong>
		</div> <!--field values-->		
	</fieldset>
	</div> <!--fieldset profile-->
	
	<div class="span-6">
		<fieldset>
			<legend>Allies (3)</legend>
			<p class='small'>A <span class='green loud'>GREEN score</span> means <?= $this->objAllyUser->FullName ?>
			gave more to his ally than he received.  <span class='red'>RED </span>means
			<?= $this->objAllyUser->FullName ?> <span class='red'>received more</span> than he gave, <span class='red'>so make sure he gives when you give!</span>!</p>
			
			<? foreach($this->objAllyAllies as $alliesArray) { ?>
			    <div class="span-5">
				    <div class="span-2" id="image_column">
					    <img src="http://www.gravatar.com/avatar?size=30&d=monsterid&gravatar_id=<?= md5( strtolower($alliesArray->Username)); ?>" >				
				    </div>
				
				    <div class="span-2" id="name-co-column">
					    <a href="/profile_activity.php?aid=<?= str_replace(' ','_',$alliesArray->Id) ?>" >
					         <?= $alliesArray->FullName ?>
					    </a>
					    <br />
					    <b>
					        <?= Account::LoadById($alliesArray->AccountId)->Name ?>
					    </b>
				    </div>
			
				    <div class="span-1 last positive-give-score-column">
					    +2
				    </div>
				
				    <hr class="space"> </hr>
				
			    </div>
			<? } ?>	
		</fieldset>
	</div>
	</div> <!--left-margin-->
	
	<div class="span-8" id="feed">
		<fieldset>
			<legend>Activity Feed</legend>
		

			
			<div class="span-7 " id="target_feed">
				<img src="http://www.gravatar.com/avatar?size=15&d=monsterid&gravatar_id=$hash_ally_email">&nbsp;<a href="profile_activity.php?aid=<?= $this->objAllyUser->Id ?>"><?= $this->objAllyUser->FullName ?></a> recently added <strong>Targets:</strong><br /><br />
				<div class="span-6 push-1" id="target_feed_list">
					<?php $arrayTargets = $this->ArrayTargetsForActivityFeed($this->objAllyTargets);
					    foreach($arrayTargets as $target){
					    $accountName = $this->AccountNameForActivityFeed($target);?>
					        <a href="account_profile.php?aid=<?=$accountName->Id?>">
					            <?=$accountName->Name?>
					        </a>
                            <br />
					  <?}?>
	
				</div>
				<hr class="span-7"></hr>
			</div><!--target_feed-->
			


			<div class="span-7" id="receive_contact_feed">
				<img src="http://www.gravatar.com/avatar?size=15&d=monsterid&gravatar_id=$hash_ally_email">&nbsp;
				  <a href="profile_activity.php?aid=<?= $this->objAllyUser->Id ?>"><?= $this->objAllyUser->FullName ?></a> received a <strong>Contact</strong> at:<br /><br />
				<div class="span-6 push-1" id="receive_contact_feed_list">
				    <?php $receivedArray = $this->ArrayThreadForActivityFeed($this->objAllyReceive);?>
					<?foreach($receivedArray as $resiveFrom){
					        $accountName = $this->AccountNameForActivityFeed($resiveFrom);
					        $userName = $this->NameOfResiverForActivityFeedThread($resiveFrom);?>
				            <a href="account_profile.php?aid=<?=$accountName->Id?>">
				                <?=$accountName->Name?>
				            </a> from 
				            
				            <a href="profile_activity.php?aid=<?=$userName->Id?>">
				                <?=$userName->FullName?>
				            </a>
                            <br />
					 <?}?>
					</div> <!--receive_contact_feed_list-->
				
				<hr class="span-7"></hr>
			</div><!--receive_contact_feed-->			

			<div class="span-7" id="send_contact_feed">
				<img src="http://www.gravatar.com/avatar?size=15&d=monsterid&gravatar_id=$hash_ally_email">&nbsp;
				   <a href="profile_activity.php?aid=<?= $this->objAllyUser->Id ?>"><?= $this->objAllyUser->FullName ?></a> sent a <strong>Contact</strong> at:<br /><br />
				<div class="span-6 push-1" id="send_contact_feed_list">
				    <? $sendArray = $this->ArrayThreadForActivityFeed($this->objAllySend); ?>
					<? foreach($sendArray as $sendTo) { 
					        $accountName = $this->AccountNameForActivityFeed($sendTo);
					        $userName = $this->NameOfSenderForActivityFeedThread($sendTo); ?>
				            <a href="account_profile.php?aid=<?=$accountName->Id?>">
				                <?=$accountName->Name?>
				            </a> to 
				            
				            <a href="profile_activity.php?aid=<?=$userName->Id?>">
				                <?=$userName->FullName?>
				            </a>
                            <br />
					<?}?>
				</div> <!--send_contact_feed_list-->
				
				<hr class="span-7"></hr>
			</div><!--send_contact_feed-->

			<div class="span-7" id="offer_feed">
				<img src="http://www.gravatar.com/avatar?size=15&d=monsterid&gravatar_id=$hash_ally_email">&nbsp;
				   <a href="profile_activity.php?aid=<?= $this->objAllyUser->Id ?>"><?= $this->objAllyUser->FullName ?></a> can <strong>Offer</strong> up:<br /><br />
				<div class="span-6 push-1" id="send_contact_feed_list">
					<? $arrayOffers = $this->ArrayOffersForActivityFeed($this->objAllyOffers);?>
     				<? foreach($arrayOffers as $offer){
					        $accountName = $this->AccountNameForActivityFeed($offer);?>
					        <a href="account_profile.php?aid<?=$accountName->Id?>">
					            <?=$accountName->Name?>
					        </a>
                            <br />
					<?}?>
				</div> <!--send_contact_feed_list-->
				
				<hr class="span-7"></hr>
			</div><!--send_contact_feed-->
			
			<a href="More>>">More>></a>			
		</fieldset>
	</div> <!--feed-->
	
	<div class="span-6 last" id="right-profile">
		<div class="span-5 last" id="want-contacts">
			<fieldset>
				<legend id="green"><?= $this->objAllyUser->FullName ?> Wants Contacts</legend>
	            <div>
	                <? $limit=(count($this->Targets_Array($this->objUserOffers))<5?count($this->Targets_Array($this->objUserOffers)):5); ?>
	                <? for($i = 0; $i < $limit; $i++) {?>
				        <div>	            
                            <? $targets = $this->Targets_Array($this->objUserOffers); ?>
                            <a href="/account_detail.php?accountId=<?= $targets[$i]->Id ?>&allyId=<?= 15 ?>"> 
                                <?= $targets[$i]->Name ?>
                            </a>
				        </div>
				    <? } ?>
	            </div>
			</fieldset>
		</div>
		
		<div class="span-5 last" id="has-contacts">
			<fieldset>
				<legend id="red"> <?= $this->objAllyUser->FullName ?> Has Contacts </legend>
				<div class='quiet small'>
				    <strong>Click</strong> Account to request a contact!
				</div>
				<div> 
				 <?foreach($this->arrAllyOffersButtons as $allyOffersButton){
				    $allyOffersButton->Render();
				    ?>
				    <br />
				    <?
				 }?>
				</div> 
			</fieldset>
		</div>
		
	</div>
		<div>
		<style type="text/css">

		
	</style>
		</div>
</div>
<? $this->RenderEnd(); ?>
</body>
</html>
