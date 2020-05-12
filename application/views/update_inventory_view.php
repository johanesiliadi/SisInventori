	
					 <!--Content-->
					 <fieldset><legend>UPDATE INVENTORY</legend>		
							<?php echo form_open('inventory/edit_inventory'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Item Code</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'item_code','name'=>'item_code', 'disabled'=> 'disabled'),$inventory['item_code']);?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Item Name</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'item_name','name'=>'item_name','size'=>'50','disabled'=> 'disabled'),$inventory['item_name']);?></td>
								</tr>
								<tr>
								<td>Quantity</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'quantity','name'=>'quantity', 'disabled'=> 'disabled'),$inventory['quantity']);?></td>
								<td>&nbsp;<input type="hidden" id="edit_mode" name="edit_mode" value="<?=$edit_mode?>"><?= form_input(array('name' => 'hidden_id', 'type'=>'hidden', 'id' =>'hidden_id'),$inventory['id']);
;?></td>
								<td>Uom</td>
								<td>:</td>
								<td><?= form_dropdown('uom_id', $uoms, $inventory['uom_id'],'id="uom_id" disabled');?></td>
								</tr>
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
					<p class="button">
							<input type="submit" class="buttonOK" name="ok" value=" " id="ok">
							<input type="button" class="buttonEdit" name="edit" value=" " id="edit">
							<input type="button" class="buttonCancel" name="cancel" value=" " id="cancel" onclick="location.href='<?php echo base_url();?>inventory/index'">
						</p>
						<?php echo form_close(); ?> 
		<script type="text/javascript">
 		$(document).ready(function() {
		
			$("#uom_id").searchable();
			jQuery(function($) {
          		$('#quantity').autoNumeric('init', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
  			});
			
	 		function edit_mode(){
				$('#item_code').removeAttr('disabled');
				$('#item_name').removeAttr('disabled');
				$('#quantity').removeAttr('disabled');
				$('#uom_id').removeAttr('disabled');
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
				$('#quantity').val($('#quantity').val().replace(/[^0-9\.]+/g,""));	
			});
			
	 });
	</script>		
					</fieldset>
					 