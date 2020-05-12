	
					 <!--Content-->
					 <fieldset><legend>UPDATE PASSWORD</legend>		
							<?php echo form_open('user/edit_password'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="910px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="9%">Old password</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_password(array('id' => 'old_password','name'=>'old_password'));?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">&nbsp;</td>
								<td width="1%">&nbsp;</td>
								<td width="15%">&nbsp;</td>
								</tr>
								<tr>
								<td width="9%">New password</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_password(array('id' => 'password','name'=>'password'));?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">&nbsp;</td>
								<td width="1%">&nbsp;</td>
								<td width="15%">&nbsp;</td>
								</tr>
									<tr>
								<td width="9%">Repeat new password</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_password(array('id' => 'password2','name'=>'password2'));?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">&nbsp;</td>
								<td width="1%">&nbsp;</td>
								<td width="15%">&nbsp;</td>
								</tr>
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="ok" value=" ">
							<input type="button" class="buttonReset" name="reset" value=" " id="reset">
							<input type="button" class="buttonBack" name="back" value=" " id="back" onclick="location.href='<?php echo base_url();?>login/home'">
						</p>
						<?php echo form_close(); ?> 
		<script type="text/javascript">

	 $(document).ready(function() {
			$("#reset").click(function() {	
				$('#old_password').val('');	
				$('#password2').val('');	
				$('#password').val('');	
			});
	 });
	</script>		
					</fieldset>
					 