<?php

$lang['bc-read-token'] = '9nSXC1dudLOZkBuPjDCQE7_5mUs9oup4VRLggEvilq8e4h4uzKkIlg..';
$lang['bc-player-id'] = '1273986077001';
$lang['bc-player-key'] = 'AQ~~,AAAABpiQBLk~,kulvdPP89HWF_4IP06aSQ3aB2vpVTOtP';
//$lang['base_url'] = 'http://fr.psdev.brightcove.com/sympatico/';
// $lang['base_url'] = 'http://fr.video.sympatico.ca/'; // production environment
#$lang['base_url'] = 'http://fr.svideo.ca/'; // test environment
//$lang['base_url'] = 'http://fr.dev.brightcove.siteworx.com/bcbi/videoportal/'; // test environment
#$lang['base_url'] = 'http://fr.video.bcove.us/';
$lang['base_url']  = 'http://fr.video.sympatico.ca/';

$lang['enable-video-smoothing'] = 'false';

//lineups configuration. Contains the Playlist ids used to generate the lineup views.
//$lang['lineup_playlist_ids'] = '76738155001,46882293001,1242934213001';

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

$lang['locale_code'] = "fr_CA";

// url pointing to code to render image slider banner
#$lang['image-slider'] = 'http://bsympatico.vo.llnwd.net/o35/feeds/video_slider/fr_accueil.js';
$lang['image-slider'] = 'http://content-resources.sympatico.ca/content/channels/_autogen/js/fr_accueil.js';

/*
// Collection of featured Providers. URLs must start with http://
$lang['featured_providers'] = array( array("name" => "CNN",
                 "description" => 'French providers',
                 "pageUrl" => 'http://www.cnn.com',
                 "imageUrl" => 'http://i.cdn.turner.com/cnn/.element/img/3.0/global/header/hdr-main.gif'
                ),
            array("name" => "ESPN",
                  "description" => 'French providers',
                  "pageUrl" => 'http://www.espn.com',
                  "imageUrl" => 'http://www.mobiletopsoft.com/blog/wp-content/uploads/2011/05/inter-espn.gif'
                   ),
            array("name" => "CBS",
                  "description" => 'French providers',
                  "pageUrl" => 'http://www.cbs.com',
                  "imageUrl" => 'http://www.tbwe.com/pub/categoryitems/CBS_tn.jpg'
                  )
        );
*/
// Collection of featured Providers. URLs must start with http://
$lang['featured_providers'] = array( array("name" => "SRC",
                 "description" => 'Radio-Canada',
                 "pageUrl" => 'http://www.radio-canada.ca/',
                 "imageUrl" => 'http://bellca.vo.llnwd.net/e1/bellinet/brightcove/providers/logo_radio-canada_119.jpg'
                ),
            array("name" => "Bombetv",
                  "description" => 'Bombe.TV',
                  "pageUrl" => 'http://www.bombe.tv/',
                  "imageUrl" => 'http://bellca.vo.llnwd.net/e1/bellinet/brightcove/providers/logo_bombetv_119.jpg'
                   ),
            array("name" => "KWAD9",
                  "description" => 'KWAD9',
                  "pageUrl" => 'http://www.kwad9.ca/',
                  "imageUrl" => 'http://bellca.vo.llnwd.net/e1/bellinet/brightcove/providers/logo_kwad9_119.jpg'
                  )
        );

$lang['related-link-icon-1'] = "http://en.video.bcove.us/assets/images/icon-read.gif";
$lang['related-link-icon-2'] = "http://en.video.bcove.us/assets/images/icon-read.gif";
$lang['related-link-icon-3'] = "http://en.video.bcove.us/assets/images/icon-read.gif";

$lang['all_provider_names'] = array ("CTV","CBC","inMovies.ca","YourMoney.ca");

$lang['sort_options'] = array ( 
			array("name" => "Nouveaux", "key" => "date"),
            array("name" => "Alphabétique", "key" => "name"),
            array("name" => "Vues cette semaine", "key" => "popular"),
            array("name" => "Vues depuis toujours", "key" => "plays_total"),
			array("name" => "Par date", "key" => "start_date")
        );

