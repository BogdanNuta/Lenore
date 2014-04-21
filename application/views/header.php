<!doctype html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $page_title; ?><?php echo isset($video) ? ' - ' . $video->name : ''; ?></title>
	<meta name="description" content="<?php echo isset($video) ? $video->shortDescription : ''; ?>">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">

<?php
# video sitemaps and
# Facebook Open Graph
# support
if(isset($video)){
echo <<<EOF
        <meta property="og:title" content="{$video->name}" />
        <meta property="og:type" content="video" />
        <meta property="og:duration" content="{$video->displayTime}" />
        <meta property="og:url" content="{$video->uri}">
        <meta property="og:image" content="{$video->thumbnailURL}" />\n
        <meta property="og:video" content="http://admin.brightcove.com/viewer/us20120501.1602/BrightcoveBootloader.swf?playerID=1422553007001&purl=&domain=embed&isVid=1&publisherID=18120656001&videoID={$video->id}" />\n
        <meta property="video:player_loc" content="http://admin.brightcove.com/viewer/us20120501.1602/BrightcoveBootloader.swf?playerID=1422553007001&purl=&domain=embed&isVid=1&publisherID=18120656001&videoID={$video->id}" />\n
        <meta property="og:locale" content="{$locale_code}" />\n
EOF;
}
?>

	<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
	<script type="text/javascript">
		var lang = "<?php echo $lang; ?>";
		var base_url = "<?php echo $base_url; ?>";
		var current_url = "<?php echo $base_url . $this->uri->uri_string(); ?>/";
		var lang_ratings_text = "<?php echo lang('ratings-text'); ?>";
		var lang_enter_search_term = "<?php echo lang('enter-search-term'); ?>";
		var rating = <?php echo !isset($rating) ? '0' : round($rating[0]->rating); ?>;
		var pagepath = "<?php echo isset($path) ? $path : ''; ?>";
		var pagetags = "<?php echo isset($tags) ? $tags : ''; ?>";

		// omniture settings
		function omniture_market () {
			return "<?php echo $omniture_market; ?>";
		}
		function omniture_section () {
			return "<?php echo str_replace('"','',$breadcrumb_display); ?>";
		}
		function omniture_meta () {
			return "<?php echo $omniture_meta; ?>";
		}

	</script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script src="<?php echo $base_url; ?>assets/js/brightcove.js"></script>
	<script src="http://admin.brightcove.com/js/BrightcoveExperiences_all.js"></script>

<?php
$env_pre = explode('?',$_SERVER['REQUEST_URI']);
$env_level = explode('/',$env_pre[0]);
if(""==$env_level[1]||"divertissement"==$env_level[1]||"lifestyle"==$env_level[1]){
echo <<<EOF
        <!-- begin VM code -->
        <script src="http://ad.viewablemedia.net/ads.min.js" type="text/javascript"></script>
        <!-- end VM code -->\n
EOF;
}
?>

	<script language="JavaScript">
		var adServer,aamPageId,aamRndNum;
		adServer = 'http://bellcan.adbureau.net';
		aamPageId = Math.round(Math.random() * 1000000000);
		for (aamRndNum = ''; aamRndNum.length < 10;)
		aamRndNum += Math.round(Math.random() * 10);
	</script>

