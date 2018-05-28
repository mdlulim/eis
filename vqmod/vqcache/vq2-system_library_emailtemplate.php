<?php
/**
 * Email Template
 *
 * @author Opencart-Templates
 *
 */
class EmailTemplate {
	private $version = '2.9.3.9';

	public $data = array();
	public $language_data = array();

	private $html = null;
	private $html_content = null;
	private $text = null;

	private $built = false;

	public $shortcodes = null;
	private $default_shortcodes = null;

	private $emailtemplate_log_enc = '';

	/**
	 * Get variable
	 *
	 * @param string $key
	 * @return Ambigous <string, multitype:>
	 */
    public function get($key) {
		return isset($this->data[$key]) ? $this->data[$key] : '';
    }

	/**
	 * Set variable
	 *
	 * @param string $key
	 * @param multitype: $value
	 * @param bool $overwrite
	 */
    public function set($key, $value = '', $overwrite = true) {
		if ($overwrite || (!$overwrite && !isset($this->data[$key]))) {
			$this->data[$key] = $value;
		}
    }

    /**
     * Appends template data
     *
     * [code]
     * $template->addData($my_data_array, 'prefix'); // array(prefix)
     * $template->addData('my_value', $my_value); // string=key,value
     *
     * @return object
     */
    public function addData($param1, $param2 = '') {
    	if (is_array($param1)) {
    		// $param2 acts as prefix
    		if ($param2) {
    			$param2 = rtrim($param2, "_") . "_";
    			foreach ($param1 as $key => $value) {
    				$param1[$param2.$key] = $value;
    				unset($param1[$key]);
    			}
    		}
    		$this->data = array_merge($this->data, $param1);
    	} elseif (is_string($param1) && $param2 != "") {
    		$this->data[$param1] = $param2;
    	}

    	return $this;
    }

    /**
     * Build Template - call after load() but before fetch()
     *
     * @return boolean|Email_Template
     */
    public function build() {
		if (empty($this->data['emailtemplate']) || empty($this->data['config'])) {
			trigger_error('Missing emailtemplate');
			exit;
		}

        // Shadow
        foreach(array('top','bottom','left','right') as $var) {
        	$cells = "";

        	if (!empty($this->data['config']['shadow_'.$var]) && !empty($this->data['config']['shadow_'.$var]['start']) && $this->data['config']['shadow_'.$var]['end'] &&  $this->data['config']['shadow_'.$var]['length'] > 0) {
        		$gradient = $this->_generateGradientArray($this->data['config']['shadow_'.$var]['start'], $this->data['config']['shadow_'.$var]['end'], $this->data['config']['shadow_'.$var]['length']);

        		foreach($gradient as $hex => $width) {
        			switch($var) {
        				case 'top':
        				case 'bottom':
        					$cells .= "<tr class='emailShadow'><td bgcolor='#{$hex}' style='background:#{$hex}; height:1px; font-size:1px; line-height:0; mso-margin-top-alt:1px' height='1'> </td></tr>\n";
        					break;
        				default:
        					$cells .= "<td class='emailShadow' bgcolor='#{$hex}' style='background:#{$hex}; width:{$width}px !important; font-size:1px; line-height:0; mso-margin-top-alt:1px' width='{$width}'> </td>\n";
        					break;
        			}

        			$this->data['config']['shadow_'.$var]['bg'] = $cells;
        		}
        	}
        }

        // Logs
        if (!empty($this->data['emailtemplate_log_id'])) {
       		if (!$this->emailtemplate_log_enc) {
       			$this->emailtemplate_log_enc = substr(md5(uniqid(rand(), true)), 0, 20);
       		}

	        if ($this->data['config']['log_read']) {
	       		$this->data['emailtemplate']['tracking_img'] = $this->data['store_url'] . 'index.php?route=extension/mail/template/record&id='. $this->data['emailtemplate_log_id'] . '&enc=' . $this->emailtemplate_log_enc;
	        }

	        if ($this->data['emailtemplate']['view_browser']) {
	        	$url = $this->data['store_url'] . 'index.php?route=' . rawurlencode('extension/mail/template/view') . '&id=' . $this->data['emailtemplate_log_id'] . '&enc=' . $this->emailtemplate_log_enc;

	        	$this->data['view_browser'] = str_replace('{$url}', $url, $this->data['config']['view_browser_text']);
	        }
        }

        // Shortcodes
        $this->shortcodes = $this->getShortcodes();

        foreach($this->data['emailtemplate'] as $key => $val) {
        	if (is_string($val) && strpos($val, '{$') !== false) {
        		$this->data['emailtemplate'][$key] = str_replace($this->shortcodes['find'], $this->shortcodes['replace'], $val);
        	}
        }

        foreach($this->data['config'] as $key => $val) {
        	if (is_string($val) && strpos($val, '{$') !== false) {
        		$this->data['config'][$key] = str_replace($this->shortcodes['find'], $this->shortcodes['replace'], $val);
        	}
        }

        foreach($this->data as $key => $val) {
        	if (is_string($val) && strpos($val, '{$') !== false) {
        		$this->data[$key] = str_replace($this->shortcodes['find'], $this->shortcodes['replace'], $val);
        	}
        }

        $this->built = true;

        return $this;
    }

