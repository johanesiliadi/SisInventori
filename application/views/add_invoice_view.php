	
					 <!--Content-->
					 <fieldset><legend>ADD NEW INVOICE</legend>		
							<?php echo form_open('invoice/create_invoice'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Invoice No</td>
								<td width="1%">:</td>
								<td width="20%"><?= form_input(array('id' => 'invoice_no','name'=>'invoice_no'),set_value('invoice_no'));?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Client</td>
								<td width="1%">:</td>
								<td width="36%"><?= form_dropdown('id_client', $clients, set_value('id_client'),'id="id_client"');?></td>
								</tr>
								<tr>
								<td>Sales</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'sales','name'=>'sales'),set_value('sales'));?></td>
								<td>&nbsp;</td>
								<td>Date</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'date','name'=>'date','readOnly'=>'readOnly'),set_value('date'));?></td>
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
						<p class="button">
							<input type="submit" class="buttonAdd" name="add" value=" " id="add">
						</p>	
						<?php echo form_close(); ?> 
		<script type="text/javascript">

		 $(document).ready(function() {
		 
			
			$("#id_client").searchable();
	  		$('#date').datepicker({ dateFormat: 'yy-mm-dd' });
			
			
			$("#add").click(function() {
				var confirmation = "Please confirm the data";
				confirmation = confirmation + '\n' + 'Invoice no: ' + $("#invoice_no").val();
				confirmation = confirmation + '\n' + 'Client: ' + $("#id_client").find('option:selected').text();
				confirmation = confirmation + '\n' + 'Date: ' + $("#date").val();
				confirmation = confirmation + '\n' + 'Sales: ' + $("#sales").val();
				confirmation = confirmation + '\n' + 'Remarks: ' + $("#remarks").val();
				return confirm(confirmation);
			});
		});
		</script>		
					</fieldset>
					 