<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?php echo ($lang == "fr") ? 'UA-20036619-4' : 'UA-20036619-1'; ?>']);
_gaq.push(['_setDomainName', '.sympatico.ca']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
 
</script>

<script type="text/javascript">var addthis_config = {"data_track_addressbar":true, "ui_language":"<?php echo $lang; ?>"};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4e67938c21467f18"></script>

</head>

<body>

<?php

# @TODO: not in view

$env_pre   = explode('?',$_SERVER['REQUEST_URI']);
$env_level = explode('/',$env_pre[0]);

$s_sL1 = "";
$s_sL2 = "";
$s_sL3 = "";
$s_sL4 = "";

if(isset($video->name)&&""!=$video->name)$omni_title = $video->name;
else $omni_title = $page_title;

if(isset($env_level[1])&&""!=$env_level[1])$s_sL1 = $env_level[1];
if(isset($env_level[2])&&""!=$env_level[2])$s_sL2 = $env_level[2];
if(isset($env_level[3])&&""!=$env_level[3])$s_sL3 = $env_level[3];
if(isset($env_level[4])&&""!=$env_level[4])$s_sL4 = $env_level[4];


echo <<<EOF
<!-- Omniture Code - Start -->
<script language="javascript" type="text/javascript">
        s_rsID= "";
        s_tEFlag= false;
        s_pName= "{$omni_title}";
        s_sL1="{$_SERVER['HTTP_HOST']}";
        s_sL2="{$s_sL1}";
        s_sL3="{$s_sL2}";
        s_sL4="{$s_sL3}";
        s_cT="";
        s_ISP="";
        s_dL="
EOF;
echo lang('omni-lang');
echo <<<EOF
";
        s_sS="";
        s_pG1="";
        s_pG2="";
        s_lU="";
        s_cG="";
</script>
EOF;
?>
<script language="javascript" type="text/javascript" src="http://content-resources.sympatico.ca/content/channels/global/omniture/test/s_code.js"></script>
<script language="javascript" type="text/javascript">
	<!--
	var s_code=s.t();if(s_code)document.write(s_code);
	//-->
</script>
<script language="javascript" type="text/javascript">
	<!--
	if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-');
	//-->
</script>
<noscript>
	<img src="http://sympmsnp12.112.2O7.net/b/ss/bcspglobalenglishdev/1/H.19.4--NS/0" height="1" width="1" border="0" alt="" />
</noscript>
<!-- Omniture Code - End -->

<!-- ComScore Beacon Tag -->
<script type="text/javascript">
var Comscore_BeaconEnabled = 'true';
if (Comscore_BeaconEnabled.toLowerCase() == 'true') {
document.write(unescape("%3Cscript src='" + (document.location.protocol == "https:" ? "https://sb" : "http://b")
+ ".scorecardresearch.com/beacon.js' %3E%3C/script%3E"));
}
</script>
<script type="text/javascript">
if (Comscore_BeaconEnabled.toLowerCase() == 'true') {
COMSCORE.beacon({
c1: 2,
c2:'6485645',
c3:'',
c4:window.location.href,
c5:'',
c6:'',
c15:''
});
}
</script>
<noscript>
<img src="http://b.scorecardresearch.com/p?c1=2&c2=&c3=&c4=&c5=&c6=&c15=&cj=1" />
</noscript>
<!-- END ComScore Beacon -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/<?php echo $locale_code; ?>/all.js#xfbml=1&appId=452560464757998";
    fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));</script>


<div id="container" role="main">

<script type="text/javascript">
/* OnlineOpinion (S3tS v3.1) */
/* This product and other products of OpinionLab, Inc. are protected by U.S. Patent No. 6606581, 6421724, 6785717 B1 
and other patents pending. */
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~ Added by Karthik Nagaraj - Project TACO ~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~ Friday June 12th, 2009 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
var custom_var;
var _sp = '%3A\\/\\/';
var _rp = '%3A//';
var _poE = 0.0;
var _poX = 0.0;
var _sH = 0;

if (screen!=undefined)
{
    try
    {
        _sH=screen.height;
    }
    catch(ex)
    {
        _sH=0;
    }
}

var _d = document;
var _w = window;
var _ht = escape(_w.location.href);
var _hr = _d.referrer;
var _tm = (new Date()).getTime();
var _kp = 0;
var _sW = 0;

if (screen!=undefined)
{
    try
    {
        _sW=screen.width;
    }
    catch(ex)
    {
        _sW=0;
    }
}

function _fC(_u) {
    _aT = _sp + ',\\/,\\.,-,_,' + _rp + ',%2F,%2E,%2D,%5F'; _aA = _aT.split(',');
    for (i = 0; i < 5; i++) {
        eval('_u=_u.replace(/' + _aA[i] + '/g,_aA[i+5])')
    }
    return _u
};

function O_LC() {
    _w.open('https://secure.opinionlab.com/ccc01/comment_card.asp?time1=' + _tm + '&time2=' + (new Date()).getTime() 
+ '&prev=' + _fC(escape(_hr)) + '&referer=' + _fC(_ht) + '&height=' + _sH + '&width=' + _sW + '&custom_var=' + 
custom_var,
'comments',
'width=535,height=192,screenX=' + ((_sW - 535) / 2) + ',screenY=' + ((_sH - 192) / 2) + ',top=' + ((_sH - 192) / 2) + 
',left=' + ((_sW - 535) / 2) + ',resizable=yes,copyhistory=yes,scrollbars=no')
};

function _fPe() {
    if (Math.random() >= 1.0 - _poE)
    { O_LC(); _poX = 0.0 }

};

function _fPx() {
    if (Math.random() >= 1.0 - _poX)
        O_LC()
};

window.onunload = _fPx;

function O_GoT(_p) {
    _d.write('<a href=\'javascript:O_LC()\'>' + _p + '</a>');
    _fPe()
}
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<?php if(trim($branding_bg) != "" && trim($branding_bg_link) != "")
    {
?>
// ADD ONCLICK FOR BRANDING
$('body').bind('click', function (evt) {
    if(evt.target == $('body')[0]) {
      window.open('<?php echo $branding_bg_link; ?>');
    }
  });
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<?php 
    }