    /**
     * Fetch HTML Email
     * @param string $filename
	 * @param string $content - if $filename is null then the content will be used as the body
     */
    public function fetch($filename = null, $content = null) {
    	if (!isset($this->data['emailtemplate'])) return false;

    	if (!$this->built) {
    		$this->build();
    	}

    	$this->html_content = '';

    	if ($content) {
    		$this->html_content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
    	} elseif ($filename) {
    		$this->html_content = $this->render($filename);
    	} elseif ($this->data['emailtemplate']['template']) {
    		$this->html_content = $this->render($this->data['emailtemplate']['template']);
    	}

    	if (!$this->html_content) {
    		$content_count = 3;

    		for($i=1; $i <= $content_count; $i++) {
    			if (!empty($this->data['emailtemplate']['content'.$i])) {
    				$this->html_content .= $this->data['emailtemplate']['content'.$i];
    			}
    		}
    	}

		$this->html = '';

		if ($this->shortcodes) {
			$this->html_content = str_replace($this->shortcodes['find'], $this->shortcodes['replace'], $this->html_content);
		}

		if (!empty($this->data['wrapper_tpl'])){
			$wrapper_file = $this->data['wrapper_tpl'];
		} else {
			$wrapper_file = '_main.tpl';
		}

   		if ($this->html_content && file_exists(DIR_SYSTEM. 'library/emailtemplate/email_template.php.css')) {
   			if (empty($this->css)) {
    			ob_start();

    			extract($this->data);

    			include(\VQMod::modCheck(DIR_SYSTEM. 'library/emailtemplate/email_template.php.css'));

    			$this->css = ob_get_contents();

    			if (ob_get_length()) {
    				ob_end_clean();
    			}
    		}

    		if ($this->css) {
    			require_once(\VQMod::modCheck(DIR_SYSTEM . 'library/shared/CssToInlineStyles/vendor/autoload.php'));

    			$cssToInlineStyles = new TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();

    			$html_wrapper = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><meta http-equiv="content-type" content="text/html; charset=utf-8" /><body id="emailTemplate">';
    			$html_wrapper .= $this->html_content;
    			$html_wrapper .= '</body></html>';

   				$this->html_content = $cssToInlineStyles->convert($html_wrapper, $this->css);

			    preg_match("/<body[^>]*>(.*?)<\/body>/is", $this->html_content, $matches);

			    $this->html_content = $matches[1];
    		}
    	}

	    if ($wrapper_file) {
		    $wrapper = $this->render($wrapper_file);

		    $this->html = str_ireplace('{CONTENT}', $this->html_content, $wrapper);
	    } else {
		    $this->html = $this->html_content;
	    }

    	$this->html = wordwrap($this->html, 520, "\n");

    	return $this->html;
    }

