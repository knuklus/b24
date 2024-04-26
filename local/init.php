<?php

declare(strict_types=1);

function dev($arg, $exit=false, $isGuest = false){
	global $USER;
	$style = 'style="font-size:12px;background-color:#fffcf7";align-text:left!important';
	if($USER->IsAdmin()):?>
		<pre <?php echo $style?>>
      <?php
	  print_r($arg);
	  if($exit) exit;
	  ?>
    </pre>
	<?php
	else:
		if($isGuest):?>
			<pre <?php echo $style?>>
      <?php
      print_r($arg);
	  if($exit) exit;
	  ?>
    </pre>
		<?php
		endif;
	endif;
}