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

	   $controller->register_hook('DOKUWIKI_STARTED', 'AFTER',  $this, '_chartlang');   
    }

    /**
     * [Custom event handler which performs action]
     *
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */
	
	function _chartlang(&$event, $param) {
		global $JSINFO;global $conf;	
		
		$filename= dirname(__FILE__) . '/assets/locales/'.$conf['lang'].'.json';
		if( file_exists( $filename ) == true ){$localization = $conf['lang'];} else {$localization = "en";}
		$JSINFO['chartlang']  = $localization;
		$JSINFO['chartlocale']= file_get_contents(dirname(__FILE__) . '/assets/locales/'.$localization.'.json');
	}

}
