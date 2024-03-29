<?php
class ControllerExtensionPaymentQuotation extends Controller {
	public function index() {
		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_loading'] = $this->language->get('text_loading');

		$data['continue'] = $this->url->link('checkout/success');

		return $this->load->view('extension/payment/quotation', $data);
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'quotation') {
			$this->load->model('checkout/order');

		if (INTEGRATION_ID == '1') {

			$this->load->model('extension/erp/arch');
			
			$debtor_code = $this->model_extension_erp_arch->getDebtorCode($this->customer->getId());

			$send_quote  = $this->model_extension_erp_arch->submitNewQuotation($debtor_code , $this->session->data['order_id'], $this->cart->getProducts(),$this->config->get('quotation_order_status_id'));

		//$this->addOrderHistory($order_id, 2, 'sent to arch', true);
			//$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('quotation_order_status_id'),'Order sent to arch',true);
		} else{
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('quotation_order_status_id'));
		}  
			
		}
	}
}