    /**
     * Apply email template settings to Mail object
     *
     * @param object - Mail
     * @return object
     */
    public function hook(Mail &$mail) {
    	if (!isset($this->data['emailtemplate'])) return $mail;

    	if (!$this->built) {
    		$this->build();
    	}

    	if (is_null($this->html)) {
    		$this->html = $this->fetch();
    	}

    	if ($this->html) {
    		if ($this->data['emailtemplate']['mail_html']){
    			$mail->setHtml($this->html);
    		}

    		if ($this->data['emailtemplate']['mail_plain_text']) {
    			$mail->setText($this->getPlainText());
    		}
    	}

    	if (!isset($this->data['preheader_preview'])) {
    		if (!empty($this->data['emailtemplate']['preview'])) {
    			$this->data['preheader_preview'] = $this->data['emailtemplate']['preview'];
    		} else {
    			$this->data['preheader_preview'] = '';
    		}
    	}

    	if (!empty($this->data['emailtemplate']['subject'])) {
    		$mail->setSubject($this->data['emailtemplate']['subject']);
    	}

    	if ($this->data['emailtemplate']['mail_to']) {
    		$mail->setTo($this->data['emailtemplate']['mail_to']);
    	}

    	if ($this->data['emailtemplate']['mail_bcc']) {
    		$mail->setBcc($this->data['emailtemplate']['mail_bcc']);
    	}

    	if ($this->data['emailtemplate']['mail_cc']) {
    		$mail->setCc($this->data['emailtemplate']['mail_cc']);
    	}

    	if ($this->data['emailtemplate']['mail_from']) {
    		$mail->setFrom($this->data['emailtemplate']['mail_from']);
    	}

    	if ($this->data['emailtemplate']['mail_sender']) {
    		$mail->setSender($this->data['emailtemplate']['mail_sender']);
    	}

    	if ($this->data['emailtemplate']['mail_replyto'] && $this->data['emailtemplate']['mail_replyto'] != $this->data['emailtemplate']['mail_to']) {
    		$mail->setReplyTo($this->data['emailtemplate']['mail_replyto'], $this->data['emailtemplate']['mail_replyto_name']);
    	}

    	if ($this->data['emailtemplate']['mail_attachment']) {
    		$attachments = explode(',', $this->data['emailtemplate']['mail_attachment']);
    		$dir = substr(DIR_SYSTEM, 0, -7); // remove 'system/'

    		foreach($attachments as $attachment){
    			$mail->addAttachment($dir . trim($attachment));
    		}
    	}

	    // Mail queue?
	    if (!empty($this->data['emailtemplate_log_id']) && $this->data['emailtemplate']['mail_queue']) {
		    $mail->setMailQueue(true);

		    if (!is_dir(DIR_CACHE . '/mail_queue/')) {
			    mkdir(DIR_CACHE . '/mail_queue/');
		    }
		    file_put_contents(DIR_CACHE . '/mail_queue/' . $this->data['emailtemplate_log_id'], $this->html);
	    } else {
		    $mail->setMailQueue(false);
	    }

	    $this->data['mail'] = $mail->getMailProperties();

    	return $mail;
    }



	/**
	 * Get Plain Text - strip html
	 */
	public function getPlainText() {
		if ($this->html === null) {
			$this->fetch();
		}

		if ($this->html_content && $this->text === null) {
			$html2text = new EmailTemplateHtml2Text();
			$this->text = $html2text::convert($this->html_content);
		}

		return $this->text;
	}

	/**
	 * Get HTML email template
	 */
	public function getHtml() {
		if ($this->html === null) {
			$this->fetch();
		}

		return $this->html;
	}

	/**
	 * Get HTML inner content
	 */
	public function getHtmlContent() {
		if ($this->html_content === null) {
			$this->fetch();
		}

		return $this->html_content;
	}

