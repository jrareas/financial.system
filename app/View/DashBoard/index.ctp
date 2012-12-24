<script>
	$(document).ready(function(){
		$('.ajaxLoadingTables').hide();
		tables.getFiles("#tableFile");
	});

</script>
<div id=panels style="color:black;position:relative" >
<div id=tableFiles class=paneltables>
	<div class='tables'>
		<table id=Files class=hor-minimalist-a>
		<tr>
			<th>Loading table...</th>
		</tr>
		</table>
		<img src='img/ajax-loader-white_bg.gif' class=ajaxLoadingTables>
	</div>
	<div class=panelFunctions>
		
		<div class=progressOut>Calculating...
			<div class=progressIn>
				
			</div>
		</div>
	</div>
</div>
</div>