<?php
ini_set('max_execution_time', 300);
include DIR_SYSTEM.'library/PHPExcel.php';
class ControllerSaleExportorder extends Controller {
	private $error = array();

	public function index(){
		$this->load->model('sale/order');
		$this->load->language('sale/exportorder');
		$this->load->model('sale/exportport');
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		
		$i=1;
		
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}

		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle("Order");
		
		//Change Cell Format 
		$objPHPExcel->getActiveSheet()->getStyle('BA')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$objPHPExcel->getActiveSheet()->getStyle('BM')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$objPHPExcel->getActiveSheet()->getStyle('BG')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		
		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $this->language->get('entry_order_id'))->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $this->language->get('text_invoice_no'))->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $this->language->get('text_invoice_prefix'))->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $this->language->get('entry_store_id'))->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $this->language->get('entry_store'))->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $this->language->get('entry_store_url'))->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $this->language->get('entry_customer_id'))->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $this->language->get('entry_customer'))->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $this->language->get('entry_customergroup_id'))->getColumnDimension('I')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $this->language->get('entry_firstname'))->getColumnDimension('J')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $this->language->get('entry_lastname'))->getColumnDimension('K')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $this->language->get('entry_email'))->getColumnDimension('L')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $this->language->get('entry_telephone'))->getColumnDimension('M')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $this->language->get('entry_fax'))->getColumnDimension('N')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $this->language->get('text_custom_field'))->getColumnDimension('O')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $this->language->get('text_payment_firstname'))->getColumnDimension('P')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $this->language->get('text_payment_lastname'))->getColumnDimension('Q')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $this->language->get('text_payment_company'))->getColumnDimension('R')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $this->language->get('text_payment_address_1'))->getColumnDimension('S')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $this->language->get('text_payment_address_2'))->getColumnDimension('T')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $this->language->get('text_payment_postcode'))->getColumnDimension('U')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $this->language->get('text_payment_city'))->getColumnDimension('V')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $this->language->get('text_payment_zone_id'))->getColumnDimension('W')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('X'.$i, $this->language->get('text_payment_zone'))->getColumnDimension('X')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, $this->language->get('text_payment_zone_code'))->getColumnDimension('Y')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, $this->language->get('text_payment_country_id'))->getColumnDimension('Z')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AA'.$i,$this->language->get('text_payment_country'))->getColumnDimension('AA')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, $this->language->get('text_payment_iso_code_2'))->getColumnDimension('AB')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AC'.$i, $this->language->get('text_payment_iso_code_3'))->getColumnDimension('AC')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, $this->language->get('text_payment_address_format'))->getColumnDimension('AD')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AE'.$i, $this->language->get('text_payment_custom_field'))->getColumnDimension('AE')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AF'.$i, $this->language->get('text_payment_method'))->getColumnDimension('AF')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AG'.$i, $this->language->get('text_payment_code'))->getColumnDimension('AG')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AH'.$i, $this->language->get('text_shipping_firstname'))->getColumnDimension('AH')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AI'.$i, $this->language->get('text_shipping_lastname'))->getColumnDimension('AI')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i, $this->language->get('text_shipping_company'))->getColumnDimension('AJ')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AK'.$i, $this->language->get('text_shipping_address_1'))->getColumnDimension('AK')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AL'.$i, $this->language->get('text_shipping_address_2'))->getColumnDimension('AL')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AM'.$i, $this->language->get('text_shipping_postcode'))->getColumnDimension('AM')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AN'.$i, $this->language->get('text_shipping_city'))->getColumnDimension('AN')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AO'.$i, $this->language->get('text_shipping_zone_id'))->getColumnDimension('AO')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AP'.$i, $this->language->get('text_shipping_zone'))->getColumnDimension('AP')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$i, $this->language->get('text_shipping_zone_code'))->getColumnDimension('AQ')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AR'.$i, $this->language->get('text_shipping_country_id'))->getColumnDimension('AR')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AS'.$i, $this->language->get('text_shipping_country'))->getColumnDimension('AS')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AT'.$i, $this->language->get('text_shipping_iso_code_2'))->getColumnDimension('AT')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AU'.$i, $this->language->get('text_shipping_iso_code_3'))->getColumnDimension('AU')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AV'.$i, $this->language->get('text_shipping_address_format'))->getColumnDimension('AV')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AW'.$i, $this->language->get('text_shipping_custom_field'))->getColumnDimension('AW')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AX'.$i, $this->language->get('text_shipping_method'))->getColumnDimension('AX')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AY'.$i, $this->language->get('text_shipping_code'))->getColumnDimension('AY')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$i, $this->language->get('text_comment'))->getColumnDimension('AZ')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BA'.$i, $this->language->get('text_total'))->getColumnDimension('BA')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BB'.$i, $this->language->get('text_reward'))->getColumnDimension('BB')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BC'.$i, $this->language->get('text_order_status_id'))->getColumnDimension('BC')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BD'.$i, $this->language->get('text_affiliate_id'))->getColumnDimension('BD')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BE'.$i, $this->language->get('text_affiliate_firstname'))->getColumnDimension('BE')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BF'.$i, $this->language->get('text_affiliate_lastname'))->getColumnDimension('BF')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BG'.$i, $this->language->get('text_commission'))->getColumnDimension('BG')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BH'.$i, $this->language->get('text_language_id'))->getColumnDimension('BH')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BI'.$i, $this->language->get('text_language_code'))->getColumnDimension('BI')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BJ'.$i, $this->language->get('text_language_directory'))->getColumnDimension('BJ')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BK'.$i, $this->language->get('text_currency_id'))->getColumnDimension('BK')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BL'.$i, $this->language->get('text_currency_code'))->getColumnDimension('BL')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BM'.$i, $this->language->get('text_currency_value'))->getColumnDimension('BM')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BN'.$i, $this->language->get('text_ip'))->getColumnDimension('BN')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BO'.$i, $this->language->get('text_forwarded_ip'))->getColumnDimension('BO')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BP'.$i, $this->language->get('text_user_agent'))->getColumnDimension('BP')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BQ'.$i, $this->language->get('text_accept_language'))->getColumnDimension('BQ')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BR'.$i, $this->language->get('text_date_added'))->getColumnDimension('BR')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->setCellValue('BS'.$i, $this->language->get('text_date_modified'))->getColumnDimension('BS')->setAutoSize(true);
		
		
		//Order Products
		$u=1;
		$objWorkSheet = $objPHPExcel->createSheet(1);
		$objWorkSheet->setTitle("Order Product");

		$objWorkSheet->setCellValue('A'.$u, 'Order product ID')->getColumnDimension('A')->setAutoSize(true);
		$objWorkSheet->setCellValue('B'.$u, 'Order ID')->getColumnDimension('B')->setAutoSize(true);
		$objWorkSheet->setCellValue('C'.$u, 'Product ID')->getColumnDimension('C')->setAutoSize(true);
		$objWorkSheet->setCellValue('D'.$u, 'Product')->getColumnDimension('D')->setAutoSize(true);
		$objWorkSheet->setCellValue('E'.$u, 'Model')->getColumnDimension('E')->setAutoSize(true);
		$objWorkSheet->setCellValue('F'.$u, 'Quantity')->getColumnDimension('F')->setAutoSize(true);
		$objWorkSheet->setCellValue('G'.$u, 'Price')->getColumnDimension('G')->setAutoSize(true);
		$objWorkSheet->setCellValue('H'.$u, 'Total')->getColumnDimension('H')->setAutoSize(true);
		$objWorkSheet->setCellValue('I'.$u, 'Tax')->getColumnDimension('I')->setAutoSize(true);
		$objWorkSheet->setCellValue('J'.$u, 'Reward')->getColumnDimension('J')->setAutoSize(true);
		
		
		//Order Option
		
		$o=1;
		$objoptionWorkSheet = $objPHPExcel->createSheet(2);
		$objoptionWorkSheet->setTitle("Order Product Option");
		$objoptionWorkSheet->setCellValue('A'.$u, 'Order Option ID')->getColumnDimension('A')->setAutoSize(true);
		$objoptionWorkSheet->setCellValue('B'.$u, 'Order ID')->getColumnDimension('B')->setAutoSize(true);
		$objoptionWorkSheet->setCellValue('C'.$u, 'Order Product ID')->getColumnDimension('C')->setAutoSize(true);
		$objoptionWorkSheet->setCellValue('D'.$u, 'Product Option ID')->getColumnDimension('D')->setAutoSize(true);
		$objoptionWorkSheet->setCellValue('E'.$u, 'Product Option Value ID')->getColumnDimension('E')->setAutoSize(true);
		$objoptionWorkSheet->setCellValue('F'.$u, 'Option Name')->getColumnDimension('F')->setAutoSize(true);
		$objoptionWorkSheet->setCellValue('G'.$u, 'Option Value')->getColumnDimension('G')->setAutoSize(true);
		$objoptionWorkSheet->setCellValue('H'.$u, 'Option Type')->getColumnDimension('H')->setAutoSize(true);
		
		
		///Order Total
		$t=1;
		$objtotalWorkSheet = $objPHPExcel->createSheet(3);
		$objtotalWorkSheet->setTitle("Order Total");
		$objtotalWorkSheet->setCellValue('A'.$t, 'Order Total ID')->getColumnDimension('A')->setAutoSize(true);
		$objtotalWorkSheet->setCellValue('B'.$t, 'Order ID')->getColumnDimension('B')->setAutoSize(true);
		$objtotalWorkSheet->setCellValue('C'.$t, 'Code')->getColumnDimension('C')->setAutoSize(true);
		$objtotalWorkSheet->setCellValue('D'.$t, 'Title')->getColumnDimension('D')->setAutoSize(true);
		$objtotalWorkSheet->setCellValue('E'.$t, 'Value')->getColumnDimension('E')->setAutoSize(true);
		$objtotalWorkSheet->setCellValue('F'.$t, 'Sort order')->getColumnDimension('F')->setAutoSize(true);
		
		//Order History
		$h=1;
		$objhistoryWorkSheet = $objPHPExcel->createSheet(4);
		$objhistoryWorkSheet->setTitle("Order History");
		$objhistoryWorkSheet->setCellValue('A'.$h, 'Order History ID')->getColumnDimension('A')->setAutoSize(true);
		$objhistoryWorkSheet->setCellValue('B'.$h, 'Order ID')->getColumnDimension('B')->setAutoSize(true);
		$objhistoryWorkSheet->setCellValue('C'.$h, 'Order Status ID')->getColumnDimension('C')->setAutoSize(true);
		$objhistoryWorkSheet->setCellValue('D'.$h, 'Order Status')->getColumnDimension('D')->setAutoSize(true);
		$objhistoryWorkSheet->setCellValue('E'.$h, 'Notify')->getColumnDimension('E')->setAutoSize(true);
		$objhistoryWorkSheet->setCellValue('F'.$h, 'Comment')->getColumnDimension('F')->setAutoSize(true);
		$objhistoryWorkSheet->setCellValue('G'.$h, 'Date Added')->getColumnDimension('G')->setAutoSize(true);
		
		//Order Voucher
		$v=1;
		$objVoucherWorkSheet = $objPHPExcel->createSheet(5);
		$objVoucherWorkSheet->setTitle("Order Voucher");
		$objVoucherWorkSheet->setCellValue('A'.$v, 'Order Voucher ID')->getColumnDimension('A')->setAutoSize(true);
		$objVoucherWorkSheet->setCellValue('B'.$v, 'Order ID')->getColumnDimension('B')->setAutoSize(true);
		$objVoucherWorkSheet->setCellValue('C'.$v, 'Voucher ID')->getColumnDimension('C')->setAutoSize(true);
		$objVoucherWorkSheet->setCellValue('D'.$v, 'Description')->getColumnDimension('D')->setAutoSize(true);
		$objVoucherWorkSheet->setCellValue('E'.$v, 'Code')->getColumnDimension('E')->setAutoSize(true);
		$objVoucherWorkSheet->setCellValue('F'.$v, 'From Name')->getColumnDimension('F')->setAutoSize(true);
		$objVoucherWorkSheet->setCellValue('G'.$v, 'From Email')->getColumnDimension('G')->setAutoSize(true);
		$objVoucherWorkSheet->setCellValue('H'.$v, 'To Name')->getColumnDimension('H')->setAutoSize(true);
		$objVoucherWorkSheet->setCellValue('I'.$v, 'Voucher Theme ID')->getColumnDimension('I')->setAutoSize(true);
		$objVoucherWorkSheet->setCellValue('J'.$v, 'Message')->getColumnDimension('J')->setAutoSize(true);
		$objVoucherWorkSheet->setCellValue('K'.$v, 'Amount')->getColumnDimension('K')->setAutoSize(true);
		
		$data['orders'] = array();
		
		if(isset($this->request->post['selected'])){
			$selected = $this->request->post['selected'];
		}else{
			$selected = array();
		}

		$filter_data = array(
			'selected'			   => $selected,
			'filter_order_id'      => $filter_order_id,
			'filter_customer'	   => $filter_customer,
			'filter_order_status'  => $filter_order_status,
			'filter_total'         => $filter_total,
			'filter_date_added'    => $filter_date_added,
			'filter_date_modified' => $filter_date_modified,
			'sort'                 => $sort,
			'order'                => $order,
			/* 'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin') */
		);

		
		$results = $this->model_sale_exportport->getOrders($filter_data);
		foreach($results as $value){
			$result = $this->model_sale_exportport->getOrder($value['order_id']);
			$i++;
			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $result['order_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $result['invoice_no']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $result['invoice_prefix']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $result['store_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $result['store_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $result['store_url']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $result['customer_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $result['customer']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $result['customer_group_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $result['firstname']);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $result['lastname']);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $result['email']);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $result['telephone']);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $result['fax']);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $result['custom_field']);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $result['payment_firstname']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $result['payment_lastname']);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $result['payment_company']);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $result['payment_address_1']);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $result['payment_address_2']);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $result['payment_postcode']);
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $result['payment_city']);
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $result['payment_zone_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$i, $result['payment_zone']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, $result['payment_zone_code']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, $result['payment_country_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, $result['payment_country']);
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, $result['payment_iso_code_2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$i, $result['payment_iso_code_3']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, $result['payment_address_format']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$i, $result['payment_custom_field']);
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$i, $result['payment_method']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$i, $result['payment_code']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$i, $result['shipping_firstname']);
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$i, $result['shipping_lastname']);
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i, $result['shipping_company']);
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$i, $result['shipping_address_1']);
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$i, $result['shipping_address_2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$i, $result['shipping_postcode']);
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$i, $result['shipping_city']);
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$i, $result['shipping_zone_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$i, $result['shipping_zone']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$i, $result['shipping_zone_code']);
			$objPHPExcel->getActiveSheet()->setCellValue('AR'.$i, $result['shipping_country_id']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('AS'.$i, $result['shipping_country']);
			$objPHPExcel->getActiveSheet()->setCellValue('AT'.$i, $result['shipping_iso_code_2']);
			$objPHPExcel->getActiveSheet()->setCellValue('AU'.$i, $result['shipping_iso_code_3']);
			$objPHPExcel->getActiveSheet()->setCellValue('AV'.$i, $result['shipping_address_format']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('AW'.$i, $result['shipping_custom_field']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('AX'.$i, $result['shipping_method']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('AY'.$i, $result['shipping_code']);
			$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$i, $result['comment']);
			$objPHPExcel->getActiveSheet()->setCellValue('BA'.$i, sprintf("%0.2f", $result['total']));
			
			
			$objPHPExcel->getActiveSheet()->setCellValue('BB'.$i, $result['reward']);
			$objPHPExcel->getActiveSheet()->setCellValue('BC'.$i, $result['order_status_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('BD'.$i, $result['affiliate_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('BE'.$i, $result['affiliate_firstname']);
			$objPHPExcel->getActiveSheet()->setCellValue('BF'.$i, $result['affiliate_lastname']);
			$objPHPExcel->getActiveSheet()->setCellValue('BG'.$i, $result['commission']);
			$objPHPExcel->getActiveSheet()->setCellValue('BH'.$i, $result['language_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('BI'.$i, $result['language_code']);
			$objPHPExcel->getActiveSheet()->setCellValue('BJ'.$i, $result['language_directory']);
			$objPHPExcel->getActiveSheet()->setCellValue('BK'.$i, $result['currency_id']);
			$objPHPExcel->getActiveSheet()->setCellValue('BL'.$i, $result['currency_code']);
			$objPHPExcel->getActiveSheet()->setCellValue('BM'.$i, $result['currency_value']);
			$objPHPExcel->getActiveSheet()->setCellValue('BN'.$i, $result['ip']);
			$objPHPExcel->getActiveSheet()->setCellValue('BO'.$i, $result['forwarded_ip']);
			$objPHPExcel->getActiveSheet()->setCellValue('BP'.$i, $result['user_agent']);
			$objPHPExcel->getActiveSheet()->setCellValue('BQ'.$i, $result['accept_language']);
			$objPHPExcel->getActiveSheet()->setCellValue('BR'.$i, $result['date_added']);
			$objPHPExcel->getActiveSheet()->setCellValue('BS'.$i, $result['date_modified']);
			
			$order_products  = $this->model_sale_order->getOrderProducts($result['order_id']);
			foreach($order_products as $orderproduct){
				$u++;
				$objWorkSheet->setCellValue('A'.$u, $orderproduct['order_product_id']);
				$objWorkSheet->setCellValue('B'.$u, $orderproduct['order_id']);
				$objWorkSheet->setCellValue('C'.$u, $orderproduct['product_id']);
				$objWorkSheet->setCellValue('D'.$u, $orderproduct['name']);
				$objWorkSheet->setCellValue('E'.$u, $orderproduct['model']);
				$objWorkSheet->setCellValue('F'.$u, $orderproduct['quantity']);
				$objWorkSheet->setCellValue('G'.$u, $orderproduct['price']);
				$objWorkSheet->setCellValue('H'.$u, $orderproduct['total']);
				$objWorkSheet->setCellValue('I'.$u, $orderproduct['tax']);
				$objWorkSheet->setCellValue('J'.$u, $orderproduct['reward']);
				
				$order_product_options = $this->model_sale_order->getOrderOptions($result['order_id'],$orderproduct['order_product_id']);
				foreach($order_product_options as $option){
					$o++;
					$objoptionWorkSheet->setCellValue('A'.$o, $option['order_option_id']);
					$objoptionWorkSheet->setCellValue('B'.$o, $option['order_id']);
					$objoptionWorkSheet->setCellValue('C'.$o, $option['order_product_id']);
					$objoptionWorkSheet->setCellValue('D'.$o, $option['product_option_id']);
					$objoptionWorkSheet->setCellValue('E'.$o, $option['product_option_value_id']);
					$objoptionWorkSheet->setCellValue('F'.$o, $option['name']);
					$objoptionWorkSheet->setCellValue('G'.$o, $option['value']);
					$objoptionWorkSheet->setCellValue('H'.$o, $option['type']);
				}
			}
			
			//totals
			$order_totals  = $this->model_sale_order->getOrderTotals($result['order_id']);
			foreach($order_totals as $total){
				$t++;
				$objtotalWorkSheet->setCellValue('A'.$t, $total['order_total_id']);
				$objtotalWorkSheet->setCellValue('B'.$t, $total['order_id']);
				$objtotalWorkSheet->setCellValue('C'.$t, $total['code']);
				$objtotalWorkSheet->setCellValue('D'.$t, $total['title']);
				$objtotalWorkSheet->setCellValue('E'.$t, sprintf("%0.2f", $total['value']));
				$objtotalWorkSheet->setCellValue('F'.$t, $total['sort_order']);
			}
			
			//history
			$order_historys  = $this->model_sale_exportport->getOrderexportHistories($result['order_id']);
			foreach($order_historys as $history){
				$h++;
				$objhistoryWorkSheet->setCellValue('A'.$h, $history['order_history_id']);
				$objhistoryWorkSheet->setCellValue('B'.$h, $history['order_id']);
				$objhistoryWorkSheet->setCellValue('C'.$h, $history['order_status_id']);
				$objhistoryWorkSheet->setCellValue('D'.$h, $history['name']);
				$objhistoryWorkSheet->setCellValue('E'.$h, $history['notify']);
				$objhistoryWorkSheet->setCellValue('F'.$h, $history['comment']);
				$objhistoryWorkSheet->setCellValue('G'.$h, $history['date_added']);
			}
			
			//Voucher
			$order_vouchers  = $this->model_sale_order->getOrderVouchers($result['order_id']);
			foreach($order_vouchers as $voucher){
				$v++;
				$objVoucherWorkSheet->setCellValue('A'.$v, $voucher['order_voucher_id']);
				$objVoucherWorkSheet->setCellValue('B'.$v, $voucher['order_id']);
				$objVoucherWorkSheet->setCellValue('C'.$v, $voucher['voucher_id']);
				$objVoucherWorkSheet->setCellValue('D'.$v, $voucher['description']);
				$objVoucherWorkSheet->setCellValue('E'.$v, $voucher['code']);
				$objVoucherWorkSheet->setCellValue('F'.$v, $voucher['from_name']);
				$objVoucherWorkSheet->setCellValue('G'.$v, $voucher['from_email']);
				$objVoucherWorkSheet->setCellValue('H'.$v, $voucher['to_name']);
				$objVoucherWorkSheet->setCellValue('I'.$v, $voucher['to_email']);
				$objVoucherWorkSheet->setCellValue('J'.$v, $voucher['voucher_theme_id']);
				$objVoucherWorkSheet->setCellValue('K'.$v, $voucher['message']);
				$objVoucherWorkSheet->setCellValue('L'.$v, $voucher['amount']);
			}
		}
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		$filname ="orderexport-".time().'.xls';
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename='.$filname); 
		header('Cache-Control: max-age=0'); 
		$objWriter->save('php://output'); 
		exit(); 
	}
}