	public function setDefaultShortcodes($default_shortcodes) {
		$this->default_shortcodes = $default_shortcodes;
	}

	public function getLogCode() {
		return $this->emailtemplate_log_enc;
	}

	public function getShortcodes() {
		$shortcodes = array('find' => array(), 'replace' => array());

		foreach($this->data as $key => $var) {
			if (is_array($var)) {
				foreach($var as $key2 => $var2) {
					if((is_string($var2) || is_int($var2)) && !isset($shortcodes['find'][$key . '_' . $key2])) {
						$shortcodes['find'][$key . '_' . $key2] = '{$'.$key.'.'.$key2.'}';
						$shortcodes['replace'][] = $var2;
					}
				}
			} elseif((is_string($var) || is_int($var)) && !isset($shortcodes['find'][$key])) {
				$shortcodes['find'][$key] = '{$'.$key.'}';
				$shortcodes['replace'][] = $var;
			}
		}

		return $shortcodes;
	}

	private function render($file)
	{
		if (defined('DIR_CATALOG')) {
			if (file_exists(DIR_TEMPLATE . 'extension/mail/' . $file)) {
				$path = DIR_TEMPLATE . 'extension/mail/';
			} elseif (isset($this->data['config']['theme']) && file_exists(DIR_CATALOG . 'view/theme/' . $this->data['config']['theme'] . '/template/extension/mail/' . $file)) {
				$path = DIR_CATALOG . 'view/theme/' . $this->data['config']['theme'] . '/template/extension/mail/';
			} else {
				$path = DIR_CATALOG . 'view/theme/default/template/extension/mail/';
			}
		} else {
			if (isset($this->data['config']['theme']) && file_exists(DIR_TEMPLATE . $this->data['config']['theme'] . '/template/extension/mail/' . $file)) {
				$path = DIR_TEMPLATE . $this->data['config']['theme'] . '/template/extension/mail/';
			} else {
				$path = DIR_TEMPLATE . 'default/template/extension/mail/';
			}
		}

		if (file_exists($path . $file)) {
			$template_file = $path . $file;
		} elseif(file_exists(DIR_TEMPLATE . $file)) {
			$template_file = DIR_TEMPLATE . $file;
		} else {
			$template_file = false;
		}

		if ($template_file) {
			extract($this->data);

			ob_start();

			include(\VQMod::modCheck(modification($template_file), $template_file));

			$content = ob_get_contents();

			if (ob_get_length()) ob_end_clean();

			return $content;
		} else {
			trigger_error('Missing file:' . $path . $file);
			return false;
		}
	}

	/**
	 * Generate array of hex values for shadow
	 * @param $from - HEX colour from
	 * @param $until - HEX colour from
	 * @param $length - distance of shadow
	 * @return Array(hex=>width)
	 */
	private function _generateGradientArray($from, $until, $length) {
		$from = ltrim($from,'#');
		$until = ltrim($until,'#');
		$from = array(hexdec(substr($from,0,2)),hexdec(substr($from,2,2)),hexdec(substr($from,4,2)));
		$until = array(hexdec(substr($until,0,2)),hexdec(substr($until,2,2)),hexdec(substr($until,4,2)));

		if ($length > 1) {
			$red=($until[0]-$from[0])/($length-1);
			$green=($until[1]-$from[1])/($length-1);
			$blue=($until[2]-$from[2])/($length-1);
			$return = array();

			for($i=0;$i<$length;$i++) {
				$newred=dechex($from[0]+round($i*$red));
				if (strlen($newred)<2) $newred="0".$newred;

				$newgreen=dechex($from[1]+round($i*$green));
				if (strlen($newgreen)<2) $newgreen="0".$newgreen;

				$newblue=dechex($from[2]+round($i*$blue));
				if (strlen($newblue)<2) $newblue="0".$newblue;

				$hex = $newred.$newgreen.$newblue;
				if (isset($return[$hex])) {
					$return[$hex] ++;
				} else {
					$return[$hex] = 1;
				}
			}
			return $return;
		} else {
			$red=($until[0]-$from[0]);
			$green=($until[1]-$from[1]);
			$blue=($until[2]-$from[2]);

			$newred=dechex($from[0]+round($red));
			if (strlen($newred)<2) $newred="0".$newred;

			$newgreen=dechex($from[1]+round($green));
			if (strlen($newgreen)<2) $newgreen="0".$newgreen;

			$newblue=dechex($from[2]+round($blue));
			if (strlen($newblue)<2) $newblue="0".$newblue;

			return array($newred.$newgreen.$newblue => $length);
		}

	}
}

