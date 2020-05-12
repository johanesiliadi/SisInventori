	
					 <!--Content-->
					 <fieldset><legend>ADD UOM</legend>		
							<?php echo form_open('uom/create_uom'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Short name</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'short_name','name'=>'short_name'),set_value('short_name'));?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Long name</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'long_name','name'=>'long_name', 'size'=>'50'),set_value('long_name'));?></td>
								</tr>
							</tbody>
							</table>
							
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="search" value=" ">
							<input type="button" class="buttonReset" name="reset" value=" " id="reset">
							<input type="button" class="buttonCancel" name="cancel" value=" " id="cancel" onclick="location.href='<?php echo base_url();?>uom/index'">
						</p>
						<?php echo form_close(); ?> 
		<script type="text/javascript">

	 $(document).ready(function() {
			$("#reset").click(function() {
				$('#short_name').val('');	
				$('#long_name').val('');	
			});
	 });
	</script>		
					</fieldset>
					 