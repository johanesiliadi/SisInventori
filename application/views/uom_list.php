	
					 <!--Content-->
					 <fieldset><legend>SEARCH UOM</legend>		
							<?php echo form_open('uom/search'); ?> 	
							
							<table class="tabel2" width="910px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="9%">Name</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'name_search','name'=>'name_search'),$name_search);?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">&nbsp;</td>
								<td width="1%">&nbsp;</td>
								<td width="15%">&nbsp;</td>
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
					 
				   <fieldset><legend>uom</legend>		
							
							<table class="tabel2" width="910px" cellpadding="0">
							 <div id="pagination"><?php echo $pagination; ?> </div>
						
							<tbody>
								<tr class="header">
								<td width="25%"><?=anchor('/uom/search/'.$offset.'/short_name/'.$new_order.'/'.$order_type, "Short name")?></td>
								<td width="50%"><?=anchor('/uom/search/'.$offset.'/long_name/'.$new_order.'/'.$order_type, "Long name")?></td>
								<td width="5%">Action</td>
								</tr>
							</tbody>
							</table>
							
							<table class="tabel2" width="910px" cellpadding="0">
							<tbody>
							<?php  $index = 0; ?>
							<?php foreach($uoms as $row) : ?> 
							<?php 
								if ($index%2==1){?>
									<tr bgcolor="#e8e8e8">
								<?php }else{ ?>
									<tr bgcolor="#ffffff">
								<?php }?>
								<td width="25%"><?php echo form_label($row['short_name']); ?> </td>
								<td width="50%"><?php echo form_label($row['long_name']); ?> </td>
								<td width="5%">
								<?=anchor('uom/update/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_edit.png','alt'=>'update'))) ?>
								<?=anchor('uom/delete/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_delete.png','alt'=>'delete')),array('onclick'=>"return confirm('delete uom ".$row['short_name']."?')")) ?>
								</td>
							</tr>
							<?php $index++; ?>
							<?php endforeach; ?>
							</tbody>
							</table>
						<!--Button-->
						<p class="garis"><!-----></p>
						<p class="button">
						<?=anchor('uom/add_uom',img(array('src'=>base_url().'img/add.gif','alt'=>'add'))) ?>
						</p>
	<script type="text/javascript">

	 $(document).ready(function() {
			$("#reset").click(function() {
				$('#name_search').val('');	
			});
	 });
	</script>			

					</fieldset>
