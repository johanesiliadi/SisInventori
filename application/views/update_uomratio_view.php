	
					 <!--Content-->
					 <fieldset><legend>UPDATE UOM RATIO</legend>		
							<?php echo form_open('uomratio/edit_uomratio'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="910px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="9%">Name</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'name','name'=>'name','disabled'=> 'disabled'),$uomratio['name']);?></td>
								<td width="10%">&nbsp;<?= form_hidden('hidden_id',$uomratio['id']);?>
								<input type="hidden" id="edit_mode" name="edit_mode" value="<?=$edit_mode?>"></td>
								<td width="9%">&nbsp;</td>
								<td width="1%">&nbsp;</td>
								<td width="15%">&nbsp;</td>
								</tr>
								<tr>
								<td width="9%">Uom ratio 1</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'ratio1','name'=>'ratio1','disabled'=> 'disabled'),$uomratio['ratio1']);?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">uom 1</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_dropdown('id_uom1', $uoms, $uomratio['uom_id1'],'id="id_uom1" disabled');?></td>
								</tr>
								<tr>
								<td width="9%">Uom ratio 2</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'ratio2','name'=>'ratio2','disabled'=> 'disabled'),$uomratio['ratio2']);?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">uom 2</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_dropdown('id_uom2', $uoms, $uomratio['uom_id2'],'id="id_uom2" disabled');?></td>
								</tr>
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="ok" value=" " id="ok">
							<input type="button" class="buttonEdit" name="edit" value=" " id="edit">
							<input type="button" class="buttonCancel" name="cancel" value=" " id="cancel" onclick="location.href='<?php echo base_url();?>uomratio/index'">
						</p>
						<?php echo form_close(); ?> 
<script type="text/javascript">

	 $(document).ready(function() {
	 
			$("#id_uom1").searchable();
			$("#id_uom2").searchable();
	 		jQuery(function($) {
          		$('#ratio1').autoNumeric('init', {aDec: '.' , aSep: ','}); 
          		$('#ratio2').autoNumeric('init', {aDec: '.' , aSep: ','}); 
  			});
	 		function edit_mode(){
				$('#name').removeAttr('disabled');
				$('#ratio1').removeAttr('disabled');
				$('#ratio2').removeAttr('disabled');
				$('#id_uom1').removeAttr('disabled');
				$('#id_uom2').removeAttr('disabled');
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
			
			$("#ok").click(function() {	
				$('#ratio1').val($('#ratio1').val().replace(/[^0-9\.]+/g,""));
				$('#ratio2').val($('#ratio2').val().replace(/[^0-9\.]+/g,""));
			});
			
	 });
</script>		
					</fieldset>
					
					
					 