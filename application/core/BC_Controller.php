<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BC_Controller extends CI_Controller {

	public $data = array();

	// Set up the requisite system state
	function __construct()
	{
		parent::__construct();

		// Find a valid xx or xx-xx or xx_xx patterened locale in the hostname being accessed, load the related language
		preg_match('/^(?P<lang>([a-z]{2,2}[-_]{1,1}[a-z]{2,2})|([a-z]{2,2}))\./i', $_SERVER['HTTP_HOST'], $m);
		$locale = isset($m['lang']) ? $m['lang'] : 'en';
		$this->data['lang'] = $locale;
		$this->lang->load('pages', $locale);

		// Draw in the BC account information from the language file that was loaded above
		foreach ($this->config->item('portable') as $key) {
			$this->config->set_item($key, $this->lang->line($key));
		}

		// Get the potential GET query param data, using defaults if not set
		foreach ($this->config->item('params') as $key) {
			if (isset($_GET[$key])) {
				$this->config->set_item($key, $_GET[$key]);
			}
		}

		// Load the cache with the driver set in the config file
		$this->load->driver('cache', array('adapter' => $this->config->item('cache-driver')));

		// Load the default models (we do this here so autoload doesn't trump language application)
		$this->load->model('bcmapi', 			'bc');
		$this->load->model('navigation_model', 	'nav');
		$this->load->model('video_model',		'videos');
		$this->load->model('comments_model',	'comments');
		$this->load->model('ratings_model',		'ratings');

		// Populate lineups object if lineup id specified
		if(strlen($this->config->item('lineupid') > 0))
		{
			$this->data['lineup_data'] = $this->videos->get_lineup_videos($this->config->item('lineupid'), $this->nav->get_lineupIdCats());
		}

		// Set the base title
		$this->data['title'] = lang('global-title');
		$this->data['navigation'] = $this->nav->get_items();

		// Load sources data
		$this->data['sources_data'] = $this->nav->get_sources();

		$this->data['site_url'] = site_url();
		$this->data['base_url'] = base_url();

		// set cobrandid from lang file by default
		$this->data['cobrand_id'] = lang('cobrand-id');

		// set ad-snip code from lang file by default;
		$this->data['ad_snip'] = lang('ad-snip');
		
		// set default branding bg
		$this->data['branding_bg'] = lang('branding_bg');
		$this->data['branding_bg_link'] = lang('branding_bg_link');
		$this->data['branding_bg_color'] = lang('branding_bg_color');
		
		//set default content areas
		
		$this->data['custom_html_banner'] = lang('custom_html_banner');
		$this->data['custom_html_content_1'] = lang('custom_html_content_1');
		$this->data['custom_html_content_2'] = lang('custom_html_content_2');
		$this->data['custom_html_content_3'] = lang('custom_html_content_3');
		$this->data['custom_html_content_4'] = lang('custom_html_content_4');
		
		$this->data['locale_code'] = lang('locale_code');
		if($this->data['locale_code'] == "")
		{
		    $this->data['locale_code'] = "en_US";
		}

		// Set default omniture market
		$this->data['omniture_market'] = lang('omniture_market');
		$this->data['omniture_meta'] = lang('omniture_meta');

		// Set display value for sort
		$this->data['sort_display'] = $this->nav->get_sort_display();

		$this->data['providers_list'] = lang('all_provider_names');
		$this->data['image_slider'] = lang('image-slider');

		$this->data['page_title'] = lang('global-title');

		// Set locale based on lang value
		if($this->data["lang"] == "fr") {
			setlocale(LC_TIME, 'fr_CA.UTF8');
		} else {
			setlocale(LC_TIME, 'en_US');
		}

	}

	// Accepts the views and data to load with an optional auto-wrap in the header and footer views
	protected function loadViews($views, $data, $wrap = true)
	{
		if ($wrap) { $this->load->view('header', $data); }

		if(is_array($views))
		{
			for($i = 0; $i < sizeof($views); $i++)
			{
				$this->load->view($views[$i], $data);
			}
		}
		if(is_string($views))
		{
			$this->load->view($views, $data);
		}

		if ($wrap) { $this->load->view('footer', $data); }
	}
}
