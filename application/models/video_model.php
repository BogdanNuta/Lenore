<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_model extends CI_Model {

	private $nav_node;
	private $params;

	public function __construct()
	{
		parent::__construct();
	}

	public function set($key, $value)
	{
		if(isset($this->$key) || is_null($this->$key))
		{
			$this->$key = $value;
		}
	}

	 /**
	  * Checks for lineup objects in cache, if they don't exist,
	  * they are loaded from BC Media API and stored in cache.
	  * The cached is set to never refresh.
	  *
	  * @param category     the Category name
	  * @param playlistids  the CSV playlist ids for the category.
	  *
	  * @returns  collection of PlayList objects.
	  *
	  */
    public function get_lineups($category, $playlistids){
        // remove blank spaces from the category name
        $category = str_replace(" ", "_", $category);
        // prefix the language code to the lineup chache id
        $lineups = $this->cache->get($this->data['lang'].'_lineups_'.$category);
        // if cached version does not exist load from BC Media API

        if(!$lineups){
            // invoke bc media api
            $lineups = $this->videos->find_by_playlist($playlistids);
            // If expiration time is 0, the item never expires (but
            // memcached server doesn't guarantee this item to be stored
            //all the time, it could be deleted from the cache to make
            //place for other items)
            $this->cache->save($this->data['lang'].'_lineups_'.$category, $lineups,
                    $this->config->item('cache_never_refresh'));
        }
        return $lineups;

    }

	public function get_popular_videos ($tags)
	{
		$constants = $this->config->item('bc-constants');
		$params = array (
			'sort_by' => $constants['popular'] . ':' .
                                     $constants[$this->config->item('order')],
			'page_size' => $this->config->item('page-size-scroll')
		);
		$this->params = $this->create_params($params);
		$videos = $this->search_by_tags($tags);
		return $videos;
	}

	public function get_recent_videos ($tags)
	{
		$constants = $this->config->item('bc-constants');
		$params = array
		(
			'page_size' => $this->config->item('page-size-scroll')
		);
		$this->params = $this->create_params($params);
		$videos = $this->search_by_tags($tags);
		return $videos;
	}

	public function get_preview_videos ($uri, $tags, $lang)
	{

		$constants = $this->config->item('bc-constants');
		$params = array
		(
			'page_size' => $this->config->item('page-size-preview')
		);
		$params = $this->create_params($params);

		$data =  explode(':',implode(',', $tags));
		$videos = $this->bc->search('video', array('any' => implode(',', $tags)), $params);

		$this->make_category_uris($uri, $videos);
		$this->make_display_date($videos);
		$this->make_display_time($videos);

		return $videos;

	}

	public function search_by_tags ($tags)
	{

		$constants = $this->config->item('bc-constants');

		$data =  explode(':',implode(',', $tags));
		$cache_tag = str_replace('/','-',$data[1]);

		if($this->params != null) {
			$params = $this->create_params($this->params);
		} else {
			$params = $this->create_params();
		}

		// store cache key based on tags and the sort order
		$filter_cache_key = '';
		$filter = $this->config->item('filter');
		if(strlen($filter) > 0)
		{
			$filter_cache_key = '-' . url_title($filter);
			$filter = 'source:' . $filter;
		}
		$sort_by = strtolower($params['sort_by']);
		$page_number = strtolower($params['page_number']);

		$search_array = array('any' => implode(',', $tags), 'all' => 'tag:/' . $this->data['lang']);
		if(strlen($filter) > 0) {
			$search_array = array(
				'any' => implode(',', $tags),
				'all' => $filter . ',tag:/' . $this->data['lang']
				);
		}

		$cache_key = $cache_tag . '-' . $sort_by . '-' . $page_number . $filter_cache_key;

		$collection = $this->cache->get($cache_key);
		// if cache doesn't exist make api call
		if(!$collection) {
			$videos = $this->bc->search('video', $search_array, $params);
			$collection = (object) array('videos' => $videos, 'total_count' => $this->bc->total_count);
			$this->cache->save($cache_key, $collection, $this->config->item('cache_refresh'));
		}

		$this->make_uris($collection->videos);
		$this->make_display_date($collection->videos);
		$this->make_display_time($collection->videos);

		return $collection;
	}

	/**
	 * Wraps bmapi find function and builds the URI properti for all the videos objects
	 * returned in the response.
	 * @param type $playlist_ids playlist ids csv (i.e 1232323,12323444,1288999)
	 *
	 * @return type
	 */
	public function find_by_playlist($playlist_ids){ //'page_size' => $this->config->item('page-size-search')
		$playlists = $this->bc->find('playlistsbyids', $this->create_params(array('playlist_ids' => $playlist_ids)));
		// builds the uri for each video in the playlist.
		foreach ($playlists as $playlist) {
                        if($playlist == null) continue;
			$this->make_uris($playlist->videos);
			$this->make_display_date($playlist->videos);
			$this->make_display_time($playlist->videos);
		}
		return $playlists;
	}

	public function get_lineup_videos($playlist_id, $lineupIdCats = false){

		$params = $this->create_params();
		$cache_key = $this->data['lang'] . '-lineup-' . $playlist_id;
        $collection = $this->cache->get($cache_key);
        if(!$collection){
			$collection = $this->bc->find('playlistsbyids', $this->create_params(array('playlist_ids' => $playlist_id)));
            $this->cache->save($cache_key, $collection, $this->config->item('cache_never_refresh'));
        }
		$this->make_uris($collection[0]->videos);
		$this->make_display_date($collection[0]->videos);
		$this->make_display_time($collection[0]->videos);

		$lineupCategoryUri = null;
		if($lineupIdCats != false)
		{
		    if(isset($lineupIdCats[$collection[0]->id]))
		    {
		        $lineupCategoryUri = $lineupIdCats[$collection[0]->id];
		    }
		}
		
		foreach($collection[0]->videos as $video) {
		    if($lineupCategoryUri != null)
			{
    	        $video->uri = str_replace('/watch/','/' . $lineupCategoryUri . 'watch/', $video->uri);
			}
			else 
			{
			    $video->uri = str_replace('/watch/','/' . $this->uri->segment(1) . '/watch/',$video->uri);
			}
		}

		return $collection;
	}

	public function get_related_videos($id)	{

		$collection = $this->cache->get('related-videos-' . $id);
		if(!$collection)
		{
			$params = array (
				'video_id' => $id,
				'page_size' => $this->config->item('page-size-scroll')
			);
			$videos = $this->bc->find('relatedvideos', $this->create_params($params));
			$collection = (object) array('videos' => $videos, 'total_count' => $this->bc->total_count);
			$this->cache->save('related-videos-' . $id, $collection, $this->config->item('cache_refresh'));
		}

		$this->make_uris($collection->videos);
		$this->make_display_date($collection->videos);
		$this->make_display_time($collection->videos);

		return $collection;

	}

	public function get_all () {

		$cache_key = $this->data['lang'] . '-allvideos';
		$collection = $this->cache->get($cache_key);
		if(!$collection)
		{
			$params = $this->create_params();
			foreach($params as $key => $value) {
				if($key == 'sort_by')
				{
					$data = explode(':', $value);
					$params[$key] = $data[0];
					$params['sort_order'] = $data[1];
				}
			}
			$videos = $this->bc->find('allvideos', $params);
			$collection = (object) array('videos' => $videos, 'total_count' => $this->bc->total_count);
			$this->cache->save($cache_key, $collection, $this->config->item('cache_refresh'));
		}

		$this->make_uris($collection->videos);
		$this->make_display_date($collection->videos);
		$this->make_display_time($collection->videos);

		return $collection;

	}

	public function get_all_popular () {

		$constants = $this->config->item('bc-constants');
		$cache_key = $this->data['lang'] . '-allvideos-popular';
		$collection = $this->cache->get($cache_key);
		if(!$collection)
		{
			$params = array (
				'sort_by' => $constants['popular'],
				'page_size' => $this->config->item('page-size-scroll'),
				'sort_order' => $this->config->item('order')
			);
			$params = $this->create_params($params);

			$videos = $this->bc->find('allvideos', $params);
			$collection = (object) array('videos' => $videos, 'total_count' => $this->bc->total_count);
			$this->cache->save($cache_key, $collection, $this->config->item('cache_refresh'));
		}

		$this->make_uris($collection->videos);
		$this->make_display_date($collection->videos);
		$this->make_display_time($collection->videos);

		return $collection;

	}

	public function get_by_id ($video_id) {

		$video = $this->cache->get('video-' . $video_id);
		if(!$video) {
			$video = $this->bc->find('videobyid', $this->create_params(array('video_id' => $video_id)));
			$video = $this->set_uri($video);
			$video->displayDate = $this->set_display_date($video);
			$video->displayTime = $this->set_display_time($video);
			$this->cache->save('video-' . $video_id, $video, $this->config->item('cache_refresh'));
		}
        if (!$video) {
            redirect($this->data['base_url'] . '?msg=' . lang('error-404'), 'location', 302); die();
        }
		return $video;

	}

	public function search_by_text ($text) {

		$query = array('tag:'.$text, 'search_text:'.$text);
		$params = $this->create_params(array(
			'page_size' => $this->config->item('page-size-search'
		)));
		$cache_key = $this->data['lang'] . '-search-' . $text . '-' . $this->config->item('page');
		$collection = $this->cache->get($cache_key);
		if(!$collection)
		{
			$videos = $this->bc->search('video', array('any' => implode(',', $query), 'all' => 'tag:/' . $this->data['lang']), $params);
			$collection = (object) array('videos' => $videos, 'total_count' => $this->bc->total_count);
			$this->cache->save($cache_key, $collection, $this->config->item('cache_refresh'));
		}

		$this->make_uris($collection->videos);
		$this->make_display_date($collection->videos);
		$this->make_display_time($collection->videos);

		return $collection;

	}

	private function create_params ($array = false) {
		$constants = $this->config->item('bc-constants');
		$params = array('sort_by' => $constants[$this->config->item('sort')] . ':' . $constants[$this->config->item('order')], 'page_size' =>  $this->config->item('page-size'), 'page_number' =>  ($this->config->item('page') - 1), 'video_fields' => $this->config->item('bc-fields'));
		if ($array) {
			foreach ($array as $key => $value) {
				$params[$key] = $value;
			}
		}
		return $params;
	}

	// used to create proper uri value for rich nav video previews
	private function make_category_uris ($uri, &$videos) {

		foreach ($videos as $video)
		{
			$video->uri = base_url() . $uri . 'watch/' . url_title($video->name) . '/' . $video->id . '/';
		}
	}

	private function make_uris (&$videos) {

		foreach ($videos as $video)
		{
			$video = $this->set_uri($video);
		}
	}

	private function make_display_date (&$videos) {

		foreach ($videos as $video)
		{
			$video->displayDate = $this->set_display_date($video);
		}
	}

	private function make_display_time (&$videos) {

		foreach ($videos as $video)
		{
			$video->displayTime = $this->set_display_time($video);
		}
	}

	private function set_uri (&$video)
	{
		$base_path = trim(base_url(), '/');
		if($this->nav_node) $base_path = $this->nav_node->uri;

		$video->uri = (($this->uri->segment(1) == 'search') ? trim(base_url(), '/').'/search/watch/' : trim(current_url(), '/').'/watch/').url_title($video->name).'/'.$video->id.(isset($_GET['term']) ? '?term='.$_GET['term'] : '?sort=' . $this->config->item('sort') . (strlen($this->config->item('filter')) > 0 ? '&filter=' . $this->config->item('filter') : '') . '&page=' . $this->config->item('page'));

		if($this->uri->segment(1) == 'search') {
			$video->uri = $base_path . '/search/watch/' . url_title($video->name).'/'.$video->id.(isset($_GET['term']) ? '?term=' . $_GET['term'] . '&sort=' . $this->config->item('sort') . (strlen($this->config->item('filter')) > 0 ? '&filter=' . $this->config->item('filter') : '') . '&page=' . $this->config->item('page') : '?sort=' . $this->config->item('sort') . (strlen($this->config->item('filter')) > 0 ? '&filter=' . $this->config->item('filter') : '') . '&page=' . $this->config->item('page'));
		} else if(strrpos(current_url(),'/watch') != null) {
			$video->uri = $base_path . '/watch/' . url_title($video->name).'/'.$video->id.(isset($_GET['term']) ? '?term=' . $_GET['term'] . '&sort=' . $this->config->item('sort') . (strlen($this->config->item('filter')) > 0 ? '&filter=' . $this->config->item('filter') : '') . '&page=' . $this->config->item('page') : '?sort=' . $this->config->item('sort') . (strlen($this->config->item('filter')) > 0 ? '&filter=' . $this->config->item('filter') : '') . '&page=' . $this->config->item('page'));
		}
		// correct double slash issue
		$video->uri = str_replace('//watch','/watch',$video->uri);
		return $video;
	}

	private function set_display_date (&$video)
	{
		return strftime(lang('date_display_format'),($video->lastModifiedDate/1000));
	}

	private function set_display_time (&$video)
	{
		$input = $video->length;
		$uSec = $input % 1000;
		$input = floor($input / 1000);
		$seconds = $input % 60;
		$input = floor($input / 60);
		$minutes = $input % 60;
		$input = floor($input / 60);
		return str_pad($minutes,2, '0', STR_PAD_LEFT) . ':' . str_pad($seconds,2, '0', STR_PAD_LEFT);
	}

}

/* End of file video_model.php */
/* Location: ./application/models/video_model.php */
