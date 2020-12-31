<?php
/**
 * DokuWiki ApexCharts Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Karl Nickel <kazozaagir@gmail.com>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_achart extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'substition';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'block';
    }
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return 200;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('<achart.+?</achart>',$mode,'plugin_achart');
    }

    /**
     * Handle matches of the achart syntax
     *
     * @param string $match The match of the syntax
     * @param int    $state The state of the handler
     * @param int    $pos The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler $handler){
        $match = substr(trim($match), 7, -10);
        list($opts, $adata) = explode('>', $match, 2);
        preg_match_all('/(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?/', $opts, $matches, PREG_SET_ORDER);
        $opts = array(
            'width' => $this->getConf('width'),
            'height' => $this->getConf('height'),
            'align' => $this->getConf('align'),
			'url' => null,
        );
        foreach($matches as $m) {
            $opts[strtolower($m[1])] = $m[2];
        }

        $adata = preg_replace_callback(
            '#//.*?$|/\*.*?\*/|\'(?:\\.|[^\\\'])*\'|"(?:\\.|[^\\"])*"#ms',
            function($matches){
                $m = $matches[0];
                return substr($m, 0, 1)==='/' ? ' ' : $m;
            }, $adata
        ); // remove comments (respecting quoted strings)
        $adata = explode("\n", $adata);
        $adata = implode("", array_map('trim', $adata));
        $chartid = uniqid('__achart_');
        //$adata = base64_encode($adata);

        return array($chartid, $adata, $opts);
    }

    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode != 'xhtml') return false;

        list($chartid, $adata, $opts) = $data;
        $resize = '';
        $align = '';
		$file = '';
        foreach($opts as $n => $v) {
            if(in_array($n, array('width','height')) && $v) {
                $resize .= $n.':'.hsc($v).';';
            } elseif($n=='align' && in_array($v, array('left','right','center'))) {
                $align = 'media'.$v;
            } elseif ($n=='url' && $v) {
				$file = $v;
			}
        }
		
		if (!empty($file)) {
			// Check for csv files
			if($file !== '' && !preg_match('/^https?:\/\//i', $file)) {
				$file = str_replace(array(':'),'/',cleanID($file));
			}
			// Load csv files
			if(preg_match('/^https?:\/\//i', $file)) {
				$http = new DokuHTTPClient();
				$content = $http->get($file);
				try {
					if($content === false) 
						throw new \Exception('Chart cannot be displayed ! Failed to fetch remote CSV data');
				} catch (\Exception $e) {
					msg(hsc($e->getMessage()), -1);
					return false;
				}
			} else {
				$file = mediaFN($file);
				try {
					if(auth_quickaclcheck(getNS($file) . ':*') < AUTH_READ) 
						throw new \Exception('Chart cannot be displayed ! Access denied to CSV data');
					if(!file_exists($file))
						throw new \Exception('Chart cannot be displayed ! Requested local CSV file does not exist');
				} catch (\Exception $e) {
					msg(hsc($e->getMessage()), -1);
					return false;
				}
			}
			// If not valid UTF-8 is given we assume ISO-8859-1
			if(!utf8_check($file)) $file = utf8_encode($file);
		/*
		 * Converts CSV to JSON
		 */
		//Read the csv and return as array
		error_reporting(0);
		$data = array_map('str_getcsv', file($file));
		//Get the first raw as the key
		$keys = array_shift($data);  
		//Add label to each value
		$newArray = array_map(function($values) use ($keys){
			return array_combine($keys, $values);
		}, $data);

		// Print it out as JSON
		$csvData[]= array_combine(array('data'),array($newArray));
		//Remove on given data in syntax{.....}
		$newAdata=substr($adata, 1, strlen($adata) - 2);
		$jsonData = array('series'=> $csvData,'config'=>$newAdata);
		#unset($jsondata['config']);	
		$newJson=json_encode($jsonData,JSON_NUMERIC_CHECK);		
		$newJson = preg_replace(array('/("series")/i') , "series",$newJson);
		$newJson = preg_replace(array('/("data")/i') , "data",$newJson);
		$newJson = preg_replace(array('/("config":")/i') , "",$newJson);
		$newJson = preg_replace(array('/(}")/i') , "}",$newJson);
		//Remove escaping slashes
		$newJson = str_replace('\\','',$newJson);
	}
		#print_r ($newJson);
		if(!empty($file)) {$chartData = $newJson;} else {$chartData = $adata;};
        if($align) $resize = ' style="'.$resize.'padding: 2px;border: 1px solid #eee;margin:3px 2px;"';
        if($ClassAttr) $ClassAttr = ' class="'.$ClassAttr.'"';

        $renderer->doc .= '<div id="'.$chartid.'"'.$ClassAttr.$resize.' data-achart="'.base64_encode($chartData).'"></div>'."\n";
    
        return true;
    }
}
