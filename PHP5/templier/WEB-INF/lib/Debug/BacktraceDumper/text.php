<?php echo $error['errtype']?>[<?php echo $error['errno']?>]:
<?php echo $error['errstr']?> at <?php echo $error['name']?> line <?php echo $error['line']?>
<?php foreach ($error['stack'] as $i=>$e) {?>
	\n
	<?php if (@$e['class'] || @$e['function']) {?>
		   at
		<?php if (@$e['class']) {?><?php echo $e['class']?>::<?php }?>
		<?php if (@$e['function']) {?><?php echo $e['function']?>()<?php }?>
		 in
	<?php } else {?>
		   in
	<?php }?>
	<?php echo $e['name']?>
	<?php if (@$e['line']) {?>
		 line <?php echo $e['line']?>
	<?php }?>
<?php }?>