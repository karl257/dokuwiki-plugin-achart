<?php
/**
 * DokuWiki ApexCharts Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Karl Nickel <kazozaagir@gmail.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_achart extends DokuWiki_Action_Plugin {

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler $controller) {
       $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'handle_tpl_metaheader_output');
    }

    /**
     * [Custom event handler which performs action]
     *
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */
    public function handle_tpl_metaheader_output(Doku_Event &$event, $param) {
		
        $event->data["script"][] = array (
            "type" => "text/javascript",
            "src" => $this->get_asset($this->getConf('url_yaml')),
            "_data" => "",
        );
	
	$jsfiles = preg_split("/\|/", $this->getConf('acharts_js'));
	foreach($jsfiles as $jsfile) {
		$event->data["script"][] = array (
			"type" => "text/javascript",
			"src" => $this->get_asset($jsfile),
			"_data" => ""
		);
	}
	
    }

    private function get_asset($resource) {
        if(!preg_match('#^(?:(?:https?:)?/)?/#', $resource)) {
            $info = $this->getInfo();
            $resource = DOKU_BASE."lib/plugins/".$info['base']."/assets/".$resource;
        }
        return $resource;
    }

}
