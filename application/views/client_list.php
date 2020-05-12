	
					 <!--Content-->
					 <fieldset><legend>SEARCH CLIENT</legend>		
							<?php echo form_open('client/search'); ?> 	
							
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
					 
				   <fieldset><legend>TOKO</legend>		
							
							<table class="tabel2" width="910px" cellpadding="0">
							 <div id="pagination"><?php echo $pagination; ?> </div>
						
							<tbody>
								<tr class="header">
								<td width="50%"><?=anchor('/client/search/'.$offset.'/name/'.$new_order.'/'.$order_type, "Name")?></td>
								<td width="25%"><?=anchor('/client/search/'.$offset.'/phone_number1/'.$new_order.'/'.$order_type, "Phone")?></td>
								<td width="5%">Action</td>
								</tr>
							</tbody>
							</table>
							
							<table class="tabel2" width="910px" cellpadding="0">
							<tbody>
							<?php  $index = 0; ?>
							<?php foreach($clients as $row) : ?> 
							<?php 
								if ($index%2==1){?>
									<tr bgcolor="#e8e8e8">
								<?php }else{ ?>
									<tr bgcolor="#ffffff">
								<?php }?>
								<td width="50%"><?php echo form_label($row['name']); ?> </td>
								<td width="25%"><?php echo form_label($row['phone']); ?> </td>
								<td width="5%">
								<?=anchor('client/update/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_edit.png','alt'=>'update'))) ?>
								<?=anchor('client/delete/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_delete.png','alt'=>'delete')),array('onclick'=>"return confirm('delete client ".$row['name']."?')")) ?>
								</td>
							</tr>
							<?php $index++; ?>
							<?php endforeach; ?>
							</tbody>
							</table>
						<!--Button-->
						<p class="garis"><!-----></p>
						<p class="button">
						<?=anchor('client/add_client',img(array('src'=>base_url().'img/add.gif','alt'=>'add'))) ?>
						</p>
	<script type="text/javascript">

	 $(document).ready(function() {
			$("#reset").click(function() {
				$('#name_search').val('');	
			});
	 });
	</script>			

					</fieldset>
