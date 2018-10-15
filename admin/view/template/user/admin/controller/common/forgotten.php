<?php
class ControllerCommonForgotten extends Controller {
	private $error = array();

	public function index() {
		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$this->response->redirect($this->url->link(getDashboard($this->user), '', true));
		}

		if (!$this->config->get('config_password')) {
			$this->response->redirect($this->url->link('common/login', '', true));
		}

		$this->load->language('common/forgotten');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->load->language('mail/forgotten');

			$userInfo = $this->model_user_user->getUserByEmail($this->request->post['email']);

			if (!empty($userInfo)) {

				# auto-generate random/temporary password
				$password = randomPassword(6, '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM');

				# update password in DB
				$this->model_user_user->editPassword($userInfo['user_id'], $password);

				# get mail client
				$emailClient = $this->config->get('config_mail_client');

				# build data array for email
				$email['subject'] = 'Password Reset Confirmation';
				$email['to']      = array('email'=>$userInfo['email'], 'name'=>$userInfo['firstname']);
				$email['from']    = array('email'=>$this->config->get('config_email'), 'name'=>$this->config->get('config_name'));

				switch ($emailClient) {
					case 'mandrill':

						/*******************************************************
						 * Send reset password email using Mandrill
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
									'name'    => 'PASSWORD',
									'content' => $password
								),
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
						$template['name'] = 'baselogic-reset-password';
						$emailResult      = sendEmail($email, false, $template, $emailClient);
						if (isset($emailResult[0]['status']) && ($emailResult[0]['status'] == "sent" || $emailResult[0]['status'] == "queued" || $emailResult[0]['status'] == "scheduled")) {
							$this->session->data['success'] = $this->language->get('text_success');
							$this->response->redirect($this->url->link('common/login', '', true));
						} else {
							$this->error['warning'] = $this->language->get('error_generic');
						}
						break;
				}
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_your_email'] = $this->language->get('text_your_email');
		$data['text_email'] = $this->language->get('text_email');

		$data['entry_email'] = $this->language->get('entry_email');

		$data['button_reset'] = $this->language->get('button_reset');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link(getDashboard($this->user), '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/forgotten', 'token=' . '', true)
		);

		$data['action'] = $this->url->link('common/forgotten', '', true);

		$data['cancel'] = $this->url->link('common/login', '', true);

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('common/forgotten', $data));
	}

	protected function validate() {
		if (!isset($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_email');
		} elseif (!$this->model_user_user->getTotalUsersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_email');
		}

		return !$this->error;
	}
}