/******************************************************************************
 * Copyright (c) 2010 Jevon Wright and others.
* All rights reserved. This program and the accompanying materials
* are made available under the terms of the Eclipse Public License v1.0
* which accompanies this distribution, and is available at
* http://www.eclipse.org/legal/epl-v10.html
*
* or
*
* LGPL which is available at http://www.gnu.org/licenses/lgpl.html
*
*
* Contributors:
*    Jevon Wright - initial API and implementation
****************************************************************************/
class EmailTemplateHtml2Text {

	/**
	 * Tries to convert the given HTML into a plain text format - best suited for
	 * e-mail display, etc.
	 *
	 * <p>In particular, it tries to maintain the following features:
	 * <ul>
	 *   <li>Links are maintained, with the 'href' copied over
	 *   <li>Information in the &lt;head&gt; is lost
	 * </ul>
	 *
	 * @param string html the input HTML
	 * @return string the HTML converted, as best as possible, to text
	 * @throws Html2TextException if the HTML could not be loaded as a {@link DOMDocument}
	 */
	static function convert($html) {
		// replace &nbsp; with spaces
		$html = str_replace("&nbsp;", " ", $html);
		$html = str_replace("\xc2\xa0", " ", $html);

		$html = static::fixNewlines($html);

		$doc = new \DOMDocument();
		$internalErrors = libxml_use_internal_errors(true);
		if (!$doc->loadHTML($html)) {
			return false;
		}
		libxml_use_internal_errors($internalErrors);

		$output = static::iterateOverNode($doc);

		// remove leading and trailing spaces on each line
		$output = preg_replace("/[ \t]*\n[ \t]*/im", "\n", $output);
		$output = preg_replace("/ *\t */im", "\t", $output);

		// remove unnecessary empty lines
		$output = preg_replace("/\n\n\n*/im", "\n\n", $output);

		// remove leading and trailing whitespace
		$output = trim($output);

		return $output;
	}

	/**
	 * Unify newlines; in particular, \r\n becomes \n, and
	 * then \r becomes \n. This means that all newlines (Unix, Windows, Mac)
	 * all become \ns.
	 *
	 * @param string text text with any number of \r, \r\n and \n combinations
	 * @return string the fixed text
	 */
	static function fixNewlines($text) {
		// replace \r\n to \n
		$text = str_replace("\r\n", "\n", $text);
		// remove \rs
		$text = str_replace("\r", "\n", $text);

		return $text;
	}

	static function nextChildName($node) {
		// get the next child
		$nextNode = $node->nextSibling;
		while ($nextNode != null) {
			if ($nextNode instanceof \DOMElement) {
				break;
			}
			$nextNode = $nextNode->nextSibling;
		}
		$nextName = null;
		if ($nextNode instanceof \DOMElement && $nextNode != null) {
			$nextName = strtolower($nextNode->nodeName);
		}

		return $nextName;
	}

	static function prevChildName($node) {
		// get the previous child
		$nextNode = $node->previousSibling;
		while ($nextNode != null) {
			if ($nextNode instanceof \DOMElement) {
				break;
			}
			$nextNode = $nextNode->previousSibling;
		}
		$nextName = null;
		if ($nextNode instanceof \DOMElement && $nextNode != null) {
			$nextName = strtolower($nextNode->nodeName);
		}

		return $nextName;
	}

