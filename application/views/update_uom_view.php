	
					 <!--Content-->
					 <fieldset><legend>EDIT UOM</legend>		
							<?php echo form_open('uom/edit_uom'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="910px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="9%">Short name</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'short_name','name'=>'short_name','disabled'=> 'disabled'),$uom['short_name']);?></td>
								<td width="10%">&nbsp;<?= form_hidden('hidden_id',$uom['id']);?>
								<input type="hidden" id="edit_mode" name="edit_mode" value="<?=$edit_mode?>"></td>
								<td width="9%">Long name</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'long_name','name'=>'long_name','disabled'=> 'disabled'),$uom['long_name']);?></td>
								</tr>
								
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="ok" value=" " id="ok">
							<input type="button" class="buttonEdit" name="edit" value=" " id="edit">
							<input type="button" class="buttonCancel" name="cancel" value=" " id="cancel" onclick="location.href='<?php echo base_url();?>uom/index'">
						</p>
						<?php echo form_close(); ?> 
<script type="text/javascript">

	 $(document).ready(function() {
	 		function edit_mode(){
				$('#long_name').removeAttr('disabled');
				$('#short_name').removeAttr('disabled');
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
					
					
					 