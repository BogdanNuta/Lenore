<div id="sidebar-right">

	<?php /*
	<script language="javascript" src="http://www.googletagservices.com/tag/static/google_services.js"></script>
	<script language="javascript">
	adSlot300x250 = googletag.defineSlot('/%network%/%site%/%zone%', [300, 250]);
	adSlot300x250.set("ad_type", "flash");
	adSlot300x250.addService(googletag.companionAds());
	adSlot300x250.addService(googletag.content());
	googletag.enableServices();
	</script>
	<script type="text/javascript">
	googletag.display('/%network%/%site%/%zone%', [300, 250]);
	</script>
	*/ ?>
	
	<?php 
    if(isset($custom_html_content_1) && $custom_html_content_1 != "")
    {
       echo $custom_html_content_1 . "<br />\n";
    }
    ?>

	<?php echo $ad_snip; ?>
	
	<br />
	
	<?php 
    if(isset($custom_html_content_2) && $custom_html_content_2 != "")
    {
       echo $custom_html_content_2 . "<br />\n";
    }
    ?>

	
	<?php $this->load->view('popular-videos.php'); ?>
	
	<?php 
    if(isset($custom_html_content_3) && $custom_html_content_3 != "")
    {
       echo $custom_html_content_3 . "<br />\n";
    }
    ?>
	
	<?php $this->load->view('recent-videos.php'); ?>
	
	<?php 
    if(isset($custom_html_content_4) && $custom_html_content_4 != "")
    {
       echo $custom_html_content_4 . "<br />\n";
    }
    ?>

</div> <!-- //sidebar-right -->