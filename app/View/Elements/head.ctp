<head>
	<link href="data:image/x-icon;base64,AAABAAEAEBAQAAAAAAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAlcDMALTj8AApU14AT2tzAPDw8gCm0t4AkcHPAED1/wCi4/UAttXeAIqwugCIv88AmNPjAAAAAAAAAAAAAAAFVVVQAzAAM1u7u7U4gwOIPZSdy7MwBTPURETcy1AFuZmUlJ3LUAW5lEREmdtQBbmUlJmZ21AFuZRERJnbUABbuZSZm7UAAAVb1yy1UAAABbGXZ8tQAABbkSeWebUAAFtym7tntQAABbu6qrtQAAAAVVAAVQAAAAAAAAAAAAD4GQAAwAAAAIABAACAAQAAgAEAAIABAACAAQAAgAEAAMADAADgBwAA4AcAAMADAADAAwAA4AcAAPHPAAD//wAA" rel="icon" type="image/x-icon" />
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php 
			$cakeDescription = 'Financial Information System';
			echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		//echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('financial');
		echo $this->Html->css('menu');
		echo $this->Html->css('forms');
		echo $this->Html->css('dashboard');
		echo $this->Html->script('jquery-1.8.3.min.js');
		echo $this->Html->script('login');
		echo $this->Html->script('general');
		echo $this->Html->script('tables');
		echo $this->Html->script('forms');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	
	<script type="text/javascript">
		$(document).ready(function(){
			//alert('ready');
			setTimeout(countDown,1000);
			navHover();	
		});
	</script>
</head>
