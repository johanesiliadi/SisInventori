	
					 <!--Content-->
					 <fieldset><legend>UPDATE INVOICE</legend>		
							<?php echo form_open('invoice/edit_invoice'); ?> 	
							<?php echo validation_errors(); ?>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Invoice No</td>
								<td width="1%">:</td>
								<td width="20%"><?=$invoice['invoice_no']?>
								<?= form_input(array('name' => 'invoice_no', 'type'=>'hidden', 'id' =>'invoice_no'),$invoice['invoice_no']);
;?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Client</td>
								<td width="1%">:</td>
								<td width="36%"><?= form_dropdown('id_client', $clients, $invoice['client_id'],'id="id_client"');?></td>
								</tr>
								<tr>
								<td>Sales</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'sales','name'=>'sales'),$invoice['sales']);?></td>
								<td>&nbsp;</td>
								<td>Date</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'date','name'=>'date'),$invoice['invoice_date']);?></td>
								</tr>
								<tr>
								<td>Remarks</td>
								<td>:</td>
								<td><?= form_textarea(array('id' => 'remarks','name'=>'remarks','rows'=>'5','cols'=>'40'),$invoice['remarks']);?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;<?= form_input(array('name' => 'hidden_id', 'type'=>'hidden', 'id' =>'hidden_id'),$invoice['id']);
;?></td>
								</tr>
							</tbody>
							</table>
							<p class="button">
							<input type="button" name="link_add" value="add item" id="link_add">
							<input type="button" name="link_save" value="save form" id="link_save">
						</p>
						<table class="tabel2" width="1150px" cellpadding="0" id="tabel_item">
							<tbody>
								<tr>
								<td width="7%">Inventory</td>
								<td width="1%">:</td>
								<td width="23%"><?= form_dropdown('id_inventory', $inventories, set_value('id_inventory'),'id="id_inventory"');?></td>
								<td width="1%">&nbsp;</td>
								<td width="7%">Quantity</td>
								<td width="1%">:</td>
								<td width="20%"><?= form_input(array('id' => 'quantity','name'=>'quantity', 'size' => '3'),set_value('quantity'));?><?= form_dropdown('id_uom', $uoms, set_value('id_uom'),'id="id_uom" ');?></td>
								<td width="1%">&nbsp;</td>
								<td width="7%">Price</td>
								<td width="1%">:</td>
								<td width="14%"><?= form_input(array('id' => 'price','name'=>'price'),set_value('price'));?></td>
								<td width="2%">&nbsp;</td>
								<td width="2%">&nbsp;</td>
								</tr>
								<tr>
								<td>Discount</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'discount','name'=>'discount'),set_value('discount'));?></td>
								<td>&nbsp;</td>
								<td>Nett Price</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'nett_price','name'=>'nett_price','readOnly'=>'readOnly'),set_value('nett_price'));?></td>
								<td>&nbsp;</td>
								<td>Total</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'total','name'=>'total','readOnly'=>'readOnly'),set_value('total'));?></td>
								<td>&nbsp;</td>
								<td>
								<input type="submit" name="add_item" value="add item" id="add_item"></td>
								</tr>
							</tbody>
							</table>
							
							<p class="line" id="line_item"><!-----></p>
							
							<table class="tabel2" width="910px" cellpadding="0">
							<tbody>
								<tr class="header">
								<td width="15%">Inventory</td>
								<td width="10%">Quantity</td>
								<td width="10%">Price</td>
								<td width="10%">Discount</td>
								<td width="10%">Nett Price</td>
								<td width="20%">Total</td>
								<td width="5%">Action</td>
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
								<td width="10%"><?php echo form_label(number_format ( $row['price'] , 2,'.',',')); ?> </td>
								<td width="10%"><?php echo form_label(number_format ( $row['discount'] , 2,'.',',')); ?></td>
								<td width="10%"><?php echo form_label(number_format ( $row['nett_price'] , 2,'.',','));?></td>
								<td width="20%"><?php echo form_label(number_format ( $row['total'] , 2,'.',','));?></td>
								<td width="5%">
								<?=anchor('invoice/delete_item/'.$row['id'].'/'.$invoice['id'],img(array('src'=>base_url().'img/icon_delete.png','alt'=>'delete')),array('onclick'=>"return confirm('delete inventory ".$row['item_name']."?')")) ?>
								</td>
								
							</tr>
							<?php $index++; ?>
							<?php endforeach; ?>
							<tr bgcolor="#dad6f3">
								<td colspan="5" align="right">Total</td>
								<td><?= form_label(number_format ( $total_item['total_item'] , 2,'.',','));?></td>
								<td>&nbsp;<?= form_input(array('name' => 'hidden_total', 'type'=>'hidden', 'id' =>'hidden_total'),$total_item['total_item']);