	static function iterateOverNode($node) {
		if ($node instanceof \DOMText) {
			// Replace whitespace characters with a space (equivilant to \s)
			return preg_replace("/[\\t\\n\\f\\r ]+/im", " ", $node->wholeText);
		}
		if ($node instanceof \DOMDocumentType) {
			// ignore
			return "";
		}

		$nextName = static::nextChildName($node);
		$prevName = static::prevChildName($node);

		$name = strtolower($node->nodeName);

		// start whitespace
		switch ($name) {
			case "hr":
				return "---------------------------------------------------------------\n";

			case "style":
			case "head":
			case "title":
			case "meta":
			case "script":
				// ignore these tags
				return "";

			case "h1":
			case "h2":
			case "h3":
			case "h4":
			case "h5":
			case "h6":
			case "ol":
			case "ul":
				// add two newlines, second line is added below
				$output = "\n";
				break;

			case "td":
			case "th":
				// add tab char to separate table fields
				$output = "\t";
				break;

			case "tr":
			case "p":
			case "div":
				// add one line
				$output = "\n";
				break;

			case "li":
				$output = "- ";
				break;

			default:
				// print out contents of unknown tags
				$output = "";
				break;
		}

		// debug
		//$output .= "[$name,$nextName]";

		if (isset($node->childNodes)) {
			for ($i = 0; $i < $node->childNodes->length; $i++) {
				$n = $node->childNodes->item($i);

				$text = static::iterateOverNode($n);

				$output .= $text;
			}
		}

		// end whitespace
		switch ($name) {
			case "style":
			case "head":
			case "title":
			case "meta":
			case "script":
				// ignore these tags
				return "";

			case "h1":
			case "h2":
			case "h3":
			case "h4":
			case "h5":
			case "h6":
				$output .= "\n";
				break;

			case "p":
			case "br":
				// add one line
				if ($nextName != "div")
					$output .= "\n";
				break;

			case "div":
				// add one line only if the next child isn't a div
				if (($nextName != "div" && $nextName != null) || ($node->hasAttribute('class') && strstr($node->getAttribute('class'), 'emailtemplateSpacing')))
					$output .= "\n";
				break;

			case "td":
				// add one line only if the next child isn't a div
				if ($node->hasAttribute('class') && strstr($node->getAttribute('class'), 'emailtemplateSpacing'))
					$output .= "\n\n";
				break;

			case "a":
				// links are returned in [text](link) format
				$href = $node->getAttribute("href");

				$output = trim($output);

				// remove double [[ ]] s from linking images
				if (substr($output, 0, 1) == "[" && substr($output, -1) == "]") {
					$output = substr($output, 1, strlen($output) - 2);

					// for linking images, the title of the <a> overrides the title of the <img>
					if ($node->getAttribute("title")) {
						$output = $node->getAttribute("title");
					}
				}

				// if there is no link text, but a title attr
				if (!$output && $node->getAttribute("title")) {
					$output = $node->getAttribute("title");
				}

				if ($href == null) {
					// it doesn't link anywhere
					if ($node->getAttribute("name") != null) {
						$output = "[$output]";
					}
				} else {
					if ($href == $output || $href == "mailto:$output" || $href == "http://$output" || $href == "https://$output") {
						// link to the same address: just use link
						$output;
					} else {
						// replace it
						if ($output) {
							$output = "[$output]($href)";
						} else {
							// empty string
							$output = $href;
						}
					}
				}

				// does the next node require additional whitespace?
				switch ($nextName) {
					case "h1": case "h2": case "h3": case "h4": case "h5": case "h6":
						$output .= "\n";
						break;
				}
				break;

			case "img":
				if ($node->getAttribute("title")) {
					$output = "[" . $node->getAttribute("title") . "]";
				} elseif ($node->getAttribute("alt")) {
					$output = "[" . $node->getAttribute("alt") . "]";
				} else {
					$output = "";
				}
				break;

			case "li":
				$output .= "\n";
				break;

			default:
				// do nothing
		}

		return $output;
	}

}


?>