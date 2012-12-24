	<style type="text/css">
		.emailNewPassword{
			position:absolute;
			top:200px;
			left:30%;
			border: 1px solid #ccc;
			width:50em;
		    height:48em;
		    margin-top: -15em; /*set to a negative number 1/2 of your height*/
		    margin-left: -15em; /*set to a negative number 1/2 of your width*/
		    border-radius: 15px;
		    box-shadow: 7px 7px 3px #888888;
		    background-color:#dedede;
		}
		.imgHeaderFrame{
			border-radius: 15px 15px 0px 0px;
			width:50em;
			margin:0px;
			padding:0px;
			position:relative;
		}
		.container{
			height:50em;
		}
		.emailText{
			margin:10px;
		}
		hr{
			margin:0px;
			padding:0px;
		}
	</style>
<div class="container">
	<div class=emailNewPassword>
	<img class="imgHeaderFrame" src="data:image/jpeg;base64, <?php echo base64_encode(file_get_contents("img/financial-planning-a-pen-on-a-pile-of-charts.jpg")); ?>" >
	<hr>
	<div class="emailText">
	Hello 
	<?php echo $fullName; ?>,<br>
	<p>
	You are receiving this email because a new password was requested for you or in your behalf. If it is not true, you can just ignore it.
	</p>
	<p>
	Your new password is <?php echo $newPassword; ?>
	</p>
	<p>
	The link below must be used in order to the system confirm the request and change your password.
	</p>
	<p>
	<?php echo $linkConfirmation; ?>
	</p>
	<p>
	Enjoy the system
	</p>
	
	</div> 
	</div>
</div>