	
					 <!--Content-->
					 <fieldset><legend>UPDATE USER</legend>		
							<?php echo form_open('user/edit_user'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="910px" cellpadding="0">
						
							<tbody>
								<tr><td width="9%">Username</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'username','name'=>'username','disabled'=> 'disabled'),$user['username']);?></td>
							
								<td width="10%">&nbsp;<?= form_hidden('hidden_id',$user['id']);?>
								<?= form_hidden('hidden_username',$user['username']);?>
								<input type="hidden" id="edit_mode" name="edit_mode" value="<?=$edit_mode?>"></td>
								<td width="9%">Full name</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'name','name'=>'name','disabled'=> 'disabled'),$user['name']);?></td>
									</tr>
								
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="ok" value=" " id="ok">
							<input type="button" class="buttonEdit" name="edit" value=" " id="edit">
							<input type="button" class="buttonCancel" name="cancel" value=" " id="cancel" onclick="location.href='<?php echo base_url();?>user/index'">
						</p>
						<?php echo form_close(); ?> 
<script type="text/javascript">

	 $(document).ready(function() {
	 		function edit_mode(){
				$('#name').removeAttr('disabled');
				//$('#username').removeAttr('disabled');
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
					
					
					 