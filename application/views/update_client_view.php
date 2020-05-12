	
					 <!--Content-->
					 <fieldset><legend>EDIT CLIENT</legend>		
							<?php echo form_open('client/edit_client'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Kode</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'short_name','name'=>'short_name','disabled'=> 'disabled'),$client['code']);?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Name</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'name','name'=>'name','size'=>'70','disabled'=> 'disabled'),$client['name']);?></td>
								</tr>
								<tr>
								<td>Address</td>
								<td>:</td>
								<td><?= form_textarea(array('id' => 'address','name'=>'address','rows'=>'5','cols'=>'40','disabled'=> 'disabled'),$client['address']);?></td>
								<td>&nbsp;</td>
								<td>Information</td>
								<td>:</td>
								<td><?= form_textarea(array('id' => 'remark','name'=>'remark','rows'=>'5','cols'=>'40','disabled'=> 'disabled'),$client['information']);?></td>
								</tr>
										<tr>
								<td>Phone</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'phone_number1','name'=>'phone_number1','disabled'=> 'disabled'),$client['phone']);?></td>
								<td>&nbsp;</td>
								<td><?= form_hidden('hidden_id',$client['id']);?></td>
								<td><input type="hidden" id="edit_mode" name="edit_mode" value="<?=$edit_mode?>"></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								</tr>
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="ok" value=" " id="ok">
							<input type="button" class="buttonEdit" name="edit" value=" " id="edit">
							<input type="button" class="buttonCancel" name="cancel" value=" " id="cancel" onclick="location.href='<?php echo base_url();?>client/index'">
						</p>
						<?php echo form_close(); ?> 
		<script type="text/javascript">

	 $(document).ready(function() {
	 		function edit_mode(){
				$('#name').removeAttr('disabled');
				$('#short_name').removeAttr('disabled');
				$('#address').removeAttr('disabled');
				$('#remark').removeAttr('disabled');
				$('#phone_number1').removeAttr('disabled');
				$("#edit").hide();
				$("#ok").show();
			}
			
			if($("#edit_mode").val() == 'TRUE'){
				edit_mode();
			}else{
				$("#ok").hide();
			}
			
			$("#edit").click(function() {
				edit_mode();
			});
			
			
	 });
</script>	
					</fieldset>
					 