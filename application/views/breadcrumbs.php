<h2><i class="fa fa-<?php echo $icon; ?>"></i> <?php echo $title; ?> <span><?php echo $title_child; ?></span></h2>
<div class="breadcrumb-wrapper">
	<span class="label">You are here:</span>
	<ol class="breadcrumb">
	  <li><a href="<?php echo site_url($url); ?>"><?php echo $title; ?></a></li>
	  
	  <?php if($title_child_2) {
	  	echo '<li><a href="'.site_url($url_2).'">'.$title_child.'</a></li>';
	  	echo '<li class="active">'.$title_child_2.'</li>';
	  } else {
	  	echo '<li class="active">'.$title_child.'</li>';
	  }
	  ?>
	</ol>
</div>