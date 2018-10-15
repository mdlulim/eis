<?php
class ControllerCommonChoosePassword extends Controller {

	private $error = array();

	public function index() {
		$token = $this->session->data['token'];

		/*==================================
		=       Add Files (Includes)       =
		==================================*/

		# stylesheets (CSS) files
		$this->document->addStyle('view/javascript/bootstrap-sweetalert/sweetalert.css');
		$this->document->addStyle('view/stylesheet/custom.css');
		$this->document->addStyle('view/stylesheet/choose-password.css');

		# javascript (JS) files
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert.min.js');
		$this->document->addScript('view/javascript/bootstrap-sweetalert/sweetalert-data.js');
		$this->document->addScript('view/javascript/choose-password.js');

		# controller(s)
		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		/*=====  End of Add Files (Includes)  ======*/

		// if AJAX | POST, change password
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->changePassword();
		}

		$this->load->language('common/choose_password');
		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] 			= $this->language->get('heading_title');
		$data['text_new_password'] 		= $this->language->get('text_new_password');
		$data['text_confirm_password'] 	= $this->language->get('text_confirm_password');
		$data['text_password_strength'] = $this->language->get('text_password_strength');
		$data['button_change_password'] = $this->language->get('button_change_password');
		
		/*======================================================
		=            Check Install Directory Exists            =
		======================================================*/
		
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$data['error_install'] = $this->language->get('error_install');
		} else {
			$data['error_install'] = '';
		}
		
		/*=====  End of Check Install Directory Exists  ======*/

		$data['form_action']     = $this->url->link('common/choose_password', "token=$token", true);
		$data['logged']          = false;
		$data['dashboard_route'] = getDashboard($this->user);

		$this->response->setOutput($this->load->view('common/choose_password', $data));
	}

	protected function changePassword() {
		$json['success'] = false;
		if ($this->validateForm()) {
			$this->load->model('user/user');
			$uid      = $this->session->data['user_id'];
			$password = $this->request->post['password'];
			$this->model_user_user->changePassword($uid, $password);

			# get user information
			$userInfo = $this->model_user_user->getUser($uid);

			# get mail client
			$emailClient = $this->config->get('config_mail_client');

			# build data array for email
			$email['subject'] = 'Password Changed';
			$email['to']      = array('email'=>$userInfo['email'], 'name'=>$userInfo['firstname']);
			$email['from']    = array('email'=>$this->config->get('config_email'), 'name'=>$this->config->get('config_name'));

			switch ($emailClient) {
				case 'mandrill':

					/*******************************************************
					 * Send change password email using Mandrill
					 *******************************************************/

					# message for email
					$email['message'] = array(
						'subject' => $email['subject'],
						'to'      => array(
							array(
								'email' => $email['to']['email'],
								'type'  => 'to'
							)
						),
						'global_merge_vars' => array(
							array(
								'name'    => 'STORE_URL',
								'content' => $this->config->get('config_url')
							),
							array(
								'name'    => 'STORE_NAME',
								'content' => $this->config->get('config_owner')
							),
							array(
								'name'    => 'STORE_EMAIL',
								'content' => $this->config->get('config_email')
							),
							array(
								'name'    => 'HELP_GUIDE',
								'content' => 'https://help.saleslogic.io/portal/home'
							),
							array(
								'name'    => 'MANAGER_EMAIL',
								'content' => $this->config->get('config_email')
							),
						)
					);
					$template['name'] = 'baselogic-change-password';
					$emailResult      = sendEmail($email, false, $template, $emailClient);
					$json['success']  = $emailResult;
					break;
			}

			
			$json['message'] = "Your password has been changed successfully.";
		}
		if (isset($this->error['warning'])) {
			$json['error'] = $this->error['warning'];
		}
		echo json_encode($json);
		die();
	}

	protected function validateForm() {
		$this->load->language('common/choose_password');
		// Make sure passwords are not empty
		if (!isset($this->request->post['password']) || !isset($this->request->post['confirm_password'])) {
			$this->error['warning'] = $this->language->get('error_password_empty');
		}
		// Check if passwords match
		if ($this->request->post['password'] <> $this->request->post['confirm_password']) {
			$this->error['warning'] = $this->language->get('error_password_match');
		}
		return !$this->error;
	}
}