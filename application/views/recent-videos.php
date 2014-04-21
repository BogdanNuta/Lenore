	<div class="carousel" id="recent-videos">
		<div class="bar">
			<?php echo $scroll_links_recent; ?>
			<h2><?php echo lang('recent-videos'); ?></h2>
		</div> <!-- bar -->
        <ul class="grid sidebar-grid">
			<?php
			$tcnt = 0;
			$cnt = 0;
			foreach ($recent_videos as $video) {

				if($tcnt < $this->config->item('page-size-scroll'))
				{

				$li_class = "";
				if($cnt == 2 || $cnt == 5) $li_class = ' class="last-in-row"';
				if($cnt == 3) $li_class = ' class="first-in-row"';
			?>
			<?php if($cnt == 0) { ?>
			<li><ul>
			<?php } ?>
			<li<?php echo $li_class; ?>>
				<a href="<?php echo $video->uri; ?>" class="thumb" title="<?php echo str_replace('"', '', $video->shortDescription); ?> <em><?php echo $video->displayDate . ' | ' . $video->displayTime; ?></em>"><img src="<?php echo strlen($video->thumbnailURL) > 0 ? $video->thumbnailURL : $base_url . 'assets/images/empty-90x50.gif'; ?>" width="90" height="50" alt=""><img class="overlay" src="<?php echo $base_url; ?>assets/images/overlay-90x50.png" alt=""></a>
				<p><a title="<?php echo $video->name; ?>" href="<?php echo $video->uri; ?>"><?php echo strlen($video->name) > 35 ? substr($video->name, 0, 35) . '...' : $video->name; ?></a></p>
				<em title="<?php echo !isset($video->customFields->source) ? '' : $video->customFields->source; ?>"><?php echo !isset($video->customFields->source) ? '' : (strlen($video->customFields->source) > 12 ? substr($video->customFields->source, 0, 12) . '...' : $video->customFields->source); ?></em>
			</li>
			<?php if($cnt == 5) { ?>
			</ul></li>
			<?php } ?>
			<?php
				if($cnt == 5) {
					$cnt = 0;
				} else {
					$cnt++;
				}
				$tcnt++;

				} // end tcnt < config check
			} ?>
		</ul> <!-- //grid sidebar-grid -->
	</div> <!-- //carousel > recent-videos -->
