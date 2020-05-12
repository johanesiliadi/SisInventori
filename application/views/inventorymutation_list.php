	
					 <!--Content-->
					 <fieldset><legend>VIEW MUTATION</legend>		
							<?php echo form_open('inventorymutation/search'); ?> 	
							
							<table class="tabel2" width="910px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="9%">Date</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'date_search','name'=>'date_search','readOnly'=>'readOnly'),$date_search);?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">Inventory</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_dropdown('inventory_search', $inventories, $inventory_search, 'id = "inventory_search" ');?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">&nbsp;</td>
								<td width="1%">&nbsp;</td>
								<td width="15%">&nbsp;</td>
								<td width="40%">&nbsp;</td>
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
					 
				   <fieldset><legend>INVENTORY MUTATION</legend>		
							
							<table class="tabel2" width="910px" cellpadding="0">
							 <div id="pagination"><?php echo $pagination; ?> </div>
						
							<tbody>
								<tr class="header">
								<td width="15%">Inventory</td>
								<td width="5%">Type</td>
								<td width="10%">Quantity</td>
								<td width="40%">Remarks</td>
								<td width="15%">PIC</td>
								<td width="12%"><?=anchor('/inventorymutation/search/'.$offset.'/update_date/'.$new_order.'/'.$date_search.'/'.$inventory_search, "Update date")?></td>
								<td width="3%">Action</td>
								</tr>
							</tbody>
							</table>
							
							<table class="tabel2" width="910px" cellpadding="0">
							<tbody>
							<?php  $index = 0; ?>
							<?php foreach($inventorymutations as $row) : ?> 
							<?php 
								if ($index%2==1){?>
									<tr bgcolor="#e8e8e8">
								<?php }else{ ?>
									<tr bgcolor="#ffffff">
								<?php }?>
								<td width="15%"><?php echo form_label($row['item_name']); ?> </td>
								<td width="5%"><?php if($row['type'] == 0){
									echo form_label('Increase');
								}else{
									echo form_label('Decrease');
								} ?> </td>
								<td width="10%"><?php echo form_label(number_format ( $row['quantity'] , 2,',','.' ) ." ".$row['short_name']); ?> </td>
								<td width="40%"><?php echo form_label($row['remarks']); ?> </td>
								<td width="15%"><?php echo form_label($row['name']); ?> </td>
								<td width="12%"><?= form_label(date_format(date_create($row['update_time']),'d-m-Y H:i'));?> </td>
								<td width="3%">
								<?=anchor('inventorymutation/delete/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_delete.png','alt'=>'delete')),array('onclick'=>"return confirm('Delete this mutation?')")) ?>
								</td>
							</tr>
							<?php $index++; ?>
							<?php endforeach; ?>
							</tbody>
							</table>
						<!--Button-->
						<p class="garis"><!-----></p>
						<p class="button">
						<?=anchor('inventorymutation/add_inventorymutation',img(array('src'=>base_url().'img/add.gif','alt'=>'add'))) ?>
						</p>
	<script type="text/javascript">

	 $(document).ready(function() {
	 $("#inventory_search").searchable();
	  $('#date_search').datepicker({ dateFormat: 'yy-mm-dd' });
			$("#reset").click(function() {
				$('#date_search').val('');	
				$('#inventory_search').val('');	
			});
	 });
	</script>			

					</fieldset>
