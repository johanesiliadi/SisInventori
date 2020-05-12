<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>

  
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"><title>Inventory system</title>	
    <link rel="stylesheet" href="<?php echo base_url();?>css/chosen.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/style2.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/smoothness/jquery-ui-1.11.3.css" type="text/css" media="screen" />
	<script language='javascript' src="<?php echo base_url();?>script/jquery-2.1.3.js"></script>
	<script language='javascript' src="<?php echo base_url();?>script/autoNumeric-1.9.26.js"></script>
	<script language='javascript' src="<?php echo base_url();?>script/jquery-migrate-1.2.1.js"></script>
	<script language='javascript' src="<?php echo base_url();?>script/jquery.searchabledropdown-1.0.8.src.js"></script>
	<script language='javascript' src="<?php echo base_url();?>script/jquery-ui-1.11.3.js"></script>
	
		
	</head>
	
	<body>
	
    
    <div id="t_o">
        
      <div id="t_h">
      </div>

      <div id="t_m">
				<div class="linfo">
					<!--Header-->
							<table width="100%" height="40px" cellspacing="0" cellpadding="0">
							<tr width="85%">
								<td><?php $my_t=getdate(date("U"));
 										echo("$my_t[weekday], $my_t[month] $my_t[mday], $my_t[year]");
 ?></td>

								<td width="15%" align="right"><?=anchor('login/logout',img(array('src'=>base_url().'img/logout.png','alt'=>'logout'))) ?></td>
							</tr>
							<tr>
								<td width="85%"><img src="<?php echo base_url();?>img/role2.png" class="png16" alt="person"/> User : <?=$this->session->userdata('name');?></td>
								<td width="15%" >&nbsp;</td>
							</tr>
							</table>
			    	</div>

                	<div style="border-bottom: 1px solid rgb(221, 221, 221);"><!-- --></div>
					<h2 id="ti_h">Welcome</h2>
					
					

				  <br/>
				  