$lang['date_display_format'] = '%e %B, %Y';

// Global
$lang['global-title'] = 'Sympatico.ca Vidéo';

// Title
$lang['title-separator'] = ' - ';

// Breadcrumbs
$lang['breadcrumb-home'] = 'Home';

// Search
$lang['search'] = 'Recherche';
$lang['search-title'] = 'Résultats de la recherche';
$lang['search-results'] = '{0} résultats de la recherche pour "{1}"';
$lang['search-label'] = 'Recherche vidéos';
$lang['search-no-results'] = 'Il n\'y a pas de résultat pour &quot;{0}&quot;.';
$lang['zero-results'] = '0 résultats pour &quot;{0}&quot;';
$lang['enter-search-term'] = "SVP entrer un terme de recherche";

// Pagination
$lang['pagination-of'] = ' de ';
$lang['pagination-videos'] = ' vidéos';
$lang['pagination-next'] = 'Suivant';
$lang['pagination-prev'] = 'Précédent';
$lang['pagination-summary'] = '{0}-{1} de {2} vidéos';

$lang['no-videos'] = 'Désolé, il n\'y a pas de vidéos pour votre sélection';
$lang['ratings-text'] = '1 Étoile,2 Étoiles,3 Étoiles,4 Étoiles,5 Étoiles';
$lang['featured'] = 'À voir';
$lang['most-recent'] = 'Plus récent';
$lang['recent-category'] = 'Nouveautés {0}';
$lang['popular-all-time'] = 'Les plus populaires';
$lang['popular-this-week'] = 'Populaires cette semaine';
$lang['start-date'] = 'Par date';
$lang['all-providers'] = 'Toutes sources';
$lang['popular-videos'] = 'Top Vidéo';
$lang['recent-videos'] = 'Les plus récentes';
$lang['help'] = 'Aide';
$lang['share'] = 'Partager';
$lang['feedback'] = 'Commentaires';
$lang['up-next'] = 'Plus';
$lang['related'] = 'Suggestions';
$lang['comments'] = 'Commentaires';
$lang['related-links'] = 'Découvrez aussi';
$lang['add-comment'] = 'Ajouter commentaire';
$lang['add-your-comment'] = 'Ajoutez votre commentaire';
$lang['no-comments'] = 'Il n\'y a pas de commentaire pour cette vidéo, soyez le premier à commenter!';
$lang['featured-providers'] = 'Émetteurs en vedette';
$lang['top-stories'] = 'À voir';
$lang['share-this-via'] = 'Partagez avec';

$lang['english'] = 'English';
$lang['french'] = 'Fran&ccedil;ais';
$lang['terms-of-use'] = 'Conditions d\'utilisation';
$lang['advertise'] = 'Publicit&eacute;';
$lang['privacy-statement'] = 'Clause de confidentialit&eacute;';
$lang['copyright'] = '&copy Bell Canada, 2012. Tous droits r&eacute;serv&eacute;s.';

$lang['error-404'] = 'Désolé, la page demandée est introuvable parmi la galerie de Sympatico.';

# Jan 2012: below vars added
# so we don't need cobrand anymore
$lang['home-text'] = 'Accueil';
$lang['video-text'] = 'Vid&eacute;o';
$lang['omni-lang'] = 'French';
$lang['hp-url'] = 'http://www.sympatico.ca/defaultf.aspx?lang=fr-CA';
$lang['alt-text'] = 'English';
$lang['alt-hp-url'] = 'http://www.sympatico.ca/default.aspx?lang=en-CA';
$lang['help-url'] = 'http://fr.info.sympatico.ca/ContactezNous/index';
$lang['tou-url'] = 'http://fr.info.sympatico.ca/go/conditions-utilisation';
$lang['advertise-url'] = 'http://fr.info.sympatico.ca/go/publicite';
$lang['privacy-url'] = 'http://fr.info.sympatico.ca/go/confidentialite';

/* End of file pages_lang.php */
/* Location: ./application/language/fr/pages_lang.php */
