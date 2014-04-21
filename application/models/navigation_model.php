<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navigation_model extends CI_Model {

	private $location;
	private $items;
	private $breadcrumbs;
	private $sources;
	
	private $lineupIdCategories;

    public function __construct()
    {
		parent::__construct();

		$this->load->model('video_model','videos');

		$this->location = getcwd() . '/application/language/' . $this->data['lang'] . '/hierarchy.xml';

		// Make sure the hierarchy file exists in our active language
		if(!file_exists($this->location)) {
			$error = 'The navigation file for your configured language ('. $this->language .') does not exist at '. $this->location;
			log_message('error', $error);
			show_error($error, 500);
			die();
		}

		// Set locale based on lang value
		if($this->data["lang"] == "fr") {
			setlocale(LC_TIME, 'fr_FR');
		} else {
			setlocale(LC_TIME, 'en_US');
		}

		$this->make_breadcrumbs((object) array('uri' => base_url(), 'name' => lang('breadcrumb-home')));
		
		$this->lineupIdCategories = array();
		
		$this->create_nav();
		$this->load_sources();

	}

	//-------------------------------------------------------------------------------------------- PUBLIC FUNCTIONS
	public function get_items() {
		return $this->items;
	}

	public function get_sources() {
		return $this->sources;
	}
	
	public function get_lineupIdCats() {
	    return $this->lineupIdCategories;
	}

	// Take multiple arguments representing the slugs of a valid path through the navigation file, return the appropriate node or null
	public function seek () {
		$path = func_get_args();
		$count = count($path);
		$children = array('categories', 'subcategories', 'nodes');
		$items = $this->items;
		for ($j = 0; $j < $count; $j++) {
			$child = $children[$j];
			$found = false;
			foreach ($items->$child as $i) {
				if ($path[$j] == url_title($i->name) || strtolower(url_title($path[$j])) == strtolower(urlencode(url_title($i->name)))) {
					$found = true;
					$this->make_breadcrumbs($i, (isset($children[$j + 1]) ? $children[$j + 1] : false));
					$items = $i;
					break;
				}
			}
			if (!$found) { return null; }
		}

		return $items;
	}

	// For building out an array of breadcrumbs based on navigation items - Automatically built when nav is built
	public function make_breadcrumbs ($append = false, $prune = false) {

		if ($append) {

			// This isn't a typo... We need to dereference the append variable to when we unset the children nodes nothing breaks in the nav builder
			$append = (object) (array) $append;

			if ($prune) { unset($append->$prune); }

			$this->breadcrumbs[] = $append;

		}

		return $this->breadcrumbs;
	}

	public function breadcrumbs_display_text ($breadcrumbs) {
		$output = '';
		foreach($breadcrumbs as $crumb) {
			if(strlen($output) > 0) $output .=  ' > ';
			$output .= $crumb->name;
		}
		return $output;
	}

	//--------------------------------------------------------------------------------------------



	//-------------------------------------------------------------------------------------------- PRIVATE FUNCTIONS
	private function create_nav()
	{
		// check for cached navigation exists
		$this->items = $this->cache->get($this->data['lang'].'_navigation');

		// if cached version does not exist load from xml
		if(!$this->items)
		{
			$this->items = $this->parse_nav_xml();
			$this->load_preview_videos($this->items);
            $this->cache->save($this->data['lang'].'_navigation', $this->items, $this->config->item('cache_refresh'));
        }
        else
        {
            $this->lineupIdCategories = $this->items->lineupIdCats;
        }

		return $this->items;
	}

	private function load_sources()
	{
		$cache_key = 'source_data';
		// check for cached navigation exists
		/*
		$this->sources = $this->cache->get($cache_key);
		// if cached version does not exist load from xml
		if(!$this->sources)
		{
			$this->sources = $this->parse_source_xml();
            $this->cache->save($cache_key, $this->items, $this->config->item('cache_refresh'));
		}
		*/
		$this->sources = $this->parse_source_xml();

		return $this->sources;
	}

	private function parse_source_xml() {

		$location = getcwd() . '/assets/xml/sources.xml';
		$sources = simplexml_load_file($location);

		// Items will be the top-level object that contains categories
		$items = (object) array('sources' => array());

		//handle categories
		foreach($sources->source as $source)
		{
			$item = (object) array(
				'name' => null,
				'image' => null,
				'link' => null
			);
			foreach($source->attributes() as $key => $value) {
				switch($key) {
					case 'name':
						$item->name = trim((string) $value);
						break;
				}
			}
			$item->image = trim((string) $source->image);
			$item->link = trim((string) $source->link);
			array_push($items->sources, $item);
		}

		return $items;
	}


	private function load_preview_videos($nav)
	{
		foreach ($nav->categories as $category) {
			$uri = url_title($category->name) . '/';
			$category->preview_videos = $this->videos->get_preview_videos ($uri, array('tag:' . $category->tags), $this->data['lang']);
			foreach ($category->subcategories as $subcategory) {
				$uri = url_title($category->name) . '/' . url_title($subcategory->name) . '/';
				$subcategory->preview_videos = $this->videos->get_preview_videos ($uri, array('tag:' . $subcategory->tags), $this->data['lang']);
			}
		}
	}

	private function parse_nav_xml() {
		/*
		Samples structure of the object that gets returned from this function:

		items = {
			categories = [
			     {
			          name: "Category Name"
			          subcategories: [
			               {
			                    name: "My Playlist Name",
			                    playlistID: 1196642127001,
			                    player: null,
			                    tags: null,
			                    uri: "http://domain.com/something/...",
		 						lineups: "",
		 						counts: "",
		 						newText: "",
		  						defaultSort: "",
		  						defaultOrder: ""
		 		               },
			               {
			                    name: "A Different Subcategory Name",
			                    tags: "news",
			                    playlistID: null,
			                    player: null,
			                    uri: "http://domain.com/something/...",
		 						lineups: "",
		 						counts: "",
		 						newText: "",
		  						defaultSort: "",
		  						defaultOrder: ""
			               }
			          ] //close subcategories array
			     } //close category object
			] //close categories array
		} //close items
		*/

		$navigation = simplexml_load_file($this->location);

		// Items will be the top-level object that contains categories
		$items = (object) array('categories' => array(), 'lineupIdCats' => array());

		//handle categories
		foreach($navigation->category as $nav_category) {
			$category = $this->build_nav_object($nav_category->attributes());
			$category->subcategories = array();
			$category->uri = $this->get_uri($category);
			if(isset($category->lineupPlaylistId))
			{
			    $this->set_category_uri_for_lineup_playlist($category->lineupPlaylistId, $this->get_uri($category, false, false, true));
			}

			foreach($nav_category->subcategory as $nav_subcategory) {
				$subcategory = $this->build_nav_object($nav_subcategory->attributes());
				$subcategory->nodes = array();
				$subcategory->uri = $this->get_uri($category, $subcategory);
    			if(isset($subcategory->lineupPlaylistId))
    			{
    			    $this->set_category_uri_for_lineup_playlist($subcategory->lineupPlaylistId, $this->get_uri($category, $subcategory, false, true));
    			}

				foreach($nav_subcategory->node as $nav_node) {
					$node = $this->build_nav_object($nav_node->attributes());
					$node->uri = $this->get_uri($category, $subcategory, $node);
    				if(isset($node->lineupPlaylistId))
        			{
        			    $this->set_category_uri_for_lineup_playlist($node->lineupPlaylistId, $this->get_uri($category, $subcategory, $node, true));
        			}
					array_push($subcategory->nodes, $node);
				}

				array_push($category->subcategories, $subcategory);
			}

			array_push($items->categories, $category);
		}
		
		$items->lineupIdCats = $this->lineupIdCategories;
  //      echo 'PLEASE DISREGARD THIS TEST DATA';
//		print_r($items->lineupIdCats);
//        echo '<hr />';
//        die();
		return $items;
	}

    /**
     * Traverses the Category tree and returns the Playlist ids assigned
     * to the category name passed into this method. We could improve the
     * application performance by copying into cache an associative array
     * of Categories -> playlist ids.
     *
     * @param type $categoryName the category name
     * @return type Playlist IDs CVS assigned to a particular Category.
     */
    public function get_playlist_id_by_category($categoryName){
        $navigation = $this->get_items();
        foreach ($navigation->categories as $category) {
            if (url_title($category->name) == $categoryName)
                return $category->lineupids;
        }
    }

    /**
     * Returns the Home node that is stored in the Navigation object.
     * The first node it is always the first child in the hierarchy
     * @return type
     */
    public function get_home_node(){
        $navigation = $this->get_items();
        $homeNode = $navigation->categories[0];
        return $homeNode;

    }

	// Build consistent navigation items for each of the levels
	private function build_nav_object($attributes) {

		$item = (object) array(
			'name' => null,
			'tags' => null,
			'playerID' => null,
			'playerKey' => null,
			'playlistID' => null,
			'providers' => null,
			'visible' => true,
			'lineupids' => null,
			'cobrandId' => null,
			'counts' => null,
			'newText' => null,
			'defaultSort' => null,
			'defaultOrder' => null,
			'imageSlider' => null,
			'adSnip' => null,
		    'lineupPlaylistId' => null,
		    'brandingBg' => null,
		    'brandingBgLink' => null,
		    'brandingBgColor' => null,
		    'customHtmlBanner' => null,
		    'customHtmlContent1' => null,
		    'customHtmlContent2' => null,
		    'customHtmlContent3' => null,
		    'customHtmlContent4' => null
		);

		foreach($attributes as $key => $value) {
			switch($key) {
				case 'name':
					$item->name = trim((string) $value);
					break;
				case 'tags':
					$item->tags = trim((string) $value);
					break;
				case 'displayPlayerId':
					$item->playerID = trim((string) $value);
					break;
				case 'playerKey':
					$item->playerKey = trim((string) $value);
					break;
				case 'playlist_id':
					$item->playlistID = trim((string) $value);
					break;
				case 'providers':
					$item->providers = trim((string) $value);
					break;
				case 'visible':
					$item->visible = (boolean) trim((string) $value);
					break;
                case 'lineupids':
                    $item->lineupids = trim((string) $value);
					break;
				case 'cobrandId':
					$item->cobrandId = trim((string) $value);
					break;
				case 'counts':
					$item->counts = trim((string) $value);
					break;
				case 'imageSlider':
					$item->imageSlider = trim((string) $value);
					break;
 				case 'newText':
					$item->newText = trim((string) $value);
					break;
 				case 'adSnip':
					$item->adSnip = trim((string) $value);
					break;
				case 'defaultSort':
					$item->defaultSort = trim((string) $value);
					break;
 				case 'lineupPlaylistId':
					$item->lineupPlaylistId = trim((string) $value);
					break;
 				case 'brandingBg':
					$item->brandingBg = trim((string) $value);
					break;
 				case 'brandingBgLink':
					$item->brandingBgLink = trim((string) $value);
					break;
 				case 'brandingBgColor':
					$item->brandingBgColor = trim((string) $value);
					break;
 				case 'customHtmlBanner':
 				    $item->customHtmlBanner = trim((string) $value);
 				    break;
 				case 'customHtmlContent1':
 				    $item->customHtmlContent1 = trim((string) $value);
 				    break;
 				case 'customHtmlContent2':
 				    $item->customHtmlContent2 = trim((string) $value);
 				    break;
 				case 'customHtmlContent3':
 				    $item->customHtmlContent3 = trim((string) $value);
 				    break;
 				case 'customHtmlContent4':
 				    $item->customHtmlContent4 = trim((string) $value);
 				    break;
				case 'defaultOrder':
					$item->defaultOrder = trim((string) $value);
			}
		}
		
		return $item;
	}

	// Helper for creating URLs based on the nav structure
	private function get_uri($category, $subcategory = false, $node = false, $uriOnly = false) {
	    $uri = '';
	    if($uriOnly == true)
	    {
	        $uri = url_title($category->name) . '/';
	    }
	    else
	    {
	        $uri = site_url() . url_title($category->name) . '/';
	    }
		
		if($subcategory) { $uri .= url_title($subcategory->name) . '/'; }
		if($node) { $uri .= url_title($node->name) . '/'; }
		return $uri;
	}


	public function get_pagination_summary($page = 0, $total)
	{
		$output = "";
		$per_page = (int)$this->config->item('page-size');
		$start_page = 1;
		$end_page = $total;
		if($total == 0) $start_page = 0;
		if($page == 0 || $page == 1) {
			if($total < $per_page) {
				$end_page = $total;
			} else {
				$end_page = $per_page;
			}
		} else {
			$start_page = (($page-1) * $per_page) + 1;
			if($per_page < ($total-$start_page)) {
				$end_page = ($start_page + $per_page)-1;
			} else {
				$end_page = $total;
			}
		}
		$output = '<p>' . str_replace('{0}', $start_page, lang('pagination-summary'));
		$output = str_replace('{1}', $end_page, $output);
		$output = str_replace('{2}', $total, $output) . '</p>';

		return $output;
	}

	public function get_sort_display()
	{
		$output = '';
		foreach(lang('sort_options') as $sort) {
	   		if($sort['key'] == $this->config->item('sort'))
			{
				$output = $sort['name'];
			}
		}
		return $output;
	}

	public function get_scroll_bullets($cnt, $section)
	{
        $output = '';
		if($cnt > 6) {
	        $output .= '<ul class="carousel-pagination">';
				$output .= '<li class="prev"><a href="#"></a></li>';
				$output .= '<li class="pages">';
				$output .= '<span class="on">&bull;</span>';
				if($cnt > 6) $output .= '<span>&bull;</span>';
				if($cnt > 12) $output .= '<span>&bull;</span>';
		        $output .= '</li>';
		        $output .= '<li class="next"><a href="#"></a></li>';
	        $output .= '</ul> <!-- //carousel-pagination: ' . $section .  ' -->';
		}
		return $output;
	}
	
	private function set_category_uri_for_lineup_playlist($lineupPlaylistId, $category_uri)
	{
	    $this->lineupIdCategories[$lineupPlaylistId] = $category_uri;
	}
	
	public function get_category_uri_for_lineup_playlist($lineupPlaylistId)
	{
	    if(isset($this->lineupIdCategories[$lineupPlaylistId]))
	    {
	        return $this->lineupIdCategories[$lineupPlaylistId];
	    }
	    else
	    {
	        return null;
	    }
	}

}

/* End of file navigation_model.php */
/* Location: ./application/models/navigation_model.php */