?>
</script>

<style type="text/css">
// css for cobrand lite
// @TODO: merge against existing classes in css file

#cbl{
background-color:#232323;
color:#fff;
font-family:Tahoma,Verdana,sans-serif;
}

#cbl .cbl_h{
width:980px;
height:65px;
background:transparent url(http://cobrand.sympatico.ca/Bell.Sympatico.CMS/Images/Header/hdrBg.png) no-repeat top 
left;
}

#cbl .cbl_h .cbl_logo {
position:relative;
padding-top:20px;
font-size:17px;
line-height:0.1em;
}
#cbl .cbl_h .cbl_logo .cbl_channel{
position:absolute;
top:30px;
left:50%;
margin-left:-330px;
}

#cbl .cbl_h .cbl_nav{
font-family:Verdana,Arial,sans-serif;
font-size:10px;
height:9px;
line-height: 16px;
float:right;
}

#cbl a{
text-decoration:none;
color:#fff
}
#cbl img {
border:0
}

<?php 
    if((trim($branding_bg) != "") || (trim($branding_bg_color) != "")) 
    {
        $bgColor = "#000000";
        $cursor_string = "";
        
        if(trim($branding_bg_color != ""))
        {
            if(preg_match('/^#[a-f0-9]{6}$/i', $branding_bg_color))
            {
                $bgColor = $branding_bg_color;
            }
        }
        
        if(trim($branding_bg_link) != "")
        {
            $cursor_string = " cursor: pointer;";   
        }
?>
body { background: <?php echo $bgColor; ?> url(<?php echo $branding_bg; ?>) no-repeat top center;<?php echo $cursor_string; ?> }
#container, #footer { cursor: default; }
<?php } ?>
</style>

<div id="cbl">
  <div class="cbl_h">
    <div class="cbl_logo">
      <a href="<?php echo lang('hp-url'); ?>"><img 
src="http://cobrand.sympatico.ca/Bell.Sympatico.CMS/Images/general/logos/SympaticoCa_hdrLogo.png" /></a>
      <div class="cbl_channel"><a href="<?php echo $base_url; ?>"><?php echo lang('video-text'); ?></a></div>
    </div>
    <div class="cbl_nav">
<a href="<?php echo lang('hp-url'); ?>"><?php echo lang('home-text'); ?></a> | <a 
href="<?php echo lang('alt-hp-url'); ?>"><?php echo lang('alt-text'); ?></a> | <a 
href="<?php echo lang('help-url'); ?>"><?php echo lang('help'); ?></a> | <!--BEGIN QUALTRICS FEEDBACK LINK-->
<script type="text/javascript" src="https://bellmedia.qualtrics.com/SE/?SID=SV_1LEizRzXVsenTEh&FeedbackJS=1&width=900&height=600&tooltip=Cliquez ici pour nous donner votre opinion.&linktext=Commentaires"></script>
<noscript><a target="_blank" href="https://bellmedia.qualtrics.com/SE/?SID=SV_1LEizRzXVsenTEh">Commentaires</a></noscript>
<!--END QUALTRICS FEEDBACK LINK-->
    </div>
  </div>
</div>

    <div id="header">
     <!-- <div id="more">
        <a href="#"><img src="<?php echo $base_url; ?>assets/images/btn-more.gif" alt="more"></a>
      </div>
      <ul id="subnav">
        <li><a href="<?php echo $base_url; ?>">Home</a><span>|</span></li>
        <li><a href="#">Francais</a><span>|</span></li>
        <li><a href="#">Help</a><span>|</span></li>
        <li><a href="#"><span>[+]</span> Feedback</a></li>
      </ul> --> <!-- //subnav -->
     <!-- <a href="<?php echo $base_url; ?>"><img src="<?php echo $base_url; ?>assets/images/logo.png" alt="<?php echo lang('global-title'); ?>"></a> -->

      <ul id="nav">
		<?php $this->load->view('menu.php'); ?>
        <li class="last-child">
          <form method="get" action="<?php echo $base_url; ?>search" onsubmit="return Brightcove.ValidateSearch()">
            <input type="text" class="text" name="term" id="term" placeholder="<?php echo lang('search-label'); ?>">
            <input type="image" src="<?php echo $base_url; ?>assets/images/btn-search.gif" alt="<?php echo lang('search'); ?>">
          </form>
        </li>
      </ul> <!-- //nav -->
    </div> <!-- //header -->
<?php 
    if(isset($custom_html_banner) && $custom_html_banner != "")
    {
       echo $custom_html_banner;
    }
?>
