<?php if(!isset($active_video_id)) { ?>
<div id="body" class="padded clearfix">
<?php } ?>
<div id="results-wrapper">

	<?php echo $searchsummary; ?>

		<ul class="grid">
		<?php $cnt = 0; foreach ($videos as $video) { ?>
			<li<?php if ($cnt == (sizeof($videos)-1)) { echo ' class="last-child"'; } ?>>
			<table valign="top" ><tr><td valign="bottom">
				<p><a href="<?php echo $video->uri; ?>" class="thumb"><img src="<?php echo $video->thumbnailURL; ?>" width="120" height="68" alt="" /><img class="overlay" src="<?php echo $base_url; ?>assets/images/overlay-120x68.png" alt=""></a></p>
			</td>
			<td valign="top">
				<p class="title"><a href="<?php echo $video->uri; ?>"><?php echo $video->name; ?></a></p>
				<p class="desc"><?php echo $video->shortDescription; ?></p>
				<em><?php echo $video->displayDate; ?> | <?php echo !isset($video->customFields->source) ? '' : $video->customFields->source; ?></em>
			</td></tr></table>
			</li>
	     <?php $cnt++; } ?>
     </ul> <!-- //grid -->

	<?php echo $pagination; ?>

</div> <!-- //results-wrapper -->
