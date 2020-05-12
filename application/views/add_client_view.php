	
					 <!--Content-->
					 <fieldset><legend>ADD CLIENT</legend>		
							<?php echo form_open('client/create_client'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Code</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'short_name','name'=>'short_name'),set_value('short_name'));?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Name</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'name','name'=>'name','size'=>'70'),set_value('name'));?></td>
								</tr>
								<tr>
								<td>Address</td>
								<td>:</td>
								<td><?= form_textarea(array('id' => 'address','name'=>'address','rows'=>'5','cols'=>'40'),set_value('address'));?></td>
								<td>&nbsp;</td>
								<td>Information</td>
								<td>:</td>
								<td><?= form_textarea(array('id' => 'remark','name'=>'remark','rows'=>'5','cols'=>'40'),set_value('remark'));?></td>
								</tr>
								<tr>
								<td>Phone</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'phone_number1','name'=>'phone_number1'),set_value('phone_number1'));?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								</tr>
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="search" value=" ">
							<input type="button" class="buttonReset" name="reset" value=" " id="reset">
							<input type="button" class="buttonCancel" name="cancel" value=" " id="cancel" onclick="location.href='<?php echo base_url();?>client/index'">
						</p>
						<?php echo form_close(); ?> 
		<script type="text/javascript">

	 $(document).ready(function() {
			$("#reset").click(function() {
				$('#name').val('');	
				$('#short_name').val('');	
				$('#address').val('');	
				$('#remark').val('');	
				$('#phone_number1').val('');	
			});
	 });
	</script>		
					</fieldset>
					 