	<style type="text/css">
		.emailNewPassword{
			position:absolute;
			top:280px;
			left:40%;
			border: 1px solid #ccc;
			width:40em;
		    height:38em;
		    margin-top: -15em; /*set to a negative number 1/2 of your height*/
		    margin-left: -15em; /*set to a negative number 1/2 of your width*/
		    border-radius: 15px;
		    box-shadow: 7px 7px 3px #888888;
		    background-color:#dedede;
		}
		.imgHeaderFrame{
			border-radius: 15px 15px 0px 0px;
			width:40em;
			margin:0px;
			padding:0px;
			position:relative;
		}
		.container{
			height:50em;
		}
		.messageText{
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
	<div class="messageText">
		<?php echo $message; ?> 
	</div> 
	</div>
</div>