<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>

  
    <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"><title>Inventory System</title>	 
	<link rel="stylesheet" href="<?php echo base_url();?>css/style2.css" type="text/css" media="screen" />

	</head>
	
	<body>
	
    
    <div id="t_o">
        
      <div id="t_h">
            <img align="right" />
      </div>

      <div id="t_m">
				<div class="linfo">
					<!--Header-->
							<table width="100%" height="40px" cellspacing="0" cellpadding="0">
							<tr width="85%">
								<td><?php $my_t=getdate(date("U"));
 										echo("$my_t[weekday], $my_t[month] $my_t[mday], $my_t[year]");
 ?></td>
							</tr>
							</table>
			    	</div>

                	<div style="border-bottom: 1px solid rgb(221, 221, 221);"><!-- --></div>
					<h2 id="ti_h">Sign In</h2>
					
					<div id="ti_m">

				  <br/>
					  <p style="border-top:1px solid #CCC;"><!-----></p>
					
					
					<p style="color:#888;margin:10px 10px 10px 10px; text-align:right;">Welcome!</p><p style="color:#888;margin:10px 10px 10px 10px; text-align:right;">Please login.<br/>
					</p>
					
					<div id="lo">
					<div  align="center" style="padding: 0px 10px; background: #ddd none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"><b class="niftycorners" style="background: #fff none repeat scroll 0%; margin-left: -10px; margin-right: -10px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; margin-bottom: -3px;"><b style="border-color: #ddd; background-color: #ddd;" class="r1"></b><b style="border-color: #ddd; background-color: #ddd;" class="r2"></b><b style="border-color: #ddd; background-color: #ddd;" class="r3"></b><b style="border-color: #ddd; background-color: #ddd;" class="r4"></b></b>
						<dl>
						<?php echo form_open('login/validate_credentials');?>
						<table class="tabindex" cellpadding="0">
							<tbody>
								<tr></tr>
								<tr><td width="10%">Username</td><td width="1%">:</td><td width="89%"><input class="font" type="text" name="username"></td></tr>
								<tr><td width="10%">Password</td><td width="1%">:</td><td width="89%"><input class="font" type="password" name="password"></td></tr>
							</tbody>
						</table>
						</dl>
					<b class="niftycorners" style="background: #fff none repeat scroll 0%; margin-left: -10px; margin-right: -10px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; margin-top: -3px;"><b style="border-color: #ddd; background-color: #ddd;" class="r4"></b><b style="border-color: #ddd; background-color: #ddd;" class="r3"></b><b style="border-color: #ddd; background-color: #ddd;" class="r2"></b><b style="border-color: #ddd; background-color: #ddd;" class="r1"></b></b></div>
					<p class="button" align="right"><input type="submit" class="buttonLogin" name="login" value=" ">
				
					<input type="button"class="buttonReset" name="reset" value=" " onclick="location.href='index.php'"></p></form>
					</div>
					
							<br/>
							</div>
							
							<div id="foot" style="clear:both;">
							    &#169; Copyright 2015
							</div>
					
            				
					</div>
				
    		</div>
    
 </body></html>