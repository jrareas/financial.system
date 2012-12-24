<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = 'Financial Information System';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
	$this->start('head');
	echo $this->element('head');
	$this->end();
	echo $this->fetch('head');
?>
<script>
	$(document).ready(function(){
		var ls = $(":input");
		$("input").change(function(){
			$(".saved").hide();
		});
	});
</script>
<body>
	<div id="container">
		<div class="dashboard">
			<div id=fixedDiv>
			
			<?php 
				$this->start('header');
				echo $this->element('header/main');
				$this->end();
				echo $this->fetch('header');
			?>
			<hr>
			<div id=menu>
				<?php 
					$this->start('menu');
					echo $this->element('menuvertical');
					$this->end();
					echo $this->fetch('menu');
				?>			</div>
			</div>
			<div id="content">
			
							
				<?php echo $this->Session->flash(); ?>
				
					<div id=stylized class=myform>
					<div class=saved> The data was saved!
					</div>
					<table id=form>
					<?php 
						echo $this->Form->create($model,array('onsubmit'=>'return f.saveForm(this)','name'=>$model));
						//print_r($this);
					?>	
					<h1><?php echo $model;?></h1>
					<?php foreach($this->data[$model] as $key=>$value):?>
						
						<?php //if(in_array('fields',$view_params))?>
						<?php if($key=='id' || $key=='user_id'):?>
							<?php echo $this->Form->input($key,array('type'=>'hidden',"div"=>false,'label'=>false)); ?>
						<?php else:?>
						<tr>
							<td>
								<label for=<?php echo $model . str_replace(" ","",ucwords(str_replace('_'," ",$key))) ?> ><?php echo (isset($map[$key])) ? $map[$key]: $key;?></label>
							</td>
							<td>
								<?php echo $this->Form->input($key,array("div"=>false,'label'=>false,'type'=>(isset($view_params['checkbox']) && in_array($key,$view_params['checkbox'])) ?"checkbox":'text'));?>
							</td>
						</tr>
						<?php endif;?>
					<?php endforeach;?>
						<tr>
							<td colspan=2><?php echo $this->Form->input('Go',array('label'=>false,'div'=>false,'type'=>'submit'));?><div class=ajaxLoadForm><?php echo $this->Html->image('ajax-loader_form.gif') ?></div> </td>
						</tr>
					
					
					</form>
					</table>
					
					</div>
				
				
				<?php //echo $this->fetch('content'); ?>
			</div>
			<div id="footer">
				<?php echo $this->Html->link(
						$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
						'http://www.cakephp.org/',
						array('target' => '_blank', 'escape' => false)
					);
				?>
			</div>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
