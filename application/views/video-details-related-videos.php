        <div class="panel">
          <div class="carousel">
            <ul class="grid sidebar-grid" id="related-videos">
			<?php
			$cnt = 0;
			
			$videoUris = array();
			foreach($related_videos as $video)
			{
			    $tempVideoUri = $video->uri; 
    			if(strpos($tempVideoUri, '?') !== false) {
        		    $tempVideoUri = substr($tempVideoUri, 0, strpos($tempVideoUri, '?'));
            	}
            	
			    array_push($videoUris, urlencode($tempVideoUri));
			}
			
			$curl_handle=curl_init();
            curl_setopt($curl_handle,CURLOPT_URL,"https://graph.facebook.com?ids=" . join(",", $videoUris));
            curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
            curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
            $commentCountRelatedJson = curl_exec($curl_handle);
            curl_close($curl_handle);
            
            $commentCountsRelated = json_decode($commentCountRelatedJson, true);
			
			foreach ($related_videos as $video) {

				$li_class = "";
				if($cnt == 2 || $cnt == 5) $li_class = ' class="last-in-row"';
				if($cnt == 3) $li_class = ' class="first-in-row"';
			?>
			<?php if($cnt == 0) { ?>
			<li><ul>
			<?php } ?>
			<li<?php echo $li_class; ?> id="v-<?php echo $video->id; ?>">
				<a href="<?php echo $video->uri; ?>" class="thumb" title="<?php echo str_replace('"', '', $video->shortDescription); ?> <em><?php echo $video->displayDate . ' | ' . $video->displayTime; ?></em>"><img src="<?php echo strlen($video->thumbnailURL) > 0 ? $video->thumbnailURL : $base_url . 'assets/images/empty-90x50.gif'; ?>" width="90" height="50" alt=""><img class="overlay overlay-tabs" src="<?php echo $base_url; ?>assets/images/overlay-90x50.png" alt="" width="90" height="50"></a>
				<p><a title="<?php echo $video->name; ?>" href="<?php echo $video->uri; ?>"><?php echo strlen($video->name) > 35 ? substr($video->name, 0, 35) . '...' : $video->name; ?></a></p>
				<em title="<?php echo !isset($video->customFields->source) ? '' : $video->customFields->source; ?>"><?php echo !isset($video->customFields->source) ? '' : (strlen($video->customFields->source) > 12 ? substr($video->customFields->source, 0, 12) . '...' : $video->customFields->source); ?></em>
				<div style="display:none;" id="video-meta-<?php echo $video->id; ?>">
			        <h1><?php echo $video->name; ?></h1>
			        <p><?php echo $video->shortDescription; ?></p>
			        <!--<a href="http://www.cbc.ca/" target="_blank"><img id="cbca" src="<?php echo $base_url; ?>assets/images/cbca.gif" alt=""></a>-->
			        <?php
			        if(isset($video->customFields->source)) {
						foreach ($sources_data->sources as $source) {
							if($video->customFields->source == $source->name )
							{
								echo strlen($source->link) > 0 ? '<a href="' . $source->link . '" target="_blank"><img class="source-logo" src="' . $source->image . '" alt="' . $source->name . '"></a>' : '<img class="source-logo" src="' . $source->image . '" alt="' . $source->name . '">';  							
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
						<!-- <a href="https://twitter.com/share?url=<?php echo urlencode(current_url()); ?>" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
				        <iframe class="share-facebook" src="http://www.facebook.com/plugins/like.php?app_id=145027182240706&amp;href=<?php echo urlencode(current_url()); ?>&amp;send=false&amp;layout=button_count&amp;width=49&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=24" scrolling="no" frameborder="0" allowTransparency="true"></iframe> -->
			        </div>
				</div>				
				<div style="display:none;" id="related-link-<?php echo $video->id; ?>">
				<?php $this->load->view('relatedlinks.php'); ?>
				</div>
				<div class="fb_ltr" style="display:none;" id="comments-list-<?php echo $video->id; ?>">
					<?php 
					    $commentVideoUrl = $video->uri; 
            			if(strpos($commentVideoUrl, '?') !== false) {
                		    $commentVideoUrl = substr($commentVideoUrl, 0, strpos($commentVideoUrl, '?'));
                    	}
                    	
                    	$commentCount = 0;
				    
    				    if(isset($commentCountsRelated[$commentVideoUrl]))
                        {
                            if(isset($commentCountsRelated[$commentVideoUrl]["comments"]))
                            {
                                $commentCount = $commentCountsRelated[$commentVideoUrl]["comments"];
                            }
                        }
					?>
					
				</div>
				<div style="display:none;" id="comment-count-<?php echo $video->id; ?>"><?php echo $commentCount; ?></div>
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

			} ?>
            </ul> <!-- //grid sidebar-grid: related -->

			<?php echo $scroll_links_related; ?>

          </div> <!-- //carousel: related -->
        </div> <!-- //panel: related -->
