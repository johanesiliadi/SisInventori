	
					 <!--Content-->
					 <fieldset><legend>ADD INVENTORY</legend>		
							<?php echo form_open('inventory/create_inventory'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Item code</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'item_code','name'=>'item_code'),set_value('item_code'));?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Item name</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'item_name','name'=>'item_name', 'size'=>'50'),set_value('item_name'));?></td>
								</tr>
								<tr>
								<td>Quantity</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'quantity','name'=>'quantity'),set_value('quantity'));?></td>
								<td>&nbsp;</td>
								<td>Uom</td>
								<td>:</td>
								<td><?= form_dropdown('uom_id', $uoms, set_value('uom_id'),'id="uom_id" style="width:100px;"');?></td>
								</tr>
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="search" value=" " id="ok">
							<input type="button" class="buttonReset" name="reset" value=" " id="reset">
							<input type="button" class="buttonCancel" name="cancel" value=" " id="cancel" onclick="location.href='<?php echo base_url();?>inventory/index'">
						</p>
						<?php echo form_close(); ?> 
		<script type="text/javascript">

	 $(document).ready(function() {
	 
			$("#uom_id").chosen();
	 		jQuery(function($) {
          		$('#quantity').autoNumeric('init', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
  			});

	 
			$("#reset").click(function() {	
				$('#uom_id').prop('selectedIndex', 1); 		
				$('#item_code').val('');	
				$('#item_name').val('');	
				$('#quantity').val('');	
			});
			
			$("#ok").click(function() {	
				$('#quantity').val($('#quantity').val().replace(/[^0-9\.]+/g,""));
			});
	 });
	</script>		
					</fieldset>
					 