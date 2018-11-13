<?php
/**
 * Created by PhpStorm.
 * User: kiroshan
 * Date: 2017/03/03
 * Time: 10:13 AM
 */
class ControllerCatalogPrice extends Controller {
    private $error = array();
    public function index() {
        $this->load->language('catalog/price');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/price');
        $this->getList();
    }
    public function add() {
        $this->load->language('catalog/price');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/price');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            
            $lastid = $this->model_catalog_price->addPrice($this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $url = '';
            if (isset($this->request->get['filter_sku'])) {
                $url .= '&filter_sku=' . $this->request->get['filter_sku'];
            }
            
            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->response->redirect($this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, true));
        }
        $this->getForm();
    }
    public function edit() {
        $this->load->language('catalog/price');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/price');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_price->editPrice($this->request->get['price_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $url = '';
            if (isset($this->request->get['filter_sku'])) {
                $url .= '&filter_sku=' . $this->request->get['filter_sku'];
            }
            
            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->response->redirect($this->url->link('catalog/price/view', 'token=' . $this->session->data['token'] . '&price_id=' . $this->request->get['price_id'] . '&customer_group_id='. $this->request->get['customer_group_id'] . $url, true));
        }
        $this->getForm();
    }
    public function delete() {
        $this->load->language('catalog/price');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/price');
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $price_id) {
                $this->model_catalog_price->deletePrice($price_id);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $url = '';
            if (isset($this->request->get['filter_sku'])) {
                $url .= '&filter_sku=' . $this->request->get['filter_sku'];
            }
            
            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->response->redirect($this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getList();
    }
    protected function getList() {
        
        if (isset($this->request->get['filter_sku'])) {
            $filter_sku = $this->request->get['filter_sku'];
        } else {
            $filter_sku = null;
        }
        
        if (isset($this->request->get['filter_customer_group_id'])) {
            $filter_customer_group_id = $this->request->get['filter_customer_group_id'];
        } else {
            $filter_customer_group_id = null;
        }
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'fgd.name';
        }
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        $url = '';
        if (isset($this->request->get['filter_sku'])) {
            $url .= '&filter_sku=' . $this->request->get['filter_sku'];
        }
        
        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], 'SSL')
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        $data['add'] = $this->url->link('catalog/price/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('catalog/price/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['import_csv'] = $this->url->link('catalog/price/importCSV', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['export_csv'] = $this->url->link('catalog/price/exportCSV', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['text_export']  = $this->language->get('text_export');
        $data['txt_import']  = $this->language->get('txt_import');
        $data['prices'] = array();
        $filter_data = array(
            'filter_sku'  => $filter_sku,
            'filter_customer_group_id'  => $filter_customer_group_id,
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );
        $filter_total = $this->model_catalog_price->getTotalPrice($filter_data);
        $results = $this->model_catalog_price->getPrices($filter_data);
        foreach ($results as $result) {
            $data['prices'][] = array(
                'price_id'=> $result['product_id'],
                'sku'   => $result['sku'],
                'contract'   => $result['c_name'],
                'customer_group_id'   => $result['customer_group_id'],
                'price'   => $result['price'],
                'view'          => $this->url->link('catalog/price/view', 'token=' . $this->session->data['token'] . '&price_id=' . $result['product_id'] .'&customer_group_id=' . $result['c_id'] . $url, 'SSL'),
                'edit'          => $this->url->link('catalog/price/edit', 'token=' . $this->session->data['token'] . '&price_id=' . $result['product_id'] .'&customer_group_id=' . $result['c_id'] . $url, 'SSL')
            );
        }
        
        $data['Dropdownskus'] = $this->model_catalog_price->getPricesByGroupSku();
        $data['Dropdowncustomergroup'] = $this->model_catalog_price->getCustomerGroups();
        
        $data['heading_title']          = $this->language->get('heading_title');
        $data['text_list']              = $this->language->get('text_list');
        $data['text_no_results']        = $this->language->get('text_no_results');
        $data['text_confirm']           = $this->language->get('text_confirm');
        $data['column_sku']         = $this->language->get('column_sku');
        $data['column_contract']        = $this->language->get('column_contract');
        $data['column_price']       = $this->language->get('column_price');
        $data['button_add']             = $this->language->get('button_add');
        $data['button_edit']            = $this->language->get('button_edit');
        $data['button_delete']          = $this->language->get('button_delete');
        
        $data['token'] = $this->session->data['token'];
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }
        $url = '';
        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $data['sort_name'] = $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . '&sort=fgd.name' . $url, 'SSL');
        $data['sort_sort_order'] = $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . '&sort=fg.sort_order' . $url, 'SSL');
        $url = '';
        if (isset($this->request->get['filter_sku'])) {
            $url .= '&filter_sku=' . $this->request->get['filter_sku'];
        }
        
        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        $pagination             = new Pagination();
        $pagination->total      = $filter_total;
        $pagination->page       = $page;
        $pagination->limit      = $this->config->get('config_limit_admin');
        $pagination->url        = $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        $data['pagination']     = $pagination->render();
        $data['results']        = sprintf($this->language->get('text_pagination'), ($filter_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($filter_total - $this->config->get('config_limit_admin'))) ? $filter_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $filter_total, ceil($filter_total / $this->config->get('config_limit_admin')));
        $data['filter_sku']                = $filter_sku;
        $data['filter_customer_group_id']  = $filter_customer_group_id;
        $data['sort']                      = $sort;
        $data['order']                     = $order;
        $data['header']         = $this->load->controller('common/header');
        $data['column_left']    = $this->load->controller('common/column_left');
        $data['footer']         = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('catalog/price_list.tpl', $data));
    }
    protected function getForm() {
        $data['heading_title']          = $this->language->get('heading_title');
        $data['text_form']              = !isset($this->request->get['price_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['entry_sku']      = $this->language->get('entry_sku');
        $data['entry_contract'] = $this->language->get('entry_contract');
        $data['entry_price'] = $this->language->get('entry_price');
        $data['button_save']            = $this->language->get('button_save');
        $data['button_cancel']          = $this->language->get('button_cancel');
        $data['button_filter_add']      = $this->language->get('button_filter_add');
        $data['button_remove']          = $this->language->get('button_remove');
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        if (isset($this->error['group'])) {
            $data['error_group'] = $this->error['group'];
        } else {
            $data['error_group'] = array();
        }
        if (isset($this->error['filter'])) {
            $data['error_filter'] = $this->error['filter'];
        } else {
            $data['error_filter'] = array();
        }
        $url = '';
        if (isset($this->request->get['filter_sku'])) {
            $url .= '&filter_sku=' . $this->request->get['filter_sku'];
        }
        
        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], 'SSL')
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        if (!isset($this->request->get['price_id'])) {
            $data['action'] = $this->url->link('catalog/price/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/price/edit', 'token=' . $this->session->data['token'] . '&price_id=' . $this->request->get['price_id'] . '&customer_group_id=' . $this->request->get['customer_group_id'] . $url, 'SSL');
        }
        if(isset($this->request->get['price_id']))
        {
            $data['cancel'] = $this->url->link('catalog/price/view', 'token=' . $this->session->data['token'] . '&price_id=' . $this->request->get['price_id'].'&customer_group_id='. $this->request->get['customer_group_id'] . $url, 'SSL');
        } else {
            $data['cancel'] = $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL');
        }
        if (isset($this->request->get['price_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $data['price_info'] = $this->model_catalog_price->getPrice($this->request->get['price_id'],$this->request->get['customer_group_id']);
        }
        $data['token'] = $this->session->data['token'];
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();
        if (isset($this->request->post['filter_group_description'])) {
            $data['filter_group_description'] = $this->request->post['filter_group_description'];
        } elseif (isset($this->request->get['filter_group_id'])) {
            $data['filter_group_description'] = $this->model_catalog_filter->getFilterGroupDescriptions($this->request->get['filter_group_id']);
        } else {
            $data['filter_group_description'] = array();
        }
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($filter_group_info)) {
            $data['sort_order'] = $filter_group_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        if (isset($this->request->post['filter'])) {
            $data['filters'] = $this->request->post['filter'];
        } elseif (isset($this->request->get['filter_group_id'])) {
            $data['filters'] = $this->model_catalog_filter->getFilterDescriptions($this->request->get['filter_group_id']);
        } else {
            $data['filters'] = array();
        }
        if (isset($this->request->post['c_id'])) {
            $data['c_id'] = $this->request->post['c_id'];
        } elseif (!empty($contractid)) {
            $data['c_id'] = $contractid['c_id'];
        } else {
            $data['c_id'] = '';
        }
        $this->load->model('catalog/price');
        $data['customer_groups'] = $this->model_catalog_price->getCustomerGroups();
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('catalog/price_form.tpl', $data));
    }
    
    public function view() {
    
        $this->load->language('catalog/price');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/price');
    
        $data['heading_title']          = $this->language->get('heading_title');
        $data['text_form']              = !isset($this->request->get['price_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['entry_sku']      = $this->language->get('entry_sku');
        $data['entry_contract'] = $this->language->get('entry_contract');
        $data['entry_price'] = $this->language->get('entry_price');
        $data['button_save']            = $this->language->get('button_save');
        $data['button_cancel']          = $this->language->get('button_cancel');
        $data['button_filter_add']      = $this->language->get('button_filter_add');
        $data['button_remove']          = $this->language->get('button_remove');
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        $url = '';
        if (isset($this->request->get['filter_sku'])) {
            $url .= '&filter_sku=' . $this->request->get['filter_sku'];
        }
        
        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }
        
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link(getDashboard($this->user), 'token=' . $this->session->data['token'], 'SSL')
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        $data['action'] = $this->url->link('catalog/price/edit', 'token=' . $this->session->data['token'] . '&price_id=' . $this->request->get['price_id'].'&customer_group_id='. $this->request->get['customer_group_id'] . $url, 'SSL');
        
        $data['cancel'] = $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL');
        if (isset($this->request->get['price_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $data['price_info'] = $this->model_catalog_price->getPrice($this->request->get['price_id'],$this->request->get['customer_group_id']);
        }
        $data['token'] = $this->session->data['token'];
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();
        if (isset($this->request->post['filter_group_description'])) {
            $data['filter_group_description'] = $this->request->post['filter_group_description'];
        } elseif (isset($this->request->get['filter_group_id'])) {
            $data['filter_group_description'] = $this->model_catalog_filter->getFilterGroupDescriptions($this->request->get['filter_group_id']);
        } else {
            $data['filter_group_description'] = array();
        }
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($filter_group_info)) {
            $data['sort_order'] = $filter_group_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        if (isset($this->request->post['filter'])) {
            $data['filters'] = $this->request->post['filter'];
        } elseif (isset($this->request->get['filter_group_id'])) {
            $data['filters'] = $this->model_catalog_filter->getFilterDescriptions($this->request->get['filter_group_id']);
        } else {
            $data['filters'] = array();
        }
        if (isset($this->request->post['c_id'])) {
            $data['c_id'] = $this->request->post['c_id'];
        } elseif (!empty($contractid)) {
            $data['c_id'] = $contractid['c_id'];
        } else {
            $data['c_id'] = '';
        }
        $this->load->model('catalog/price');
        $data['customer_groups'] = $this->model_catalog_price->getCustomerGroups();
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('catalog/price_view.tpl', $data));
    }
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/price')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        foreach ($this->request->post['filter_group_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 64)) {
                $this->error['group'][$language_id] = $this->language->get('error_group');
            }
        }
        if (isset($this->request->post['filter'])) {
            foreach ($this->request->post['filter'] as $filter_id => $filter) {
                foreach ($filter['filter_description'] as $language_id => $filter_description) {
                    if ((utf8_strlen($filter_description['name']) < 1) || (utf8_strlen($filter_description['name']) > 64)) {
                        $this->error['filter'][$filter_id][$language_id] = $this->language->get('error_name');
                    }
                }
            }
        }
        return !$this->error;
    }
    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'catalog/price')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
    public function autocomplete() {
        $json = array();
        if (isset($this->request->get['filter_name'])) {
            $this->load->model('catalog/filter');
            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'start'       => 0,
                'limit'       => 5
            );
            $filters = $this->model_catalog_filter->getFilters($filter_data);
            foreach ($filters as $filter) {
                $json[] = array(
                    'filter_id' => $filter['filter_id'],
                    'name'      => strip_tags(html_entity_decode($filter['group'] . ' &gt; ' . $filter['name'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }
        $sort_order = array();
        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }
        array_multisort($sort_order, SORT_ASC, $json);
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    public function Filterautocomplete() {
        $json = array();
        if (isset($this->request->get['filter_sku'])) {
            $this->load->model('catalog/price');
            
            if (isset($this->request->get['filter_sku'])) {
                $filter_sku = $this->request->get['filter_sku'];
            } else {
                $filter_sku = '';
            }
            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 5;
            }
            $filter_data = array(
                'filter_sku'  => $filter_sku,
                'filter_groupby_sku'  => true,
                'start'        => 0,
                'limit'        => $limit
            );
            $results = $this->model_catalog_price->getPrices($filter_data);
            foreach ($results as $result) {
                
                $json[] = array(
                    'sku'      => $result['sku']
                );
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    public function importCSV(){
        $this->load->language('catalog/price');
        $this->load->model('catalog/price');
        $data['heading_title']  = $this->language->get('heading_title');
        $data['text_export']  = $this->language->get('text_export');
        $data['text_import']  = $this->language->get('text_import');
        
        $data['cancel'] = $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL');
        // cancel url
        $data['action'] = $this->url->link('catalog/price/importCSV', 'token=' . $this->session->data['token'] . $url, 'SSL');
        // current page url

        // Breadcrumbs start here
        $data['warning_error'] = '';
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array('text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/sales_dashboard', 'token=' . $this->session->data['token'], 'SSL'), 'separator' => false);
        //home page link
        $data['breadcrumbs'][] = array('text' => $this->language->get('column_contract'),
            'href' => $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL'), 'separator' => ' :: ');
            
        $data['breadcrumbs'][] = array('text' => $this->language->get('txt_import'),
            'href' => $this->url->link('catalog/price/importCSV', 'token=' . $this->session->data['token'] . $url, 'SSL'), 'separator' => ' :: ');
        
            //product page link
        // breadcrumbs end here
        if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
            $file = $_FILES['csv']['tmp_name'];
            $handle = fopen($file,"r");
            $contract = $this->request->post['contract_id'];
            //iterate through records

            if ((isset( $this->request->files['csv'] )) && (is_uploaded_file($this->request->files['csv']['tmp_name']))) 
			{
                $ext = strtolower(pathinfo($this->request->files['csv']['name'], PATHINFO_EXTENSION));
               
				if (($ext != 'xls') && ($ext != 'xlsx') && ($ext != 'ods') && ($ext != 'csv')) 
				{ 
					$this->session->data['import_error'] = 'The file type imported is not supported, please upload your file in CSV, XLS, XLSX and  ODS';
				}
				else
				{
					$maxsize    = 5097152;
					if(($this->request->files['csv']['size'] <= $maxsize) || ($this->request->files['csv']["size"] != 0)) 
					{
                        $file = $_FILES['csv']['tmp_name'];
					
                        $inputfilename = $file;
                        $inputfiletype = PHPExcel_IOFactory::identify($inputfilename);
                        $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
                        $objPHPExcel = $objReader->load($inputfilename);
                        $sheet = $objPHPExcel->getSheet(0); 
                        $highestRow = $sheet->getHighestDataRow(); 
                        $highestColumn = $sheet->getHighestDataColumn();

                         //echo $highestColumn; exit;
                        for ($row = 1; $row <= 1; $row++)
                        { 
                            $header1 = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, FALSE, FALSE);
                        }
                        
                        $header = array();
                        foreach   ($header1 as $key => $val)
                        {
                            $header = array_merge($val, $header);
                        }

                        $fields = array('SKU');
                        array_push($fields, 'Contact Pricing');
                        array_push($fields, 'Price');
                        $array1 = $header;
                        $array2 = $fields;

                        $fields_exist = 0;
                        foreach($fields as $fieldValue){
                            if (in_array($fieldValue, $header)){
                                $field_exist = 1;
                                
                            }
                            
                        }
                        //------------------------------ Start -----------------------------------------
                       
                        if($field_exist = 1 && $array1 == $array2){ 
                            
                        
                            for ($row = 2; $row <= $highestRow; $row++)
                            { 
                                //  Read a row of data into an array
                                    $sheetdata1 = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, FALSE, FALSE);
                                    $sheetdata = array();
                                    foreach   ($sheetdata1 as $key => $val)
                                    {
                                        $sheetdata = array_merge($val, $sheetdata);
                                    }
                                    $all_rows[] = array_combine($header, $sheetdata);
                            }
                            
                            $sku = '';
                            foreach($all_rows as $all_row){
                                if(!empty($all_row) && count($all_row) > 0)
                                {	
                                $sku = $all_row['SKU'] ? $all_row['SKU'] : '';
                                $contract = $all_row['Contact Pricing'] ? $all_row['Contact Pricing'] : '';
                                $price = $all_row['Price'] ? $all_row['Price'] : '';
                            
                                $data_array = array(
                                                    'sku' => $sku,
                                                    'contract' => $contract,
                                                    'price' => $price,
                                                );       
                                  $this->model_catalog_price->importCsvData($data_array,$contract);           
                               }
                            }
                            $this->session->data['success'] = ''.ucfirst($ext).' Successfully Imported!';
                            $data['warning_error'] = '';
                            $data['success'] = ''.ucfirst($ext).' Successfully Imported!';	
                            
                        } else 
                        { 
                          //  $this->session->data['warning_error'] = ''.ucfirst($ext).' Not Imported! <br> File Header Not Set Proper or Missing some Column on '.ucfirst($ext).' or Speling mismatch on '.$ext.' Header section as per Setting Tab. <br> Better to Export First to View Exact File Format!';	
                            $data['warning_error'] = ''.ucfirst($ext).' Not Imported! <br> File Header Not Set Proper or Missing some Column on '.ucfirst($ext).' or Speling mismatch on '.$ext.' Header section as per Setting Tab. <br> Better to Export First to View Exact File Format!';	
                       }
                        
					} else { 
                       // $this->session->data['warning_error'] = ''.ucfirst($ext).' Not Imported! <br> File Header Not Set Proper or Missing some Column on '.ucfirst($ext).' or Speling mismatch on '.$ext.' Header section as per Setting Tab. <br> Better to Export First to View Exact File Format!';	
                        $data['warning_error'] = 'The File '.ucfirst($ext).' you have imported has exceeded the maximum size, please make sure that your file is not more than 5MB';
					}
                } 
            } else  {
                $this->session->data['warning_error'] = 'Please Select the file to Import';
            }
            //var_dump($data['warning_error']);die;
            //$this->response->redirect($this->url->link('catalog/price/importCSV', 'token=' . $this->session->data['token'] . $url, 'SSL'));
                  		
		}
        // $this->load->model('catalog/contract');
        $data['contracts'] = $this->model_catalog_price->getCustomerGroups();
        $data['header']         = $this->load->controller('common/header');
        $data['column_left']    = $this->load->controller('common/column_left');
        $data['footer']         = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('catalog/import_csv.tpl', $data));
    }

    public function download() {
        $this->load->language('catalog/price');
        $data['heading_title']  = $this->language->get('heading_title');
        $this->load->model('catalog/price');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
					//die('test me');
					// $min = null;
					// if (isset( $this->request->post['min'] ) && ($this->request->post['min']!='')) {
					// 	$min = $this->request->post['min'];
					// }
					// $max = null;
					// if (isset( $this->request->post['max'] ) && ($this->request->post['max']!='')) {
					// 	$max = $this->request->post['max'];
					// }
					
					// if (($min==null) || ($max==null)) {
					// 	$this->model_catalog_price->downloadCsv();
					// } elseif(($min!=null) || ($max!=null)) {
					// 	$this->model_catalog_price->downloadCsv($min, $max);
                    // }
                    $this->model_catalog_price->downloadCsv($min, $max);
					
			}
			//$this->response->redirect( $this->url->link( 'customer/customer_export_import', 'token='.$this->request->get['token'], $this->ssl) );
		
		$this->getForm();
	}

    public function exportCSV(){
        $this->load->language('catalog/price');
        $this->load->model('catalog/price');
        $data['heading_title']  = $this->language->get('heading_title');
        $data['text_export']  = $this->language->get('text_export');
        $data['text_import']  = $this->language->get('text_import');
        $data['back'] = $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL');
        // cancel url
        $data['action'] = $this->url->link('catalog/price/exportCSV', 'token=' . $this->session->data['token'] . $url, 'SSL');
        // current page url
        // Breadcrumbs start here
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array('text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'), 'separator' => false);
        //home page link
        
        $data['breadcrumbs'][] = array('text' =>$this->language->get('column_contract'),
            'href' => $this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL'), 'separator' => ' :: ');
            $data['breadcrumbs'][] = array('text' =>$this->language->get('text_export'),
            'href' => $this->url->link('catalog/price/exportCSV', 'token=' . $this->session->data['token'] . $url, 'SSL'), 'separator' => ' :: ');
        
            // breadcrumbs end here
        if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
            
           // $this->model_catalog_price->exportCsvData(); 
            //$this->session->data['success'] = 'CSV Successfully exported!';
           // $this->response->redirect($this->url->link('catalog/price', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
       // $this->load->model('catalog/contract');
        $data['export'] = $this->url->link('catalog/price/download', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $data['tab_export']         = "Export";
        $data['entry_export']       = $this->language->get( 'entry_export' );
		$data['entry_import']       = $this->language->get( 'entry_import' );
		$data['entry_export_type']  = $this->language->get( 'entry_export_type' );
		$data['entry_range_type']   = $this->language->get( 'entry_range_type' );
        $data['entry_start_id']     = $this->language->get( 'entry_start_id' );
        $data['help_range_type']    = $this->language->get( 'help_range_type' );
        $data['button_export']      = $this->language->get( 'button_export' );
        $data['contracts']          = $this->model_catalog_price->getCustomerGroups();
        $data['header']             = $this->load->controller('common/header');
        $data['column_left']        = $this->load->controller('common/column_left');
        $data['footer']             = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('catalog/export_csv.tpl', $data));
    }
}