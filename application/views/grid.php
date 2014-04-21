<div id="content">

	<div class="channel-bar bar">
		<ul class="filters dropdown">
			<li>
				<a href="#" class="<?php echo $this->config->item('sort'); ?>" id="grid-sort-label"><?php echo isset($sort_display) ? $sort_display : lang('most-recent'); ?></a>
				<ul>
					<?php foreach(lang('sort_options') as $sort) { ?>
	                <li><a href="<?php echo $base_url . $this->uri->uri_string() . '/?sort=' . $sort['key'] . (strlen($this->config->item('filter')) > 0 ? '&filter=' . $this->config->item('filter') : '') . '&page=1'; ?>" onclick="return false;" class="grid-sort-options" id="sort-<?php echo $sort['key'] ?>"><?php echo $sort['name'] ?></a></li>
					<?php } ?>
                </ul>			
            </li>
			<li>
				<a href="#" class="<?php echo $this->config->item('filter'); ?>" id="grid-filter-label"><?php echo strlen($this->config->item('filter')) > 0 ? $this->config->item('filter') : lang('all-providers'); ?></a>
				<ul>
	                <li><a href="<?php echo $base_url . $this->uri->uri_string() . '/?sort=' . $this->config->item('sort') . '&page=1'; ?>" class="grid-filter-provider" onclick="return false;" id="provider-all"><?php echo lang('all-providers'); ?></a></li>
					<?php foreach($providers_list as $provider) { ?>
	                <li><a href="<?php echo $base_url . $this->uri->uri_string() . '/?sort=' . $this->config->item('sort') . '&filter=' . $provider . '&page=1'; ?>" class="grid-filter-provider" onclick="return false;" id="provider-<?php echo $provider ?>"><?php echo $provider ?></a></li>
					<?php } ?>
                </ul>			
            </li>
			</li>
		</ul>
		<h2 title="<?php echo $grid_title; ?>">
			<?php echo isset($show_newest) && $show_newest ? 'Newest' : ''; ?>
			<?php echo isset($grid_title) ? (strlen($grid_title) > 20 ? substr($grid_title,0,20) . '...' : $grid_title) : lang('top-stories'); ?>
			<?php echo isset($show_count) && $show_count ? '&nbsp;(' . $total_count . ')' : ''; ?>
		</h2>
	</div> <!-- //channel-bar bar -->

	<div id="grid-wrapper">
		
		<ul class="grid">
		<?php $cnt = 0; foreach ($videos as $video) { ?>
			<li id="li-v-<?php echo $video->id; ?>" class="<?php echo isset($active_video_id) && $active_video_id == $video->id ? 'selected' : ''; ?><?php if ($cnt % 4 == 3) { echo ' last-in-row'; } ?><?php if($cnt % 4 == 0 && $cnt != 0) { echo ' first-in-row'; } ?>">
				<a href="<?php echo $video->uri; ?>" class="thumb" title="<?php echo str_replace('"', '&quot;', $video->shortDescription); ?> <em><?php echo $video->displayDate . ' | ' . $video->displayTime; ?></em>"><img src="<?php echo strlen($video->thumbnailURL) > 0 ? $video->thumbnailURL : $base_url . 'assets/images/empty-118x66.gif'; ?>" width="118" height="66" alt=""><img class="overlay" src="<?php echo $base_url; ?>assets/images/overlay-118x66.png" alt=""></a>
				<p><a href="<?php echo $video->uri; ?>" title="<?php echo $video->name; ?>"><?php echo strlen($video->name) > 55 ? substr($video->name, 0, 55) . '...' : $video->name; ?></a></p>
				<em><?php echo !isset($video->customFields->source) ? '' : $video->customFields->source; ?></em>
			</li>
		<?php $cnt++; } ?>
		</ul> <!-- //grid -->
		<?php if(sizeof($videos) == 0) { ?>
			<div class="no-videos"><?php echo lang('no-videos'); ?></div>
		<?php } ?>
		<?php echo sizeof($videos) > 0 ? $pagination . "\n" : '' . "\n"; ?>
		
	</div> <!-- // grid-wrapper -->

</div> <!-- //content -->