;?></td>
							</tr>
							</tbody>
							</table>
							<p class="line" id="line_item"><!-----></p>
							<table class="tabel2" width="1000px" cellpadding="0">
						
							<tbody>
								<tr>
								<td width="15%">Delivery Fee</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'delivery_fee','name'=>'delivery_fee'),$invoice['delivery_fee']);?></td>
								<td width="10%">&nbsp;</td>
								<td width="15%">Discount</td>
								<td width="1%">:</td>
								<td width="28%"><?= form_input(array('id' => 'discount_invoice','name'=>'discount_invoice'),$invoice['discount']);?></td>
								</tr>
								<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>Total</td>
								<td>:</td>
								<td><?= form_input(array('id' => 'total_invoice','name'=>'total_invoice'),$invoice['total']);?></td>
								</tr>
								
							</tbody>
							</table>
							
						
						<p class="line"><!-----></p>
						<!--Button-->
						<p class="button">
							<input type="submit" class="buttonOK" name="ok" value=" " id="ok">
							<input type="button" class="buttonReset" name="reset" value=" " id="reset">
						</p>
						<?php echo form_close(); ?> 
		<script type="text/javascript">

	 $(document).ready(function() {
		$("#id_client").searchable();
		$("#id_uom").searchable();
		$("#id_inventory").searchable();
	  		
	 	jQuery(function($) {
          	//$('#quantity').autoNumeric('init', {aDec: ',' , aSep: '.' ,vMax: '999999999999.99'}); 
          	$('#price').autoNumeric('init', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
          	$('#discount').autoNumeric('init', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
          	$('#nett_price').autoNumeric('init', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
          	$('#total').autoNumeric('init', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
          	$('#delivery_fee').autoNumeric('init', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
          	$('#discount_invoice').autoNumeric('init', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
          	$('#total_invoice').autoNumeric('init', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
  		});
		
		function calculate_nett(){
			var price = $('#price').val().replace(/[^0-9\.]+/g,"");
			var discount = $('#discount').val().replace(/[^0-9\.]+/g,"");
			var nett_price = parseFloat(price) - parseFloat(discount);
			
			$('#nett_price').val(nett_price);
		}
		
		function calculate_total(){
			var quantity = $('#quantity').val().replace(/[^0-9\.]+/g,"");
			var nett_price = $('#nett_price').val().replace(/[^0-9\.]+/g,"");
			var total = parseFloat(quantity) * parseFloat(nett_price);
			
			$('#total').val(total);
		}
		
		function calculate_total_invoice(){
			var delivery_fee = $('#delivery_fee').val().replace(/[^0-9\.]+/g,"");
			var discount_invoice = $('#discount_invoice').val().replace(/[^0-9\.]+/g,"");
			var total_item = $('#hidden_total').val();
			
			var total = parseFloat(total_item) + parseFloat(delivery_fee) - parseFloat(discount_invoice);
			$('#total_invoice').val(total);
		}
		
		
		calculate_total_invoice();
		$("#delivery_fee,#discount_invoice").blur(function() {
			calculate_total_invoice();
          	$('#total_invoice').autoNumeric('update', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
		});
		
		$("#price,#discount").blur(function() {
			calculate_nett();
			calculate_total();
          	$('#nett_price').autoNumeric('update', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
          	$('#total').autoNumeric('update', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
		});
		
		$("#nett_price,#quantity").blur(function() {
			calculate_total();
          	$('#nett_price').autoNumeric('update', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
          	$('#total').autoNumeric('update', {aDec: '.' , aSep: ',' ,vMax: '999999999999.99'}); 
		});
		
	 
	  	$('#date').datepicker({ dateFormat: 'yy-mm-dd' });
	  	$('#link_save').hide();
		$('#link_add').hide(); 
		$('#tabel_item').hide(); 
		$('#line_item').hide(); 
		$("#reset").click(function() {
			$('#id_client option:selected').removeAttr('selected');
			$('#sales').val('');	
			$('#date').val('');	
			$('#remarks').val('');
		});
	  	$("#link_add").click(function() {
			$('#link_save').show(); 
			$('#link_add').hide(); 
			$('#tabel_item').show(); 
			$('#line_item').show(); 
		});
		$("#link_save").click(function() {
			$('#link_save').hide(); 
			$('#link_add').show(); 
			$('#tabel_item').hide(); 
			$('#line_item').hide(); 
		});
		
		if($("#hidden_id").val() > 0){
			$('#link_add').show(); 
		}
		
	});	
		$("#add_item").click(function() {
			var confirmation = "Please confirm your data";
			confirmation = confirmation + '\n' + 'Inventory: ' + $("#id_inventory").find("option:selected").text();
			confirmation = confirmation + '\n' + 'Quantity: ' + $("#quantity").val() + ' ' + $("#id_uom").find('option:selected').text();
			confirmation = confirmation + '\n' + 'Price: ' + $("#price").val();
			confirmation = confirmation + '\n' + 'Discount: ' + $("#discount").val();
			confirmation = confirmation + '\n' + 'Nett price: ' + $("#nett_price").val();
			confirmation = confirmation + '\n' + 'Total: ' + $("#total").val();
			
			$('#quantity').val($('#quantity').val().replace(/[^0-9\.]+/g,""));
			$('#price').val($('#price').val().replace(/[^0-9\.]+/g,""));
			$('#discount').val($('#discount').val().replace(/[^0-9\.]+/g,""));
			$('#nett_price').val($('#nett_price').val().replace(/[^0-9\.]+/g,""));
			$('#total').val($('#total').val().replace(/[^0-9\.]+/g,""));
		
			return confirm(confirmation);
		});
		
		$("#ok").click(function() {
			var confirmation = "Save this invoice?";
			
			$('#delivery_fee').val($('#delivery_fee').val().replace(/[^0-9\.]+/g,""));
			$('#discount_invoice').val($('#discount_invoice').val().replace(/[^0-9\.]+/g,""));
			$('#total_invoice').val($('#total_invoice').val().replace(/[^0-9\.]+/g,""));
			return confirm(confirmation);
		});
	</script>		
					</fieldset>
					 