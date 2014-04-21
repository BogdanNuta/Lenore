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

	<?php echo $ad_snip; ?>

	<br />
	<?php $this->load->view('featuredproviders.php'); ?>
	<?php $this->load->view('popular-videos.php'); ?>
	<?php if(count($videos) > 0) $this->load->view('recent-videos.php'); ?>

</div> <!-- //sidebar-right -->