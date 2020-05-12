	
					 <!--Content-->
					 <fieldset><legend>ADD UOM RATIO</legend>		
							<?php echo form_open('uomratio/create_uomratio'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Name</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'name','name'=>'name'),set_value('name'));?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">&nbsp;</td>
								<td width="1%">&nbsp;</td>
								<td width="28%">&nbsp;</td>
								</tr>
								<tr>
								<td>Uom ratio 1</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'ratio1','name'=>'ratio1'),set_value('ratio1'));?></td>
								<td>&nbsp;</td>
								<td>Uom 1</td>
								<td>:</td>
								<td><?= form_dropdown('id_uom1', $uoms, set_value('id_uom1'),'id="id_uom1" ');?></td>
								</tr>
								<tr>
								<td>Uom ratio 2</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'ratio2','name'=>'ratio2'),set_value('ratio2'));?></td>
								<td>&nbsp;</td>
								<td>Uom 2</td>
								<td>:</td>
								<td><?= form_dropdown('id_uom2', $uoms, set_value('id_uom2'),'id="id_uom2" ');?></td>
								</tr>
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="search" value=" " id="ok">
							<input type="button" class="buttonReset" name="reset" value=" " id="reset">
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
			$("#reset").click(function() {	
				$('#id_uom1').prop('selectedIndex', 1); 	
				$('#id_uom2').prop('selectedIndex', 1); 	
				$('#name').val('');	
				$('#ratio1').val('');	
				$('#ratio2').val('');	
			});
			
			$("#ok").click(function() {	
				$('#ratio1').val($('#ratio1').val().replace(/[^0-9\.]+/g,""));
				$('#ratio2').val($('#ratio2').val().replace(/[^0-9\.]+/g,""));
			});
	 });
	</script>		
					</fieldset>
					 