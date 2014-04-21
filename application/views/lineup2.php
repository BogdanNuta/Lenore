<div id="content">

	<?php if(isset($msg)) { ?>
	<div id="msg" style="color:#fff; padding:0px 0px 10px 4px; font-weight:bold; border-bottom:1px solid #444; margin-bottom:10px;"><?php echo $msg; ?></div>
	<?php } ?>

	<?php foreach ($lineups as $lineup) {
            // if the lineup is null skip the current loop. lineup is null
            //when one (or more) ids in the lineup configuration is invalid
            if($lineup == null) continue;
            ?>
	<div class="carousel">
		<div class="bar">
			<ul class="carousel-pagination">
			<li class="prev"><a href="#"></a></li>
			<li class="pages"><span class="on">&bull;</span><span>&bull;</span><span>&bull;</span></li>
			<li class="next"><a href="#"></a></li>
			</ul>
			<h2><?php echo $lineup->name; ?> <!-- <?php echo $lineup->id; ?> --></h2>
		</div> <!-- //bar -->
		<ul class="grid">
	    <?php
	    $cnt = 0;
	    foreach ($lineup->videos as $video)
	    {
	    	if($cnt < 12)
	    	{
			$li_class = "";
			if($cnt == 0) $li_class = "first-child";
                        if($cnt == 11 || sizeof($lineup->videos) == ($cnt-1) ) $li_class = "last-child";
			//if(sizeof($lineup->videos) == ($cnt-1)) $li_class = "last-child";
	    ?>
			<li class="<?php echo $li_class; ?>">
			<a href="<?php echo $video->uri . '&lineupid=' . $lineup->id; ?>" class="thumb" title="<?php echo str_replace('"', '&quot;', $video->shortDescription); ?> <em><?php echo $video->displayDate . ' | ' . $video->displayTime; ?></em>"><img src="<?php echo $video->thumbnailURL; ?>" alt="" width="118" height="66"><img class="overlay" src="<?php echo $base_url; ?>/assets/images/overlay-118x66.png" alt=""></a>
			<p><a href="<?php echo $video->uri . '&lineupid=' . $lineup->id; ?>"><?php echo strlen($video->name) > 35 ? substr($video->name, 0, 35) . '...' : $video->name; ?></a></p>
			<em><?php echo $video->customFields == null ? '' : $video->customFields->source; ?></em>
			</li>
	    <?php
			$cnt++;
			}
		} ?>
		</ul> <!-- //grid -->
	</div> <!-- //carousel -->
	<?php } ?>
</div> <!-- //content -->


