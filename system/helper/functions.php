<?php

function relativeTime($time, $short = false){
    $SECOND = 1;
    $MINUTE = 60 * $SECOND;
    $HOUR   = 60 * $MINUTE;
    $DAY    = 24 * $HOUR;
    $MONTH  = 30 * $DAY;
    $before = time() - $time;

    if ($before < 0) {
        return '';
    }

    if ($short) {
        if ($before < 1 * $MINUTE ) {
            return ($before <5) ? "just now" : $before . " ago";
        }

        if ($before < 2 * $MINUTE) {
            return "1m ago";
        }

        if ($before < 45 * $MINUTE) {
            return floor($before / 60) . "m ago";
        }

        if ($before < 90 * $MINUTE) {
            return "1h ago";
        }

        if ($before < 24 * $HOUR) {

            return floor($before / 60 / 60). "h ago";
        }

        if ($before < 48 * $HOUR) {
            return "1d ago";
        }

        if ($before < 30 * $DAY) {
            return floor($before / 60 / 60 / 24) . "d ago";
        }

        if ($before < 12 * $MONTH) {
            $months = floor($before / 60 / 60 / 24 / 30);
            return $months <= 1 ? "1mo ago" : $months . "mo ago";
        } else {
            $years = floor  ($before / 60 / 60 / 24 / 30 / 12);
            return $years <= 1 ? "1y ago" : $years."y ago";
        }
    }

    if ($before < 1 * $MINUTE) {
        return ($before <= 1) ? "just now" : $before . " seconds ago";
    }

    if ($before < 2 * $MINUTE) {
        return "a minute ago";
    }

    if ($before < 45 * $MINUTE) {
        return floor($before / 60) . " minutes ago";
    }

    if ($before < 90 * $MINUTE) {
        return "an hour ago";
    }

    if ($before < 24 * $HOUR) {
        return (floor($before / 60 / 60) == 1 ? 'about an hour' : floor($before / 60 / 60).' hours'). " ago";
    }

    if ($before < 48 * $HOUR) {
        return "yesterday";
    }

    if ($before < 30 * $DAY) {
        return floor($before / 60 / 60 / 24) . " days ago";
    }

    if ($before < 12 * $MONTH) {
        $months = floor($before / 60 / 60 / 24 / 30);
        return $months <= 1 ? "one month ago" : $months . " months ago";
    } else {
        $years = floor  ($before / 60 / 60 / 24 / 30 / 12);
        return $years <= 1 ? "one year ago" : $years." years ago";
    }

    return "$time";
}

function out($var) {
	if (is_array($var) || is_object($var)) {
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	} else {
		echo "<pre>$var</pre><br/>";
	}
}

function randomPassword($length=6, $chrs='1234567890qwertyuiopasdfghjklzxcvbnm'){
	$pwd = '';
	for ($i = 0; $i < $length; $i++) {
    	$pwd .= $chrs{mt_rand(0, strlen($chrs)-1)};
	}
	return $pwd;
}


/**
 * Send Email
 * @param  <array>  $data      Data array
 * @param  <array>  $settings  Configuration/SMTP settings array
 * @param  <mixed>  $template  Template [optional, default: false]
 * @param  <string> $client    Email client type [optional, default: Open Cart Mail]
 * @return <boolean>           True/false
 */
function sendEmail($data, $settings, $template=false, $client='mail') {

	/*=================================
	=            Send email           =
	=================================*/

	switch ($client) {

		/*----------  Mandrill Mail Client  ----------*/
		
		case 'mandrill':
			try {
				require_once(DIR_SYSTEM . 'library/mandrill/Mandrill.php');
				$_MANDRIL_API_KEY = 'njqRVZ3J9J3psHDoFjnTLQ'; // api key
			    $mandrill         = new Mandrill($_MANDRIL_API_KEY);
			    $template_name    = $template['name'];
			    $template_content = [];
			    $message          = $data['message'];
			    $async            = false;
			    $result           = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async);
			    return $result;

			} catch(Mandrill_Error $e) {
			    // Mandrill errors are thrown as exceptions
			    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
			    throw $e;
			}
			break;


		/*----------  Default OpenCart Mail Client  ----------*/
		
		default:
			$mail                = new Mail();
			$mail->protocol      = $settings['protocol'];
			$mail->parameter     = $settings['parameter'];
			$mail->smtp_hostname = $settings['smtp_hostname'];
			$mail->smtp_username = $settings['smtp_username'];
			$mail->smtp_password = html_entity_decode($settings['smtp_password'], ENT_QUOTES, 'UTF-8');
			$mail->smtp_port     = $settings['smtp_port'];
			$mail->smtp_timeout  = $settings['smtp_timeout'];

			$mail->setTo($data['to']['email']);
			$mail->setFrom($data['from']['email']);
			$mail->setSender(html_entity_decode($data['from']['email'], ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8'));
			if (is_object($template)) {
				$mail->setText(html_entity_decode($data['message'], ENT_QUOTES, 'UTF-8'));
				$mail = $template->hook($mail);
			} else {
				$mail->setText(html_entity_decode($data['message'], ENT_QUOTES, 'UTF-8'));
			}
			$mail->send();
			return true;
	}

	/*=====  End of Send email  ======*/
}

function getDashboard($user) {
	if ($user->hasPermission('access', 'common/sales_dashboard')) {
		return 'common/sales_dashboard';
	}
	if ($user->hasPermission('access', 'common/orders_dashboard')) {
		return 'common/orders_dashboard';
	}
	return false;
}

function getRemoteFilesize($url, $formatSize = true, $useHead = true) {
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER  => 1,
        CURLOPT_FOLLOWLOCATION  => 1,
        CURLOPT_SSL_VERIFYPEER  => 0,
        CURLOPT_NOBODY          => 1,
    ));
    if (false !== $useHead) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_exec($ch);
    // content-length of download (in bytes), read from Content-Length: field
    $clen = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    curl_close($ch);
    // cannot retrieve file size, return "-1"
    if (!$clen) {
        return -1;
    }
    if (!$formatSize) {
        return $clen; // return size in bytes
    }
    $size = $clen;
    switch ($clen) {
        case $clen < 1024:
            $size = $clen .' B'; break;
        case $clen < 1048576:
            $size = round($clen / 1024, 2) .' KiB'; break;
        case $clen < 1073741824:
            $size = round($clen / 1048576, 2) . ' MiB'; break;
        case $clen < 1099511627776:
            $size = round($clen / 1073741824, 2) . ' GiB'; break;
    }
    return $size; // return formatted size
}