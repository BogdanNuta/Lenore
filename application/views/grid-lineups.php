<div id="content">
	<div class="channel-bar bar">
		<h2>
			<?php echo isset($grid_title) ? $lineup_data[0]->name : lang('top-stories'); ?>
		</h2>
	</div> <!-- //channel-bar bar -->
	<ul class="grid">
	<?php $cnt = 0; foreach ($lineup_data[0]->videos as $video) { ?>
		<li id="li-v-<?php echo $video->id; ?>" class="<?php echo isset($active_video_id) && $active_video_id == $video->id ? 'selected' : ''; ?><?php if ($cnt % 4 == 3) { echo ' last-in-row'; } ?><?php if($cnt % 4 == 0 && $cnt != 0) { echo ' first-in-row'; } ?>">
			<a href="<?php echo $video->uri . '&lineupid=' . $lineup_data[0]->id; ?>" class="thumb" title="<?php echo str_replace('"', '&quot;', $video->shortDescription); ?> <em><?php echo $video->displayDate . ' | ' . $video->displayTime; ?></em>"><img src="<?php echo strlen($video->thumbnailURL) > 0 ? $video->thumbnailURL : $base_url . 'assets/images/empty-118x66.gif'; ?>" width="118" height="66" alt=""><img class="overlay" src="<?php echo $base_url; ?>assets/images/overlay-118x66.png" alt=""></a>
			<p><a href="<?php echo $video->uri . '&lineupid=' . $lineup_data[0]->id; ?>" title="<?php echo $video->name; ?>"><?php echo strlen($video->name) > 55 ? substr($video->name, 0, 55) . '...' : $video->name; ?></a></p>
			<em><?php echo !isset($video->customFields->source) ? '' : $video->customFields->source; ?></em>
		</li>
	<?php $cnt++; } ?>
	</ul> <!-- //grid -->
</div> <!-- //content -->

