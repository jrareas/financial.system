				<div class=loginframe>
				<?php  //echo $this->Html->image('members-login-right.jpg',array('class'=>'imgLogin')); ?>
					<?php echo $this->Form->create('login',array(
									    'inputDefaults' => array(
									    'label' => false,
									    'div' => false
									    )
									)); ?>
						<?php  echo $this->Html->image('financial-planning-a-pen-on-a-pile-of-charts.jpg',array('class'=>'imgHeaderFrame')); ?>
						<hr>
					<table border=0 class="loginTable">
						<tr>
							<td style="width:100px;text-align:right ">User ID
							</td>
							<td><?php echo $this->Form->input('username'); ?>
							</td>
						</tr>
						<tr>
							<td style="width:70px;text-align:right ">Password
							</td>
							<td><?php echo $this->Form->input('password'); ?>
							</td>
						</tr>
						<tr>
						<td colspan=2><hr>
							<?php //echo $this->Form->input('keepdata',array('type'=>'checkbox','label'=>'Keep my data')); ?>
						</td>
						</tr>
						<tr>
							<td colspan=2 style="text-align:right"><input type=button value="Get Password" style="text-align:right;width:100px;text-align:center" onclick='login.forgotPassword()'/>
							<span style="font-size:15">   </span>
							<input type=button value=Go style="text-align:right;width:100px;text-align:center" onclick='login.validaLogin();'/>
							<?php  echo $this->Html->image('question.png',array('class'=>'imgQuestion','onmouseover'=> "document.getElementById('hint').style.display='inline';",'onMouseOut'=>"document.getElementById('hint').style.display='none';")); ?>
							<span class=hint id=hint>
								<ul>
									<li>Fill the User ID and password before use the button Go to log in the system</li>
									<li>Fill the User ID and use the button Get Password to receive a new password by email</li>
								</ul>
							</span>
							</td>
						</tr>
					</table>
					</form>
					<span id=loginNotPossible>The information provided do not match with a valid user name or password. Please try again with a valid credential.</span>
				</div>
