<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Browse extends BC_Controller {

	private $skip = false;


        /**
         * Constructor
         */
	public function __construct(){
		parent::__construct();
	}



	// Handle the hierarchical browse state
	public function index () {

		if(isset($_GET['msg'])) { $this->data['msg'] = $_GET['msg']; }

		$include_views = array('banner','sidebar-left','lineup','sidebar-right');
		$data_view = 'grid';
		$path = '';

		// Grab an unknown number of arguments
		$args = func_get_args();

	    // Home page featured line-up TODO: needs refactoring, create private function.
	    if(count($args) == 0){
	        $homeNode = $this->nav->get_home_node();
			$collection = $this->videos->get_lineups(url_title($homeNode->name),$homeNode->lineupids);

			$this->data['path'] = $path;			
			$this->data['tags'] = $homeNode->tags;			

			if($homeNode->cobrandId != "") $this->data['cobrand_id'] = $homeNode->cobrandId;
			if($homeNode->adSnip != "") $this->data['ad_snip'] = base64_decode($homeNode->adSnip);
			$this->data['show_count'] = $homeNode->counts == "1" ? true : false;
			$this->data['show_newest'] = $homeNode->newText == "1" ? true : false;
			// Check if specific slider url is set for top level nav, if so, override value set in lang file
			if(isset($homeNode->imageSlider)) {
				if(strlen($homeNode->imageSlider) > 0) { $this->data['image_slider'] = $homeNode->imageSlider; }
			}
			
			// Check the power-vertical for a custom player ID, else load player id from lang file
			if(isset($homeNode->playerID)) {
				if(strlen($homeNode->playerID) > 0) {
					$this->config->set_item('bc-player-id',$homeNode->playerID);
				} else {
					$this->config->set_item('bc-player-id',lang('bc-player-id'));
				}
			}

			// Check the power-vertical for a custom player Key, else load player id from lang file
			if(isset($homeNode->playerKey)) {
				if(strlen($homeNode->playerKey) > 0) {
					$this->config->set_item('bc-player-key',$homeNode->playerKey);
				} else {
					$this->config->set_item('bc-player-key',lang('bc-player-key'));
				}
			}
			
			foreach ($collection as $lineup) {
				foreach ($lineup->videos as $video) {
					$video->uri = str_replace('/watch/','/' . url_title($homeNode->name) . '/watch/', $video->uri);
				}
			}
            $this->data['lineups'] = $collection;
	    }

		//This is only executed when a category in the nav bar is selected and it is used to generate the Featured Lineups.
        if (count($args) == 1) {
            $playlist_ids = $this->nav->get_playlist_id_by_category($args[0]);
			if($playlist_ids != null) {
	            $this->data['lineups'] = $this->videos->get_lineups($args[0],$playlist_ids);
				$data_view = 'lineup';
			}
        }

		// Retrieves Featured Providers configurantion from the language specific config file.
		$this->data['featuredproviders'] = lang('featured_providers');

		// Default to all videos if we don't have a valid subview
		if (count($args)) {

			// Always grab first top-node settings
			$top_node = call_user_func_array(array($this->nav, 'seek'), array($args[0]));

			// Take any number of arguments for varying path depth and call the nav seek method
			$node = call_user_func_array(array($this->nav, 'seek'), $args);

			// Build path based on active section		
			foreach($args as $seg) {
				if(strlen($path) > 0) $path .= '/';
				$path .= $seg;
			}
			$this->data['path'] = $path;			
			$this->data['tags'] = $node->tags;			

			// Set cobrandid in order of lang file > top node > current node
			if($top_node->cobrandId != "") $this->data['cobrand_id'] = $top_node->cobrandId;
			if($node->cobrandId != "") $this->data['cobrand_id'] = $node->cobrandId;

			// Set ad-snip in order of lang file > top node > current node
			if($top_node->adSnip != "") $this->data['ad_snip'] = base64_decode($top_node->adSnip);
			if($node->adSnip != "") $this->data['ad_snip'] = base64_decode($node->adSnip);

			// Set show count and show newest setting from top-node
			$this->data['show_count'] = $top_node->counts == "1" ? true : false;
			$this->data['show_newest'] = $top_node->newText == "1" ? true : false;

			// Set show count and show newest setting from top-node
			if($node->counts != "") {
				if($node->counts == "0")
					$this->data['show_count'] = false;
				else if($node->counts == "1")
					$this->data['show_count'] = true;
			}
			if($node->newText != "") {
				if($node->newText == "0")
					$this->data['show_newest'] = false;
				else if($node->newText == "1")
					$this->data['show_newest'] = true;
			}

			// Always pull the top power vertical and get the list of providers from that vertical
			if(isset($top_node->providers)) {
				$this->data['providers_list'] = explode(',',$top_node->providers);
			}

			// Check if specific slider url is set for top level nav, if so, override value set in lang file
			if(isset($top_node->imageSlider)) {
				if(strlen($top_node->imageSlider) > 0) { $this->data['image_slider'] = $top_node->imageSlider; }
			}

			// Check the power-vertical for a custom player ID, else load player id from lang file
			if(isset($top_node->playerID)) {
				if(strlen($top_node->playerID) > 0) {
					$this->config->set_item('bc-player-id',$top_node->playerID);
				} else {
					$this->config->set_item('bc-player-id',lang('bc-player-id'));
				}
			}

			// Check the power-vertical for a custom player Key, else load player id from lang file
			if(isset($top_node->playerKey)) {
				if(strlen($top_node->playerKey) > 0) {
					$this->config->set_item('bc-player-key',$top_node->playerKey);
				} else {
					$this->config->set_item('bc-player-key',lang('bc-player-key'));
				}
			}

			// Check and set playerID and playerKey for 2nd and 3rd level categories if they exist
			if(isset($node->playerID)) {
				if(strlen($node->playerID) > 0) {
					$this->config->set_item('bc-player-id',$node->playerID);
				}
			}
			if(isset($node->playerKey)) {
				if(strlen($node->playerKey) > 0) {
					$this->config->set_item('bc-player-key',$node->playerKey);
				}
			}

			// Take user to generic 404 page of uri is not valid
            if($node == null) {
            	 redirect($this->data['base_url'] . '?msg=' . lang('error-404'), 'location', 302); die();
        	}

			// Grid title left of sorting/filters
			$this->data['grid_title'] = ($node->name);

			// Passing this along to videos model for usage there
			$this->videos->set('nav_node', $node);

			// Override sort by with default for category if sort by doesn't exist in URL
			if(isset($_GET['sort'])) {
				$this->config->set_item('sort',$_GET['sort']);
				$this->data['sort_display'] = $this->nav->get_sort_display();
			} else if (isset($node->defaultSort)) {
				if(strlen($node->defaultSort) > 0) {
					$this->config->set_item('sort',$node->defaultSort);
					$this->data['sort_display'] = $this->nav->get_sort_display();
				}
			}

			// Set some default orders based on sort type
			if($this->config->item('sort') == "name") { $this->config->set_item('order', 'asc'); }
			if($this->config->item('sort') == "date") { $this->config->set_item('order', 'desc'); }

			// Override sort order with default for category only if explicit sort not defined
			if($node->defaultOrder != null && !isset($_GET['sort'])) {
				$this->config->set_item('order',$node->defaultOrder);
			}

			// This will store the tag set that we want to ask the API for
			$query = explode(',', $node->tags);
			array_walk($query, array($this, 'map_tags'));

			$collection = $this->videos->search_by_tags($query);
			$this->data['videos'] = $collection->videos;
			$this->data['total_count'] = $collection->total_count;

			// Load recent videos
			$recent_query = explode(',', $top_node->tags);
			array_walk($recent_query, array($this, 'map_tags'));
			$recent_collection = $this->videos->search_by_tags($recent_query);
			$this->data['recent_videos'] = $recent_collection->videos; 
			$this->data['recent_total_count'] = $recent_collection->total_count;

			// Load popular videos
			$collection = $this->videos->get_popular_videos($query);
			$this->data['popular_videos'] = $collection->videos;

			// Append to the page title
			$this->data['title'] .= lang('title-separator') . $node->name;

			$include_views = array('banner','sidebar-left',$data_view,'sidebar-right');

			// If looking at 2nd or 3rd level of navigation, auto display first video
			if (count($args) > 1) 
			{				
				// Get the specific video's details
				$this->data['video'] = $collection->videos[0];
				
				$this->data['rating'] = null;
				$this->data['related-videos'] = null;
				if($this->data['video'] != null) 
				{
					// Get comments for video
					$this->data['comments'] = $this->comments->get($this->data['video']->id, 0, $this->config->item('comment-size'));
					if($this->data['comments'] != null) $this->data['comments_cnt'] = sizeof($this->data['comments']);
					// Get rating value
					$this->data['rating'] = $this->ratings->get($this->data['video']->id);
					// Get related videos
					$collection = $this->videos->get_related_videos($this->data['video']->id);
					$this->data['related_videos'] = $collection->videos;
					// set scroll pagination for related videos
					$this->data['scroll_links_related'] = $this->nav->get_scroll_bullets(sizeof($this->data['related_videos']), 'related videos');
				}
				$include_views = array('video-details','sidebar-left',$data_view,'sidebar-right');
			}			

		} else {

			// get all videos
			$collection = $this->videos->get_all();
			$this->data['videos'] = $collection->videos;
			$this->data['total_count'] = $collection->total_count;
			$this->data['recent_videos'] = $collection->videos; 

			// Load popular videos
			$collection = $this->videos->get_all_popular();
			$this->data['popular_videos'] = $collection->videos;

		}

		// set scroll pagination for up next, substract one because the current video is not display in "up next"
		$this->data['scroll_links_upnext'] = $this->nav->get_scroll_bullets(sizeof($this->data['videos'])-1, 'up next');

		// set scroll pagination for popular videos
		$this->data['scroll_links_popular'] = $this->nav->get_scroll_bullets(sizeof($this->data['popular_videos']), 'popular videos');

		// set scroll pagination for recent videos
		$this->data['scroll_links_recent'] = $this->nav->get_scroll_bullets(sizeof($this->data['videos']), 'recent videos');

		// build pagination
		$this->pagination->set($this->config->item('page')-1, $this->config->item('sort'), $this->config->item('filter'), '', $this->data['total_count'], $this->data['base_url'] . $this->uri->uri_string());
		$pagination_data = '<div class="bar bc_pagination">';
		$pagination_data .= str_replace('#/','',$this->pagination->create_links());
		$pagination_data .= $this->nav->get_pagination_summary($this->config->item('page'), $this->data['total_count']);
		$pagination_data .= '</div>';
		$this->data['pagination'] = $pagination_data;

		// Use the first video as the featured video (this will change depending on how featured content is handled)
		if(count($args) > 0) {
			$this->data['video'] = isset($this->data['videos'][0]) ? $this->data['videos'][0] : null;

			if($this->data['video'] != null) 
			{
				$this->data['active_video_id'] = $this->data['video']->id;
				// Get comments for video
				$this->data['comments'] = $this->comments->get($this->data['video']->id, 0, $this->config->item('comment-size'));
				if($this->data['comments'] != null) $this->data['comments_cnt'] = sizeof($this->data['comments']);
				// Get rating value
				$this->data['rating'] = $this->ratings->get($this->data['video']->id); 
			}
		}

		// Don't want to include views if we're reusing code
		if (!$this->skip) {

			// Get the breadcrumbs created during the index lookup
			$this->data['breadcrumbs'] = $this->nav->make_breadcrumbs();

			// Set breadcrumb display
			$this->data['breadcrumb_display'] = $this->nav->breadcrumbs_display_text($this->data['breadcrumbs']);

			$this->loadViews($include_views, $this->data);

		}

	}

	// Handle grid ajax refresh
	public function grid () {

		$path = $_GET['path'];
		$tags = $_GET['tags'];
		
		// This will store the tag set that we want to ask the API for
		$query = explode(',', urldecode($tags));
		array_walk($query, array($this, 'map_tags'));
		
		// Grab collection of videos
		$collection = $this->videos->search_by_tags($query);
		
		// Replace the ajax/grid path with the active uri
		foreach ($collection->videos as $video) {
			$video->uri = str_replace('ajax/grid', urldecode($path), $video->uri);
		}
		
		$this->data['videos'] = $collection->videos; 
		$this->data['total_count'] = $collection->total_count;
		
		// build pagination
		$this->pagination->set($this->config->item('page')-1, $this->config->item('sort'), $this->config->item('filter'), '', $this->data['total_count'], $this->data['base_url'] . $this->uri->uri_string());
		$pagination_data = '<div class="bar bc_pagination">';
		$pagination_data .= str_replace('#/','',$this->pagination->create_links());
		$pagination_data .= $this->nav->get_pagination_summary($this->config->item('page'), $this->data['total_count']); 
		$pagination_data .= '</div>';
		$this->data['pagination'] = $pagination_data;

		//$this->loadViews(array('player', 'grid','lineup','featuredproviders'), $this->data);
		$output = $this->load->view('grid-only', $this->data);

	}

	// Handle the case that we have a specific video URL
	public function watch () {

		$data_view = 'grid';

		// Grab an unknown number of arguments
		$args = func_get_args();

		// Grab the video ID from the arguments
		$video_id = array_pop($args);

		// Trash the slug and the "watch" segment
		array_pop($args);

		// Tell the controller to skip the views within the index method
		$this->skip = true;

		// Call the index method because we don't want to duplicate code
		call_user_func_array(array($this, 'index'), $args);

		// Get the specific video's details
		$this->data['video'] = $this->videos->get_by_id($video_id);

		$this->data['active_video_id'] = $video_id;
		$this->data['rating'] = null;
		$this->data['related-videos'] = null;
		if($this->data['video'] != null)
		{
			$this->data['active_video_id'] = $this->data['video']->id;
			// Get comments for video
			$this->data['comments'] = $this->comments->get($this->data['video']->id, 0, $this->config->item('comment-size'));
			if($this->data['comments'] != null) $this->data['comments_cnt'] = sizeof($this->data['comments']);
			// Get rating value
			$this->data['rating'] = $this->ratings->get($this->data['video']->id);
			// Get related videos
			$collection = $this->videos->get_related_videos($this->data['video']->id);
			$this->data['related_videos'] = $collection->videos;
			// set scroll pagination for related videos
			$this->data['scroll_links_related'] = $this->nav->get_scroll_bullets(sizeof($this->data['related_videos']), 'related videos');
		}

		// Append to the page title
		$this->data['title'] .= lang('title-separator') . $this->data['video']->name;

		// Create a search crumb
		$this->nav->make_breadcrumbs((object) array('uri' => 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], 'name' => $this->data['video']->name));

		// Get the breadcrumbs created during the index lookup
		$this->data['breadcrumbs'] = $this->nav->make_breadcrumbs();

		// Set breadcrumb display
		$this->data['breadcrumb_display'] = $this->nav->breadcrumbs_display_text($this->data['breadcrumbs']);

		// If lineup id specificied, override data and grid with lineup view
		if(isset($this->data['lineup_data']))
		{
			$this->data['videos'] = $this->data['lineup_data'][0]->videos; 
			$data_view = 'grid-lineups';
			// in case popular videos is empty, use videos from lineup playlist
			if($this->data['popular_videos'] == null || sizeof($this->data['popular_videos'])) {
				$this->data['popular_videos'] = $this->data['videos'];
			}
		}

		//$this->loadViews(array('player', 'grid','lineup','featuredproviders'), $this->data);
		$this->loadViews(array('video-details','sidebar-left',$data_view,'sidebar-right'), $this->data);

	}

	// Handle fulltext search
	public function search ($video_slug = false, $video_id = false) {


		// Retrieves Featured Providers configurantion from the language specific config file.
		$this->data['featuredproviders'] = lang('featured_providers');

		$this->data['term'] = urldecode($_GET['term']);

		$collection = $this->videos->search_by_text($_GET['term']);
		$this->data['videos'] = $collection->videos; 
		$this->data['total_count'] = $collection->total_count; 
		$this->data['recent_videos'] = $collection->videos; 

		// set scroll pagination for recent videos
		$this->data['scroll_links_recent'] = $this->nav->get_scroll_bullets(sizeof($this->data['videos']), 'recent videos');

		// set scroll pagination for up next, substract one because the current video is not display in "up next"
		$this->data['scroll_links_upnext'] = $this->nav->get_scroll_bullets(sizeof($this->data['videos'])-1, 'up next');

		// build pagination
		$this->pagination->set($this->config->item('page')-1, $this->config->item('sort'), $this->config->item('filter'), $_GET['term'], $this->data['total_count'], $this->data['base_url'] . $this->uri->uri_string());
		$pagination_data = '<div class="bar bc_pagination">';
		$pagination_data .= str_replace('#/','',$this->pagination->create_links());
		$search_data = $pagination_data;
		$pagination_data .= $this->nav->get_pagination_summary($this->config->item('page'), $this->data['total_count']);
		$pagination_data .= '</div>';
		$this->data['pagination'] = $pagination_data;

		$search_data = $search_data . '<p>' . str_replace('{0}', $this->data['total_count'],lang('search-results')) . '</p>';
		$search_data = str_replace('{1}',$this->data['term'],$search_data) . '</div>';
		$this->data['searchsummary'] = $search_data;

		// Append to the page title
		$temp = str_replace('%s', htmlentities($_GET['term']), lang('search-results'));
		$this->data['title'] .= lang('title-separator') . $temp;

		$results_view = 'search-results';
		if($this->data['total_count'] == 0) $results_view = 'search-no-results';

		// If we're watching a search result we want to include the player and do a video lookup
		if ($video_id) {

			$this->data['active_video_id'] = $video_id;
			$this->data['video'] = $this->videos->get_by_id($video_id);

			// Get rating value
			$this->data['rating'] = $this->ratings->get($this->data['video']->id);

			// Create a search crumb
			$this->nav->make_breadcrumbs((object) array('uri' => preg_replace('/search\/[^\?]+/', 'search', 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']), 'name' => $temp));

			// Append to the page title
			$this->data['title'] .= lang('title-separator') . $this->data['video']->name;

			// Create a video crumb
			$this->nav->make_breadcrumbs((object) array('uri' => 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], 'name' => $this->data['video']->name));

			// Get comments for video
			$this->data['comments'] = $this->comments->get($this->data['video']->id, 0, $this->config->item('comment-size'));
			if($this->data['comments'] != null) $this->data['comments_cnt'] = sizeof($this->data['comments']);

			// Get related videos
			$collection = $this->videos->get_related_videos($this->data['video']->id);
			$this->data['related_videos'] = $collection->videos;

			// set scroll pagination for related videos
			$this->data['scroll_links_related'] = $this->nav->get_scroll_bullets(sizeof($this->data['related_videos']), 'related videos');


			$views =  array('video-details', $results_view, 'sidebar-right-search');

		} else {

			// Create a search results crumb
			$this->data['breadcrumbs'] = $this->nav->make_breadcrumbs((object) array('uri' => 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], 'name' => $temp));

			// Set breadcrumb display
			$this->data['breadcrumb_display'] = $this->nav->breadcrumbs_display_text($this->data['breadcrumbs']);

			$views =  array($results_view, 'sidebar-right-search');

		}

		// Load popular videos
		$collection = $this->videos->get_all_popular();
		$this->data['popular_videos'] = $collection->videos;

		// set scroll pagination for popular videos
		$this->data['scroll_links_popular'] = $this->nav->get_scroll_bullets(sizeof($this->data['popular_videos']), 'popular videos');

		// Get the breadcrumbs created during the index lookup
		$this->data['breadcrumbs'] = $this->nav->make_breadcrumbs();

		// Set breadcrumb display
		$this->data['breadcrumb_display'] = $this->nav->breadcrumbs_display_text($this->data['breadcrumbs']);

		$this->loadViews($views, $this->data);

	}

	function map_tags (&$tag) {
		$tag = 'tag:'.trim($tag);
	}


}

/* End of file browse.php */
/* Location: ./application/controllers/browse.php */
