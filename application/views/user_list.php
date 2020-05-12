	
					 <!--Content-->
					 <fieldset><legend>SEARCH USER</legend>		
							<?php echo form_open('user/search'); ?> 	
							
							<table class="tabel2" width="910px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="9%">Full name</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'name_search','name'=>'name_search'),$name_search);?></td>
								<td width="10%">&nbsp;</td>
								<td width="9%">Username</td>
								<td width="1%">:</td>
								<td width="15%"><?= form_input(array('id' => 'username_search','name'=>'username_search'),$username_search);?></td>
								<td width="10%">&nbsp;</td>
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
					 
				   <fieldset><legend>USER</legend>		
							
							<table class="tabel2" width="910px" cellpadding="0">
							 <div id="pagination"><?php echo $pagination; ?> </div>
						
							<tbody>
								<tr class="header">
								<td width="19%"><?=anchor('/User/search/'.$offset.'/name/'.$new_order.'/'.$name_search, "Full name")?></td>
								<td width="19%"><?=anchor('/User/search/'.$offset.'/username/'.$new_order.'/'.$username_search, "Username")?></td>
								<td width="5%">Action</td>
								</tr>
							</tbody>
							</table>
							
							<table class="tabel2" width="910px" cellpadding="0">
							<tbody>
							<?php  $index = 0; ?>
							<?php foreach($members as $row) : ?> 
							<?php 
								if ($index%2==1){?>
									<tr bgcolor="#e8e8e8">
								<?php }else{ ?>
									<tr bgcolor="#ffffff">
								<?php }?>
								<td width="19%"><?php echo form_label($row['name']); ?> </td>
								<td width="19%"><?php echo form_label($row['username']); ?> </td>
								<td width="5%">
								<?=anchor('user/update/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_edit.png','alt'=>'update'))) ?>
								<?=anchor('user/delete/'.$row['id'].'/'.$offset.'/'.$order_column.'/'.$order_type,img(array('src'=>base_url().'img/icon_delete.png','alt'=>'delete')),array('onclick'=>"return confirm('delete user ".$row['name']."?')")) ?>
								</td>
							</tr>
							<?php $index++; ?>
							<?php endforeach; ?>
							</tbody>
							</table>
						<!--Button-->
						<p class="garis"><!-----></p>
						<p class="button">
						<?=anchor('user/add_user',img(array('src'=>base_url().'img/add.gif','alt'=>'add'))) ?>
						</p>
	<script type="text/javascript">

	 $(document).ready(function() {
			$("#reset").click(function() {
				$('#name_search').val('');	
				$('#username_search').val('');	
			});
	 });
	</script>			

					</fieldset>
