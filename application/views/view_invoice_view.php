	
					 <!--Content-->
					 <fieldset><legend>VIEW INVOICE</legend>		
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Invoice No</td>
								<td width="1%">:</td>
								<td width="28%"><?=$invoice['invoice_no']?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Client</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_label($invoice['name']);?></td>
								</tr>
								<tr>
								<td>Sales</td>
								<td>:</td>
								<td><?= form_label($invoice['sales']);?></td>
								<td>&nbsp;</td>
								<td>Date</td>
								<td>:</td>
								<td><?= form_label(date_format(date_create($invoice['invoice_date']),'d-m-Y'));?></td>
								</tr>
								<tr>
								<td>Remarks</td>
								<td>:</td>
								<td><?= form_label($invoice['remarks']);?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								</tr>
							</tbody>
							</table>
							
							<p class="garis" id="garis_item"><!-----></p>
							
							<table class="tabel2" width="910px" cellpadding="0">
							<tbody>
								<tr class="header">
								<td width="15%">Inventory</td>
								<td width="10%">Quantity</td>
								<td width="10%">Price</td>
								<td width="10%">Discount</td>
								<td width="10%">Nett Price</td>
								<td width="20%">Total</td>
								</tr>
							</tbody>
							</table>
							<table class="tabel2" width="910px" cellpadding="0">
							<tbody>
							<?php  $index = 0; ?>
							<?php foreach($items as $row) : ?> 
							<?php 
								if ($index%2==1){?>
									<tr bgcolor="#e8e8e8">
								<?php }else{ ?>
									<tr bgcolor="#ffffff">
								<?php }?>
								<td width="15%"><?php echo form_label($row['item_name']); ?> </td>
								<td width="10%"><?php echo form_label(number_format ( $row['quantity'] , 2,'.',',') . " ". $row['short_name']); ?></td>
								<td width="10%"><?php echo form_label(number_format ( $row['price'] , 2,'.',','));?> </td>
								<td width="10%"><?php echo form_label(number_format ( $row['discount'] , 2,'.',',')); ?></td>
								<td width="10%"><?php echo form_label(number_format ( $row['nett_price'] , 2,'.',','));?></td>
								<td width="20%"><?php echo form_label(number_format ( $row['total'] , 2,'.',','));?></td>
								
							</tr>
							<?php $index++; ?>
							<?php endforeach; ?>
							<tr bgcolor="#dad6f3">
								<td colspan="5" align="right">Total</td>
								<td><?= form_label(number_format ( $total_item['total_item'] , 2,'.',','));?></td>
							</tr>
							</tbody>
							</table>
							<p class="garis" id="garis_item"><!-----></p>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Delivery Fee</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_label(number_format ( $invoice['delivery_fee'] , 2,'.',','));?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Discount</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_label(number_format ( $invoice['discount'] , 2,'.',','));?></td>
								</tr>
								<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>Total</td>
								<td>:</td>
								<td><?= form_label(number_format ( $invoice['total'] , 2,'.',','));?></td>
								</tr>
								
							</tbody>
							</table>
							
						
						<p class="garis"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="button" class="buttonBack" name="back" value=" " id="back" onclick="location.href='<?php echo base_url();?>invoice/index'">
						</p>	
					</fieldset>
					 