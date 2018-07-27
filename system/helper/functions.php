<?php

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