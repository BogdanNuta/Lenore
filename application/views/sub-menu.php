<?php if(strlen($this->uri->uri_string())==0) { ?>
	<?php foreach ($navigation->categories[0]->subcategories as $subcategory) { ?>
		<li class="<?php if(sizeof($subcategory->nodes) == 0) { echo 'no-submenu'; } ?><?php if($this->uri->segment(2) == url_title($subcategory->name)) { echo ' active'; } ?>">
		<a href="<?php echo $subcategory->uri; ?>"><?php echo $subcategory->name; ?></a>
		<?php if(sizeof($subcategory->nodes) > 0) { ?>
			<ul>
			<?php foreach ($subcategory->nodes as $node) { ?>
				<li class="<?php if($this->uri->segment(3) == url_title($node->name)) { echo 'active'; } ?>">
				<a href="<?php echo $node->uri; ?>"><?php echo $node->name; ?></a>
				</li>
			<?php } ?>
			</ul>
		<?php } ?>
		</li>
	<?php } ?>
<?php } ?>

<?php foreach ($navigation->categories as $nav) { ?>
	<?php if($this->uri->segment(1) == url_title($nav->name) || strtolower($this->uri->segment(1)) == strtolower(urlencode(url_title($nav->name)))) { ?>
		<li class="no-submenu<?php echo $this->uri->total_segments() == 1 ? ' active' : ''; ?>"><a href="<?php echo $base_url . $this->uri->segment(1); ?>"><?php echo lang('featured'); ?></a></li>
		<?php foreach ($nav->subcategories as $subcategory) { ?>
			<?php if($subcategory->name != "") { ?>
			<li class="<?php if(sizeof($subcategory->nodes) == 0) { echo 'no-submenu'; } ?><?php if($this->uri->segment(2) == url_title($subcategory->name)) { echo ' active'; } ?>">
			<a href="<?php echo $subcategory->uri; ?>"><?php echo $subcategory->name; ?></a>
			<?php if(sizeof($subcategory->nodes) > 0) { ?>
				<ul>
				<?php foreach ($subcategory->nodes as $node) { ?>
					<li class="<?php if($this->uri->segment(3) == url_title($node->name)) { echo 'active'; } ?>">
					<a href="<?php echo $node->uri; ?>"><?php echo $node->name; ?></a>
					</li>
				<?php } ?>
				</ul>
			<?php } ?>
			</li>
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>


