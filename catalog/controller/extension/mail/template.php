<?php
class ControllerExtensionMailTemplate extends Controller {
	public $trigger_key = '';
	public function index() {
		return $this->view();
	}
	public function view() {
		if (empty($this->request->get['id']) || empty($this->request->get['enc'])) {
			exit();
		}

		$this->load->model('extension/mail/template');

		$log = $this->model_extension_mail_template->getTemplateLog(array(
			'emailtemplate_log_id' => $this->request->get['id'],
			'emailtemplate_log_enc' => $this->request->get['enc'],
			'emailtemplate_log_status' => 1
		), true);

		// One attempt
		if (!$log) {
			$this->model_extension_mail_template->disableTemplateLog($this->request->get['id']);
			exit;
		}

		$template = $this->model_extension_mail_template->load($log['emailtemplate_id']);

		if (!$template) {
			$template = $this->model_extension_mail_template->load(1);
		}

		$template->build();

		if ($template->data['config']['view_browser_theme']) {
			$this->load->language('information/information');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home'),
				'separator' => false
			);

			$this->document->setTitle($log['emailtemplate_log_subject']);

			$data['heading_title'] = $log['emailtemplate_log_subject'];

			$data['button_continue'] = $this->language->get('button_continue');

			$data['description'] = "<div class='well'>" . html_entity_decode($log['emailtemplate_log_content'], ENT_QUOTES, 'UTF-8') . "</div>";

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('information/information', $data));
		} else {
			$template->fetch(null, $log['emailtemplate_log_content']);

			$html = $template->getHtml();

			$dom = new DOMDocument;
			$dom->loadHTML($html);

			$xPath = new DOMXPath($dom);
			$nodes = $xPath->query('//*[@id="emailtemplate-view-browser"]');

			if($nodes->item(0)) {
				$nodes->item(0)->parentNode->removeChild($nodes->item(0));
			}

			$html = $dom->saveHTML();

			echo $html;
			exit;
		}
	}

	public function record() {
		if (! empty($this->request->get['id']) && ! empty($this->request->get['enc'])) {
			$this->load->model('extension/mail/template');

			$this->model_extension_mail_template->readTemplateLog($this->request->get['id'], $this->request->get['enc']);

			if (defined('DIR_CATALOG')) {
				$graphic_http = DIR_CATALOG . '/view/theme/default/image/blank.gif';
			} else {
				$graphic_http = DIR_APPLICATION . '/view/theme/default/image/blank.gif';
			}

			$filesize = filesize(DIR_TEMPLATE . 'default/image/blank.gif');

			header('Content-Type: image/gif');
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Cache-Control: private', false);
			header('Content-Disposition: attachment; filename="blank.gif"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . $filesize);
			readfile($graphic_http);

			exit();
		}
	}
}