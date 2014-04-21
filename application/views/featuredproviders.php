<div id="featured-providers" class="box">
	<p class="title"><?php echo lang('featured-providers'); ?></p>
	<ul>
	<?php foreach ($featuredproviders as $featuredprovider) { ?>
		<li>
		<a class="thumb" href="<?php echo $featuredprovider['pageUrl']; ?>"><img src="<?php echo $featuredprovider['imageUrl']; ?>" width="80" height="45" alt="" /></a>
		<a href="<?php echo $featuredprovider['pageUrl']; ?>"><?php echo $featuredprovider['name']; ?> &raquo;</a>
		<p><?php echo $featuredprovider['description']; ?></p>
		</li>
	<?php } ?>
	</ul>
</div> <!-- //featured-providers -->
