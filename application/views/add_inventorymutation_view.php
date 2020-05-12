	
					 <!--Content-->
					 <fieldset><legend>ADD NEW MUTATION</legend>		
							<?php echo form_open('inventorymutation/create_inventorymutation'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Inventory</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_dropdown('inventory_id', $inventories, set_value('inventory_id'),'id="inventory_id"');?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Type</td>
								<td width="1%">:</td>
								<td width="28%"><?php $options = array(
							                   '0'  => 'Increase',
							                   '1'    => 'Decrease',
							                 );
									echo form_dropdown('type', $options, set_value('type'),'id="type"');
 
								 ?></td>
								</tr>
								<tr>
								<td>Quantity</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'quantity','name'=>'quantity'),set_value('quantity'));?></td>
								<td>&nbsp;</td>
								<td>UOM</td>
								<td>:</td>
								<td><?= form_dropdown('uom_id', $uoms, set_value('uom_id'),'id="uom_id"');?></td>
								</tr>
								<tr>
								<td>Remarks</td>
								<td>:</td>
								<td><?= form_textarea(array('id' => 'remarks','name'=>'remarks','rows'=>'5','cols'=>'40'),set_value('remarks'));?></td>
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
							<input type="submit" class="buttonOK" name="add" value=" " id="add">
							<input type="button" class="buttonReset" name="reset" value=" " id="reset">
							<input type="button" class="buttonCancel" name="cancel" value=" " id="cancel" onclick="location.href='<?php echo base_url();?>inventorymutation/index'">
						</p>
						<?php echo form_close(); ?> 
		<script type="text/javascript">

	 $(document).ready(function() {
	 
	 
			$("#uom_id").searchable();
			$("#inventory_id").searchable();
			$("#type").searchable();
		  jQuery(function($) {
	          		$('#quantity').autoNumeric('init', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
	  	});
			$("#reset").click(function() {
				$('#inventory_id').prop('selectedIndex', 1); 	
				$('#type').prop('selectedIndex', 1); 	
				$('#uom_id').prop('selectedIndex', 1); 	
				$('#quantity').val('');	
				$('#remarks').val('');
			});
			
			$("#add").click(function() {
				var confirmation = "Please confirm the data";
				confirmation = confirmation + '\n' + 'Type: ' + $("#type").find("option:selected").text();

				confirmation = confirmation + '\n' + 'Inventory: ' + $("#inventory_id").find("option:selected").text();
				confirmation = confirmation + '\n' + 'Quantity: ' + $("#quantity").val() + ' ' + $("#uom_id").find('option:selected').text();
				confirmation = confirmation + '\n' + 'Remarks: ' + $("#remarks").val();
				$('#quantity').val($('#quantity').val().replace(/[^0-9\.]+/g,""));
				return confirm(confirmation);
			});
	 });
	</script>		
					</fieldset>
					 