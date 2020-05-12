	
					 <!--Content-->
					 <fieldset><legend>FIND INVOICE</legend>		
							<?php echo form_open('invoice/search'); ?> 	
							
							<table class="tabel2" width="910px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="9%">Invoice no</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'number_search','name'=>'number_search'),$number_search);?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">Client</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_dropdown('client_search', $clients, $client_search, 'id = "client_search"');?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">Date</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'date_search','name'=>'date_search','readOnly'=>'readOnly'),$date_search);?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">Status</td>
								<td width="1%">:</td>
								<td width="15%"><?php $options = array(
							                   ''  => '-ALL-',
							                   '1'    => 'Not Received',
							                   '2'    => 'Received',
							                 );
									echo form_dropdown('status_search', $options, $status_search, 'id = "status_search"');
 
								 ?></td>
								</tr>
							</tbody>
							</table>
							
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="search" value=" ">
							<input type="button" class="buttonReset" name="reset" value=" " id="reset">
						</p>
						<?php echo form_close(); ?> 
					</fieldset>
					 
				   <fieldset><legend>invoice</legend>		
							
							<table class="tabel2" width="910px" cellpadding="0">
							 <div id="pagination"><?php echo $pagination; ?> </div>
						
							<tbody>
								<tr class="header">
								<td width="15%"><?=anchor('/invoice/search/'.$offset.'/number/'.$new_order.'/'.$number_search.'/'.$date_search.'/'.$client_search.'/'.$status_search, "Invoice No")?></td>
								<td width="15%"><?=anchor('/invoice/search/'.$offset.'/date/'.$new_order.'/'.$number_search.'/'.$date_search.'/'.$client_search.'/'.$status_search, "Date")?></td>
								<td width="30%"><?=anchor('/invoice/search/'.$offset.'/client_id/'.$new_order.'/'.$number_search.'/'.$date_search.'/'.$client_search.'/'.$status_search, "Client")?></td>
								<td width="25%"><?=anchor('/invoice/search/'.$offset.'/remarks/'.$new_order.'/'.$number_search.'/'.$date_search.'/'.$client_search.'/'.$status_search, "Remarks")?></td>
								<td width="5%">Action</td>
								</tr>
							</tbody>
							</table>
							
							<table class="tabel2" width="910px" cellpadding="0">
							<tbody>
							<?php  $index = 0; ?>
							<?php foreach($invoices as $row) : ?> 
							<?php 
								if ($index%2==1){?>
									<tr bgcolor="#e8e8e8">
								<?php }else{ ?>
									<tr bgcolor="#ffffff">
								<?php }?>
								<td width="15%"><?php echo form_label($row['invoice_no']); ?> </td>
								<td width="15%"><?php echo form_label(date_format(date_create($row['invoice_date']),'d-m-Y')); ?> </td>
								<td width="30%"><?php echo form_label($row['name']); ?> </td>
								<td width="25%"><?= form_label($row['remarks']);?>&nbsp;</td>
								<td width="5%">
								<?=anchor('invoice/view/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_edit.png','alt'=>'view'))) ?>
								<?=anchor('invoice/delete/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_delete.png','alt'=>'delete')),array('onclick'=>"return confirm('delete invoice ".$row['invoice_no']."?')")) ?>
								</td>
							</tr>
							<?php $index++; ?>
							<?php endforeach; ?>
							</tbody>
							</table>
						<!--Button-->
						<p class="garis"><!-----></p>
						<p class="button">
						<?=anchor('invoice/add_invoice',img(array('src'=>base_url().'img/add.gif','alt'=>'add'))) ?>
						</p>
	<script type="text/javascript">

	 $(document).ready(function() {
	 $("#client_search").searchable();
	 $("#status_search").searchable();
	  $('#date_search').datepicker({ dateFormat: 'yy-mm-dd' });
			$("#reset").click(function() {
				$('#client_search').prop('selectedIndex', 0); 	
				$('#number_search').val('');	
				$('#date_search').val('');	
			});
	 });
	</script>			

					</fieldset>
