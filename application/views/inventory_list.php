	
					 <!--Content-->
					 <fieldset><legend>SEARCH INVENTORY</legend>		
							<?php echo form_open('inventory/search'); ?> 	
							
							<table class="tabel2" width="910px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="9%">Item Code</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'code_search','name'=>'code_search'),$code_search);?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">Item Name</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'name_search','name'=>'name_search'),$name_search);?></td>
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
					 
				   <fieldset><legend>INVENTORY</legend>		
							
							<table class="tabel2" width="800px" cellpadding="0">
							 <div id="pagination"><?php echo $pagination; ?> </div>
						
							<tbody>
								<tr class="header">
								<td width="30%"><?=anchor('/inventory/search/'.$offset.'/item_code/'.$new_order.'/'.$code_search.'/'.$name_search, "Item Code")?></td>
								<td width="30%"><?=anchor('/inventory/search/'.$offset.'/item_name/'.$new_order.'/'.$code_search.'/'.$name_search, "item Name")?></td>
								<td width="30%"><?php echo form_label('Quantity'); ?></td>
								<td width="5%"><?php echo form_label('Uom'); ?></td>
								<td width="5%">Action</td>
								</tr>
							</tbody>
							</table>
							
							<table class="tabel2" width="800px" cellpadding="0">
							<tbody>
							<?php  $index = 0; ?>
							<?php foreach($inventories as $row) : ?> 
							<?php 
								if ($index%2==1){?>
									<tr bgcolor="#e8e8e8">
								<?php }else{ ?>
									<tr bgcolor="#ffffff">
								<?php }?>
								<td width="30%"><?php echo form_label($row['item_code']); ?> </td>
								<td width="30%"><?php echo form_label($row['item_name']); ?> </td>
								<td width="30%"><?php echo form_label(number_format ( $row['quantity'] , 2,',','.' )); ?> </td>
								<td width="5%"><?php echo form_label($row['short_name']); ?> </td>
								<td width="5%">
								<?=anchor('inventory/update/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_edit.png','alt'=>'update'))) ?>
								<?=anchor('inventory/delete/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_delete.png','alt'=>'delete')),array('onclick'=>"return confirm('delete inventory ".$row['item_code']."?')")) ?>
								</td>
							</tr>
							<?php $index++; ?>
							<?php endforeach; ?>
							</tbody>
							</table>
						<!--Button-->
						<p class="garis"><!-----></p>
						<p class="button">
						<?=anchor('inventory/add_inventory',img(array('src'=>base_url().'img/add.gif','alt'=>'add'))) ?>
						</p>
	<script type="text/javascript">

	 $(document).ready(function() {
			$("#reset").click(function() {
				$('#code_search').val('');	
				$('#name_search').val('');	
			});
	 });
	</script>			

					</fieldset>
