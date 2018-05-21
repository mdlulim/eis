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
 * @return <boolean>           True/false
 */
function sendEmail($data, $settings, $template=false) {

	/*=================================
	=            Send mail            =
	=================================*/
	
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
	if ($template) {
		$mail->setText(html_entity_decode($data['message'], ENT_QUOTES, 'UTF-8'));
		$mail = $template->hook($mail);
	} else {
		$mail->setText(html_entity_decode($data['message'], ENT_QUOTES, 'UTF-8'));
	}
	$mail->send();
	($template) ? $template->sent() : "";

	return true;

	/*=====  End of Send mail  ======*/
}