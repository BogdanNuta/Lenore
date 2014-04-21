<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controller used to support the Navigation Admin Console.
 * This is not REST compliant, it just provides an easy way
 * to read and write the hierachy.xml file on disk using a
 * Web Service. TODO: It maybe a good idea change the 
 * resource/controller name to Hierarchy or Category.
 * 
 * 
 * @author eacuna
 */
class Admin extends BC_Controller {
    /** Relative path to the language specific hirarchy resources. */
    //const FR_HIERARCHY_XML = 'application/language/fr/hierarchy.xml';
    //const EN_HIERARCHY_XML = 'application/language/en/hierarchy.xml';

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('file');
    }

    /**
     * Opens the flex admin console
     * 
     * 
     */
    public function index() {
        $this->load->view('admin');
    }
    
    /**
     * Validates CSV list or playlist ids entered in the 
     * admin console, 
     * 
     * @return string cvs list of invalid ids or blank if all 
     *         the ids are valid
     */
    public function validatelineupids(){
        if(isset($_GET['ids'])) $ids = $_GET['ids'];
        $response = 'All the Playlist IDs are valid';
        $idArray = explode(',', $ids);
        $invalid = array();
        $playlists = $this->videos->find_by_playlist($ids);
        
        for ($i = 0; $i < count($playlists); $i++){
            if ($playlists[$i] == null) $invalid[$i]= $idArray[$i];
        }
        if(count($invalid) > 0)
            $response = 'The following IDs are invalid: '.implode (',', $invalid);
        
        $this->output->set_output($response);
    }

    /**
     * Returns hierarchy.xml file that is stored on disk.
     * and sets content type to the proper format.
     * 
     */
    public function get() {
        $string = read_file($this->_buildPathToFile() );
        //log_message('DEBUG','lang: '.$this->data['lang']);       
        //log_message('DEBUG', 'message: '.$string);
        $this->output->set_content_type('application/xml');
        $this->output->set_output($string);
    }
    
    /**
     * Receives the name hierarchy from the admin console, 
     * creates the apropiate friendly url , and opens sympatico
     * category page.
     */
    public function proxy(){
        if(isset($_GET['categories'])) $categories = $_GET['categories'];
        $category = explode("|||", $categories);
        $friendlyUrl = "";
        foreach ($category as $token) {
             //log_message('DEBUG',"token: ".$token);
             $friendlyUrl .= url_title($token)."/";
        }
        $this->output->set_header('Location: '.  base_url() .$friendlyUrl);
       
    }
    
    /**
     * Builds the the path to the hierarchy.xml files stored 
     * on disk.
     * 
     * @return  path to the language specific hierarchy.xml
     */
    private function _buildPathToFile() {
        return 'application/language/'.$this->data['lang'].'/hierarchy.xml';
    }

    /**
     * Overwrites language specific hierarchy.xml and 
     * refresh the copy of language hierachy.xml that is 
     * mantained in cache. If the element removed/modified
     * on the UI is a category element, this method remove
     * the copy of the lineup for the specific language/category
     * from cache.
     * 
     */
    public function post() {       
        // retrieves the POST parameter.
        if(isset($_POST['xml'])) $data = $_POST['xml'];
        if(isset($_POST['category'])) $category = $_POST['category'];

        if (!write_file($this->_buildPathToFile(), $data)) {
            //echo 'Unable to write the file';
            show_404('page' , 'hirierchy.xml might not have write permission.');
        } else {
           // echo 'File written!';
            //rename(_buildPathToFile(), _buildPathToFile().'.bak');
            //cleans up the language specific hierarchy.xml from cache.
            $this->cache->delete($this->data['lang'].'_navigation');
            //cleans up language/category linups from cache,if the 
            //node removed/modified is a category.
             if(isset($category)) {
                  $this->cache->delete($this->data['lang'].'_lineups_'.url_title($category));
                // 
             }
        }
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
