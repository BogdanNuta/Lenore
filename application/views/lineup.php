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
<?php /* 
$env_pre = explode('?',$_SERVER['REQUEST_URI']);
$env_level = explode('/',$env_pre[0]);
//if("fr"==$lang){
if(""==$env_level[1]||"divertissement"==$env_level[1]||"lifestyle"==$env_level[1]){
echo <<<EOF
	<!-- BEGIN VM example block -->

		<div class="carousel">
		<div class="bar">

			<h2>
EOF;
if ("fr"==$lang) echo "Vid&eacute;o commandit&eacute;<!-- 34593061001 -->";
else echo "Promoted Video";
echo <<<EOF
                        </h2>
		</div> <!-- //bar -->
		<ul class="grid" id="vidworks">
		</ul> <!-- //grid -->
	</div> <!-- //carousel -->	
	 <script>
	      var adtag;
	      function onThumbClick(){
          var clip_id = this.id.substring("_vmc_".length, this.id.length);        // jQuery sets 'this' to element receiving click
          $.each(adtag.ad_info.videos, function(i, ad){
            if( ad.creative == clip_id){
              // For this cross page example, we must first fire the click pixel to the Viewable Media Ad Server -- and then switch pages
              // passing the YT ID of the video to be played
              adtag.fireEvent({event: 'click', index: i, 
                // Wait until all pixels fire before moving to next page...
                onComplete: function(){
                  var url = ad.video_id_or_url;
                  window.location = url;
                }
              });       // Tell the Viewable Media ad server which ad we are interested in
              return false;          
            }
          });
        }	        

        // Create and ad tag with custom rendering
        var options = {
EOF;
if("fr"==$lang) echo "pl: 5645, //pl 327\n";
else echo "pl: 5633,\n";
echo <<<EOF
          n: 4,        
          //env: "staging",       // 'env' for demo only; omit for production ad server         	
          templateFunction: function(ad_info){
            var apiContainer = $("#vidworks");
        
            // Render the HTML for each video returned
            $.each( ad_info.videos, function(i,ad){
              ad.enable_auto_play = true;             
              try {
                var cls = (i == 0) ? "first-child" : (i == ad_info.videos.length-1) ? "last-child" : "";
                var li = $("<li/>", {'class': cls});
                var a = $("<a/>", {'class': 'thumb', title: ad.description,  id: "_vmc_"+ad.creative, style: "cursor: pointer;"});   // FIXME href ?
                var img = $("<img/>", {src: ad.thumbnail_url,  width: 118, height: 66, alt: "" });
                var img2 = $("<img/>", {src: "http://en.video.sympatico.ca/assets/images/overlay-118x66.png",  'class': "overlay", alt: ""});
                var p = $("<p/>");
                var a2 = $("<a/>", {href: "#", text: ad.title});
                a2.appendTo(p);
                img.appendTo(a);
                img2.appendTo(a);
                a.appendTo(li);
                p.appendTo(li);
                //$("<em/>", {text: "Push.ca"}).appendTo(li);
                li.appendTo(apiContainer);
              } catch(e){ }
            });
            // Hook up click event to all the thumbnails
            $('#vidworks *  a').bind('click', onThumbClick);           
          }       
        };
        // Fetch the ads from viewablemedia
        adtag = new viewablemedia.AdTag();
        adtag.createAd(options);
	 
	 </script>
	<!-- end VM example block -->
EOF;
}
*/?>
	
</div> <!-- //content -->

