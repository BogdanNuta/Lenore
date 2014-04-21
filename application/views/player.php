  
	<h1><?php echo $video->name; ?></h1>
	
	<!-- Start of Brightcove Player -->

	<div style="display:none"></div>

	<!--
	By use of this code snippet, I agree to the Brightcove Publisher T and C 
	found at https://accounts.brightcove.com/en/terms-and-conditions/. 
	-->

	<script type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>

	<object id="myExperience" class="BrightcoveExperience">
		<param name="bgcolor" value="#FFFFFF" />
		<param name="width" value="486" />
		<param name="height" value="412" />
		<param name="playerID" value="<?php echo $this->config->item('bc-player-id'); ?>" />
		<param name="playerKey" value="<?php echo $this->config->item('bc-player-key'); ?>" />
		<param name="isVid" value="true" />
		<param name="dynamicStreaming" value="true" />
		<param name="@videoPlayer" value="<?php echo $video->id; ?>" />
	</object>

	<!-- 
	This script tag will cause the Brightcove Players defined above it to be created as soon
	as the line is read by the browser. If you wish to have the player instantiated only after
	the rest of the HTML is processed and the page load is complete, remove the line.
	-->
	<script type="text/javascript">brightcove.createExperiences();</script>

	<!-- End of Brightcove Player -->
	
	<h4>Rating: <?php if($rating != null) { echo $rating[0]->rating; } else { echo '0'; } ?></h4>
	<p>Rate: <a href="#">1</a>&nbsp;<a href="#">2</a>&nbsp;<a href="#">3</a>&nbsp;<a href="#">4</a>&nbsp;<a href="#">5</a></p>
	
	<!-- comments -->
	<h4>Comments: (<?php echo $comments_size; ?>)</h4>
	<?php if($comments != null) { ?>
	<ul>
		<?php foreach ($comments as $c) { ?>
		<li><p class="comment"><?php echo $c->comment; ?></p><p class="date"><?php echo date("F j, Y", $c->date); ?></p></li>
		<?php } ?>
	</ul>
	<?php } ?>
	