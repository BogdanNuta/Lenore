<div id="main" class="full-width clearfix">

	<div id="player-container">
		<input type="hidden" id="video-url" value="<?php echo current_url(); ?>" />
		<script type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>
		<object id="myExperience" class="BrightcoveExperience">
			<param name="bgcolor" value="#FFFFFF" />
			<param name="width" value="646" />
			<param name="height" value="412" />
			<param name="playerID" value="<?php echo $this->config->item('bc-player-id'); ?>" />
			<param name="playerKey" value="<?php echo $this->config->item('bc-player-key'); ?>" />
			<param name="isVid" value="true" />
			<param name="dynamicStreaming" value="true" />
			<param name="@videoPlayer" value="<?php echo $video->id; ?>" />
			<param name="linkBaseUrl" value="<?php echo current_url(); ?>" />
			<param name="videoSmoothing" value="<?php echo lang('enable-video-smoothing'); ?>" />
	        <param name=wmode value="transparent">
		</object>
		<script type="text/javascript">brightcove.createExperiences();</script>
		<div id="video-meta">
	        <h1><?php echo $video->name; ?></h1>
	        <p><?php echo $video->shortDescription; ?></p>
	        <!--<a href="http://www.cbc.ca/" target="_blank"><img id="cbca" src="<?php echo $base_url; ?>assets/images/cbca.gif" alt=""></a>-->
	        <?php
	        if(isset($video->customFields->source)) {
				foreach ($sources_data->sources as $source) {
					if($video->customFields->source == $source->name )
					{
						echo strlen($source->link) > 0 ? '<a href="' . $source->link . '" target="_blank"><img class="source-logo" src="' . $source->image . '" alt="' . $source->name . '"></a>' : '<a href="javascript:void(0)"><img class="source-logo" src="' . $source->image . '" alt="' . $source->name . '"></a>' . "\n";
					}
				}
	        }
	        ?>
	        <div class="meta" data-id="<?php echo $video->id; ?>">
		        <div class='meta-item'><?php echo $video->displayDate; ?></div> <span class="spacer meta-item">|</span>
		        <div class="rating meta-item" id="rating-active"></div> <span class="spacer meta-item">|</span>
		        <!-- AddThis Button BEGIN -->
				<div class="share meta-item"><?php echo lang('share-this-via'); ?></div>
				<div id="add_this meta-item" class="addthis_toolbox addthis_default_style"  addthis:url="<?php echo current_url(); ?>" addthis:title="<?php echo $video->name;?> - Sympatico.ca Video">
					<a class="addthis_button_facebook"></a>
                    <a class="addthis_button_twitter"></a>
                    <a class="addthis_button_email"></a>
					<a class="addthis_button_compact"></a>
				</div>
				<!-- AddThis Button END -->
				<!-- <a href="https://twitter.com/share?url=<?php echo urlencode(current_url()); ?>" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>-->
		        <!-- <iframe class="share-facebook" src="http://www.facebook.com/plugins/like.php?app_id=145027182240706&amp;href=<?php echo urlencode(current_url()); ?>&amp;send=false&amp;layout=button_count&amp;width=49&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=24" scrolling="no" frameborder="0" allowTransparency="true"></iframe> --> 
	        </div> <!--meta-->
		</div> <!-- video-meta"-->
 	</div> <!-- player-container-->

	<div id="player-tabs" class="tabs">
        <ul class="nav">
        	<?php 
            $commentVideoUrl = $video->uri; 
        	if(strpos($commentVideoUrl, '?') !== false) {
                $commentVideoUrl = substr($commentVideoUrl, 0, strpos($commentVideoUrl, '?'));
        	}
        	
        	$originalCommentVideoUrl = $commentVideoUrl;
        	$commentVideoUrl = urlencode($commentVideoUrl);
            
            $curl_handle=curl_init();
            curl_setopt($curl_handle,CURLOPT_URL,"https://graph.facebook.com?ids=" . $commentVideoUrl);
            curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
            curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            $commentCountJson = curl_exec($curl_handle);
            curl_close($curl_handle);
            
            $fb_response = json_decode($commentCountJson, true);
            
            $commentCount = 0;
            
            if(isset($fb_response[$originalCommentVideoUrl]))
            {
                if(isset($fb_response[$originalCommentVideoUrl]["comments"]))
                {
                    $commentCount = $fb_response[$originalCommentVideoUrl]["comments"];
                }
            }
          	?>
        	<li class="first-child"><a href="#"><span id="comment-count" class="count"><?php echo $commentCount; ?></span><?php echo lang('comments'); ?></a></li>
          	
          	<!-- <li<?php echo sizeof($videos) <= 1 && sizeof($related_videos) > 0 ? ' class="selected"' : ''; ?>><a href="#"><?php echo lang('related'); ?></a></li> -->
            <!-- <li class="last-child<?php echo sizeof($videos) <= 1 ? '' : ' selected'; ?>"><a href="#"><?php echo lang('up-next'); ?></a></li> -->
         	<li class="selected"><a href="#"><?php echo lang('up-next'); ?></a></li>
            <li class="last-child related"><a href="#"><?php echo lang('related'); ?></a></li> 
        </ul> 
       
       	<!-- facebook plugin -->
		<div class="panel-comments panel">
        	<div id="comments-list" class="fb_ltr">
        		<?php 
        		
        		$tempFBUrlArray = array();
                $sses = explode("%2F", $commentVideoUrl);
                $encodeNext = false;
                foreach($sses as $ss)
                {
                	if($encodeNext == true)
                	{
                		$ss = urlencode($ss);
                	}
                	if($ss == "watch")
                	{
                		$encodeNext = true;
                	}
                	
                	array_push($tempFBUrlArray, $ss);
                }        		
        		?>
				<div class="fb-comments" data-href="<?php echo implode("%2F", $tempFBUrlArray); ?>" data-num-posts="1" data-width="298" data-colorscheme="dark"></div>
			</div>			
		</div> <!-- //panel-comments panel -->
        
                <?php $this->load->view('video-details-up-next.php'); ?>
		<?php $this->load->view('video-details-related-videos.php'); ?>
	
		<!-- the code below has been commented out replace comments block with facebook comments plugin
        <!--<div id="panel-comments" class="panel">
        		<div id="comments-list">
				<?php $this->load->view('comments.php'); ?>
				</div> <!-- //comments-list -->
			<!--<form action="#" method="post" name="comments_form">
					<input type="hidden" name="video_id" id="video_id" value="<?php echo $video->id; ?>" />
					<textarea placeholder="<?php echo lang('add-your-comment'); ?>" name="comments_input" id="comments_input"></textarea>
					<a href="javascript:void(0)" id="add-comment" class="butt on blue"><?php echo lang('add-comment'); ?></a>
				</form>
		</div> <!-- //panel-comments --> 
	</div> <!-- player-tabs -->
	<div id="related-links" class="box">
		<p class="title"><?php echo lang('related-links'); ?></p>
		<div id="related-link-details">
		<?php $this->load->view('relatedlinks.php'); ?>
		</div>
	</div> <!-- //related-links -->
</div> <!-- //main -->

<!-- for details view, body is after main, otherwise the body is defined in banner.php before main -->
<div id="body" class="padded clearfix">
