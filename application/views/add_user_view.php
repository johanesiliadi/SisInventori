	
					 <!--Content-->
					 <fieldset><legend>ADD USER</legend>		
							<?php echo form_open('user/create_user'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="910px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="9%">Full name</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'name','name'=>'name'),set_value('name'));?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">username</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'username','name'=>'username'),set_value('username'));?></td>
								</tr>
									<tr>
								<td width="9%">Password</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_password(array('id' => 'password','name'=>'password'),set_value('password'));?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">Confirm password</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_password(array('id' => 'password2','name'=>'password2'),set_value('password2'));?></td>
								</tr>
								
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="search" value=" ">
							<input type="button" class="buttonReset" name="reset" value=" " id="reset">
							<input type="button" class="buttonCancel" name="cancel" value=" " id="cancel" onclick="location.href='<?php echo base_url();?>user/index'">
						</p>
						<?php echo form_close(); ?> 
		<script type="text/javascript">

	 $(document).ready(function() {
			$("#reset").click(function() {
				$('#password2').val('');	
				$('#password').val('');	
			});
	 });
	</script>		
					</fieldset>
					 