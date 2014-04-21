	<?php
	$cnt = 0;
	foreach ($navigation->categories as $category) {
	?>
	<?php if($cnt == 0) { ?>
    	<li class="first-child<?php if($this->uri->segment(1) == "" || $this->uri->segment(1) == "home") { echo ' active'; } ?>"><a href="<?php echo $base_url; ?>"><img src="<?php echo $base_url; ?>assets/images/home.png" alt="<?php echo lang('breadcrumb-home'); ?>"></a></li>
	<?php } else { ?>
		<li<?php if($this->uri->segment(1) == url_title($category->name)) { echo ' class="active"'; } ?> id="li-<?php echo $category->tags; ?>">
		<a id="a-<?php echo $category->tags; ?>" href="<?php echo $category->uri; ?>"><?php echo $category->name; ?></a>
	<?php } ?>

		<div class="subnav">
			<ul class="subnav-nav">
				<li><a href="<?php echo $category->uri; ?>"><?php echo lang('featured'); ?></a></li>
				<?php foreach ($category->subcategories as $subcategory) { ?>
				<li><a href="<?php echo $subcategory->uri; ?>"><?php echo $subcategory->name; ?></a></li>
				<?php } ?>
			</ul> <!-- //subnav-nav -->
            <div class="subnav-panels">

				<div class="subnav-panel"><p><?php echo str_replace('{0}', $category->name, lang('recent-category')); ?></p>
                <ul class="grid sidebar-grid subnav-grid">
					<?php foreach ($category->preview_videos as $vid) { ?>
					<li>
					<a href="<?php echo $vid->uri; ?>" class="thumb" title="<?php echo str_replace('"', '', $vid->shortDescription); ?> <em><?php echo $vid->displayDate . ' | ' . $vid->displayTime; ?></em>"><img src="<?php echo $vid->thumbnailURL; ?>" width="90" height="50" alt=""><img class="overlay" src="<?php echo $base_url; ?>assets/images/overlay-90x50.png" alt=""></a>
					<p><a title="<?php echo $vid->name; ?>" href="<?php echo $vid->uri; ?>"><?php echo $vid->name; ?></a></p>
					</li>
					<?php } ?>
                </ul>
                </div> <!-- //subnav-panel:<?php echo $category->name; ?> -->
				<?php foreach ($category->subcategories as $subcategory) { ?>
				<div class="subnav-panel"><p><?php echo str_replace('{0}', $subcategory->name, lang('recent-category')); ?></p>
                <ul class="grid sidebar-grid subnav-grid">
					<?php foreach ($subcategory->preview_videos as $vid) { ?>
					<li>
					<a href="<?php echo $vid->uri; ?>" class="thumb" title="<?php echo str_replace('"', '', $vid->shortDescription); ?> <em><?php echo $vid->displayDate . ' | ' . $vid->displayTime; ?></em>"><img src="<?php echo $vid->thumbnailURL; ?>" width="90" height="50" alt=""><img class="overlay" src="<?php echo $base_url; ?>assets/images/overlay-90x50.png" alt=""></a>
					<p><a title="<?php echo $vid->name; ?>" href="<?php echo $vid->uri; ?>"><?php echo $vid->name; ?></a></p>
					</li>
					<?php } ?>
                </ul>
                </div> <!-- //subnav-panel:<?php echo $subcategory->name; ?> -->
				<?php } ?>

			</div><!-- //subnav-panels: <?php echo $category->name; ?> -->

        </div> <!-- //subnav: <?php echo $category->name; ?> -->

	</li>
	<?php
	$cnt++;

	} ?>
