<div id=tableList>
	<table id=<?php echo $tableName; ?>>
		<tr id=tableheader >
			<?php foreach($fields as $field): ?>
				<th>
					<?php 
						if(isset($fieldMap)){
							echo $fieldMap[$field];
						}else{
							echo $field;
						}
					?>
				</th>
			<?php endforeach;?>
		</tr>
	</table>
	<?php if (isset($functions)): ?>
			
	<?php endif; ?>
</div>