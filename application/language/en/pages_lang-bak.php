<?php

$lang['bc-read-token'] = 'DOBLdwC9JGAdyON1-KTJXUmnaSuB7e13KNNE_YhnNmghAmh9RLh8Kg..';
$lang['bc-player-id'] = '1268889104001';
$lang['bc-player-key'] = 'AQ~~,AAAABDgTRIE~,dClR7p8J_XVz4N8MYwYNsL8JIhbzNCh6';
//$lang['base_url'] = 'http://en.psdev.brightcove.com/sympatico/';
#$lang['base_url'] = 'http://en.video.sympatico.ca/'; // production environment
// $lang['base_url'] = 'http://localhost:8081/sympatico/bcbi/videoportal/'; // local environment
$lang['enable-video-smoothing'] = 'false';
//$lang['base_url'] = 'http://en.dev.brightcove.siteworx.com/bcbi/
#$lang['base_url'] = 'http://en.video.bcove.us/';
$lang['base_url']  = 'http://en.stg.svideo.ca/';

//lineups configuration. Contains the Playlist ids used to generate featured lineups.
//$lang['lineup_playlist_ids'] = '1263138361001,1250138431001,647920575001,1199944920001,34611024001';

// default cobrandid
$lang['cobrand-id'] = 1022;

// omniture settigns
$lang['omniture_market'] = 18120656001;
$lang['omniture_meta'] = "test-meta";

