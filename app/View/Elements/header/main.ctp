<div id="header">
	<span class=ajaxLoading><?php  echo $this->Html->image('ajax-loader.gif'); ?> Loading...Please wait!</span>
	<?php if(isset($fullName)): ?>
	<div id='welcome'>
		Welcome <?php echo $fullName; ?><br>
		Your Last login was <?php echo $lastLogin; ?><br>
		Your session will exprire in <span id=sessionTimeExpiration></span>
	</div>
	<?php endif;?>
</div>
