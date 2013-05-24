<?php $id = uniqid("a")?>
<table cellpadding=1 cellspacing=0 border=0 width="100%"><tr valign="top">
<td align="center"
	onmousedown="
		var e = event || this.arguments[0];
		var s = document.getElementById('<?php echo $id?>').style; 
		s.display = s.display=='none'? 'block' : 'none';
		if (e.button == 2) s.position = 'absolute';
		else s.position = 'relative';
		if (e.preventDefault) e.preventDefault();
		if (e.stopPropagation) e.stopPropagation();
		e.returnValue = false;
		e.cancelBubble = true;
		return false;
	" 
	onselectstart="return false"
	ondblclick="return this.onmousedown()" 
	oncontextmenu="return false" 
	title="Leftclick to show full stack trace. Rightclick to do the same, but in overlapped layer."
	style="cursor:default; cursor:hand; padding:5px; -moz-user-select: none;"
>
<!--
	<div style="padding:0px; width:9px">
	<div style="border: 1px solid #000">
	<div style="font:10px Arial; line-height:5px; padding:1px; margin-right:-1px">+</div>
	</div>
	</div>
-->
	<table cellpadding="0" cellspacing="0" border="0">
	<tr><td bgcolor="white" style="font: 10px Arial; line-height:7px; padding-left:1px; border:1px solid #000000">+</td></tr>
	</table>
</td>
<td style="font-size:14px" width="100%">
	<b><?php echo $error['errtype']?>[<?php echo $error['errno']?>]:</b> 
	<?php echo $error['errstr']?> at <b><?php echo $error['name']?></b> line <b><?php echo $error['line']?></b>
	&nbsp;
	<br />
	<div id="<?php echo $id?>" style="color:black; background:#EEEEEE; display:none; border-style:dashed; border-width:1; margin-left:0; padding-left:5">
		<?php foreach ($error['stack'] as $i=>$e) {?>
				<span title=
					"<?php if (!empty($e['function'])) {?>
						<?php echo (!empty($e['class'])? $e['class']."::" : "").$e['function']?>
							<?php
							$clen = 100;
							$args = array();
							if (!empty($e['args'])) {
								foreach ($e['args'] as $v) {
									if (is_scalar($v)) {
										$a = substr($v, 0, $clen);
										if (strlen($v)>$clen) $a .= "...";
										$a = is_numeric($a)? $a : '"'.addslashes($a).'"';
									} else {
										$a = gettype($v);
									}
									$args[] = "&nbsp;&nbsp;".htmlspecialchars($a);
								}
							}
							?>
						<?php echo $args? "(&#13".join(",&#13", $args)."&#13)" : "()"?>
					<?php }?>"
				>
					<?php if (!empty($e['class']) || !empty($e['function'])) {?>
						<i>at</i>
						<?php if (!empty($e['class'])) {?><tt><?php echo $e['class']?>::</tt><?php }?>
						<?php if (!empty($e['function'])) {?><tt><?php echo $e['function']?>()</tt><?php }?>
					<?php }?>
					<i>in</i>
					<b><?php echo $e['name']?></b> 
					<?php if (isset($e['line'])) {?>
						<i>line</i> <b><?php echo $e['line']?></b>
					<?php }?>
				</span>
				<br />
		<?php }?>
	</div>
</td>
</tr></table>