// default ad snip
$lang['ad-snip'] = '<script language="javascript" src="http://www.googletagservices.com/tag/static/google_services.js"></script>
	<script language="javascript">
	// Use googletag.defineSlot() to create ad slots.
	adSlot1 = googletag.defineSlot(\'/%network%/%site%/%zone%\', [300, 250]);
	adSlot1.set("ad_type", "flash");
	adSlot1.addService(googletag.companionAds());
	adSlot1.addService(googletag.content());
	// Use the content service to set the initial content of the ad slot.
	googletag.content().setContent(adSlot1, "<iframe src=\'http://ad.doubleclick.net/N5479/adi/symp.en.video/general;tile=2;sz=300x250;ord=123456789?\' width=\'300\' height=\'250\' marginwidth=0 marginheight=0 scrolling=no></iframe>");
	// Enable companion ads service
	googletag.enableServices();
	</script>
	<div class="advertisement">
		<div id="300x250">
		<script language="javascript">googletag.display(\'/%network%/%site%/%zone%\', [300, 250]);</script>
		</div>
	</div>';

$lang['branding_bg'] = '';
$lang['branding_bg_link'] = '';
$lang['branding_bg_color'] = '';

$lang['custom_html_banner'] = '';
$lang['custom_html_content_1'] = '';
$lang['custom_html_content_2'] = '';
$lang['custom_html_content_3'] = '';
$lang['custom_html_content_4'] = '';

$lang['locale_code'] = "en_US";

// url pointing to code to render image slider banner
#$lang['image-slider'] = 'http://bsympatico.vo.llnwd.net/o35/feeds/video_slider/en_home.js';
$lang['image-slider'] = 'http://content-resources.sympatico.ca/content/channels/_autogen/js/en_home.js';

/*
// Collection of featured Providers. URLs must start with http://
$lang['featured_providers'] = array( array("name" => "CNN",
                 "description" => 'Our premium provider',
                 "pageUrl" => 'http://www.cnn.com',
                 "imageUrl" => 'http://i.cdn.turner.com/cnn/.element/img/3.0/global/header/hdr-main.gif'
                ),
            array("name" => "ESPN",
                  "description" => 'Our platinum provider',
                  "pageUrl" => 'http://www.espn.com',
                  "imageUrl" => 'http://www.mobiletopsoft.com/blog/wp-content/uploads/2011/05/inter-espn.gif'
                   ),
            array("name" => "CBS",
                  "description" => 'Our premium provider',
                  "pageUrl" => 'http://www.cbs.com',
                  "imageUrl" => 'http://www.tbwe.com/pub/categoryitems/CBS_tn.jpg'
                  )
        );
*/
// Collection of featured Providers. URLs must start with http://
$lang['featured_providers'] = array( array("name" => "CTV.ca",
                 "description" => 'Watch TV Online; Full Episodes; TV Schedule Listing',
                 "pageUrl" => 'http://www.ctv.ca',
                 "imageUrl" => 'http://bellca.vo.llnwd.net/e1/bellinet/brightcove/providers/ctv.gif'
                ),
            array("name" => "etalk",
                  "description" => 'Movie Reviews & Ratings; Hollywood Celebrity Gossip',
                  "pageUrl" => 'http://www.ctv.ca/entertainment/',
                  "imageUrl" => 'http://bellca.vo.llnwd.net/e1/bellinet/brightcove/providers/etalk.gif'
                   ),
            array("name" => "Business News Network",
                  "description" => 'Business and Financial News; Analysis, Video and Blogs',
                  "pageUrl" => 'http://www.bnn.ca',
                  "imageUrl" => 'http://bellca.vo.llnwd.net/e1/bellinet/brightcove/providers/bnn.gif'
                  )
        );

$lang['all_provider_names'] = array ("Associated Press","BNN","Canadian Living","CBC","CNW","CNW","CTV","eTalk","Fashionism.ca","inMusic.ca","Jokeroo","Neighbourhood Mechanic","News Canada","NYFP.TV","Orange","PopSugar Rush","PopSugar TV","Push.ca","Splash","Split Decision","Sympatico.ca Autos","Sync.ca","UFC","Watch Mojo","YourMoney.ca");

$lang['sort_options'] = array (
			array("name" => "Most Recent", "key" => "date"),
            array("name" => "Alphabetical", "key" => "name"),
            array("name" => "Popular This Week", "key" => "popular"),
            array("name" => "Popular All Time", "key" => "plays_total"),
			array("name" => "Start Date", "key" => "start_date")
        );

$lang['related-link-icon-1'] = "http://en.video.bcove.us/assets/images/icon-read.gif";
$lang['related-link-icon-2'] = "http://en.video.bcove.us/assets/images/icon-read.gif";
$lang['related-link-icon-3'] = "http://en.video.bcove.us/assets/images/icon-read.gif";

$lang['date_display_format'] = '%B %d, %Y';

// Global
$lang['global-title'] = 'Sympatico.ca Video';

// Title
$lang['title-separator'] = ' - ';

// Breadcrumbs
$lang['breadcrumb-home'] = 'Home';

// Search
$lang['search'] = 'Search';
$lang['search-title'] = 'Search Results';
$lang['search-results'] = '{0} search results for "{1}"';
$lang['search-label'] = 'Search Videos';
$lang['search-no-results'] = 'There are no results that match your search for &quot;{0}&quot;.';
$lang['zero-results'] = '0 Results for &quot;{0}&quot;';
$lang['enter-search-term'] = "Please enter a search term";

// Pagination
$lang['pagination-of'] = ' of ';
$lang['pagination-videos'] = ' videos';
$lang['pagination-next'] = 'Next';
$lang['pagination-prev'] = 'Previous';
$lang['pagination-summary'] = '{0}-{1} of {2} videos';

$lang['no-videos'] = 'Sorry, there are no videos for your selection';
$lang['ratings-text'] = '1 Star,2 Stars,3 Stars,4 Stars,5 Stars';
$lang['featured'] = 'Featured';
$lang['most-recent'] = 'Most Recent';
$lang['recent-category'] = 'Recent {0}';
$lang['popular-all-time'] = 'Popular All Time';
$lang['popular-this-week'] = 'Popular This Week';
$lang['start-date'] = 'Start Date';
$lang['all-providers'] = 'All Providers';
$lang['popular-videos'] = 'Popular Videos';
$lang['recent-videos'] = 'Recent Videos';
$lang['help'] = 'Help';
$lang['share'] = 'Share';
$lang['feedback'] = 'Feedback';
$lang['up-next'] = 'Up Next';
$lang['related'] = 'Related';
$lang['comments'] = 'Comments';
$lang['related-links'] = 'Related Links';
$lang['add-comment'] = 'Add Comment';
$lang['add-your-comment'] = 'Add Your Comment';
$lang['no-comments'] = 'There are currently no comments on this video. Be the first to comment!';
$lang['featured-providers'] = 'Featured Providers';
$lang['top-stories'] = 'Top Stories';
$lang['share-this-via'] = 'Share this via';

$lang['english'] = 'English';
$lang['french'] = 'Francais';
$lang['terms-of-use'] = 'Terms of Use';
$lang['advertise'] = 'Advertise';
$lang['privacy-statement'] = 'Privacy Statement';
$lang['copyright'] = '&copy; Bell Canada, 2011. All rights reserved.';

$lang['error-404'] = 'Sorry, the page that you requested is not available in the Sympatico gallery.';

# Jan 2012: below vars added
# so we don't need cobrand anymore
$lang['home-text'] = 'Home';
$lang['video-text'] = 'Video';
$lang['omni-lang'] = 'English';
$lang['hp-url'] = 'http://www.sympatico.ca/default.aspx?lang=en-CA';
$lang['alt-text'] = 'Fran&ccedil;ais';
$lang['alt-hp-url'] = 'http://www.sympatico.ca/defaultf.aspx?lang=fr-CA';
$lang['help-url'] = 'http://en.info.sympatico.ca/Contact-us/Home';
$lang['tou-url'] = 'http://en.info.sympatico.ca/go/tou';
$lang['advertise-url'] = 'http://en.info.sympatico.ca/go/advertise';
$lang['privacy-url'] = 'http://en.info.sympatico.ca/go/privacy';

/* End of fipages_lang.php */
/* Location: ./application/language/fr/pages_lang.php */
