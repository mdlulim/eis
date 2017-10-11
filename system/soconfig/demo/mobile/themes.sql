

INSERT INTO {table_prefix}layout VALUES
(32, 'Mobile - Home 1 ');

INSERT INTO {table_prefix}layout_route VALUES
(null,"32","0","mobile/home");

INSERT INTO {table_prefix}layout_module VALUES
(null,"32","so_page_builder.24","content_mobile","1"),
(null,"32","so_page_builder.25","content_mobile","2"),
(null,"32","so_page_builder.26","content_mobile","3");

INSERT INTO {table_prefix}setting VALUES
(null,"0","so_mobile","mobile_general","{\"mobilelayout\":\"0\",\"nameColor\":\"blue\",\"colorHex\":\"#ff5e00\",\"listcolor\":\"blue\",\"platforms_mobile\":\"1\",\"logomobile\":\"\",\"barnav\":\"1\",\"copyright\":\"Copyright \\u00a9 2017 by &lt;a href=&quot;http:\\/\\/www.opencartworks.com\\/&quot; target=&quot;_blank&quot;  title=&quot;OpenCartWorks&quot;&gt;OpenCartWorks.com&lt;\\/a&gt;. All Rights Reserved.\",\"mobileheader\":\"0\",\"imgpayment\":\"catalog\\/demo\\/payment\\/payment_method_mob.png\",\"phone_status\":\"1\",\"phone_text\":\"12345678\",\"email_status\":\"1\",\"email_text\":\"Support@revo.com\",\"customfooter_status\":\"1\",\"customfooter_text\":\"&lt;p&gt;&lt;a href=&quot;javascript:void(0);&quot;&gt;FIND US ON&lt;\\/a&gt;&lt;\\/p&gt;\\r\\n&lt;ul class=&quot;list-inline&quot;&gt;\\r\\n\\t&lt;li&gt;&lt;a href=&quot;https:\\/\\/www.facebook.com\\/MagenTech\\/&quot; target=&quot;_blank&quot;&gt; &lt;i class=&quot;fa fa-facebook social-icon&quot;&gt;&lt;\\/i&gt;&lt;\\/a&gt;&lt;\\/li&gt;\\r\\n\\t&lt;li&gt;&lt;a href=&quot;https:\\/\\/twitter.com\\/magentech&quot; target=&quot;_blank&quot;&gt; &lt;i class=&quot;fa fa-twitter social-icon&quot;&gt;&lt;\\/i&gt;&lt;\\/a&gt;&lt;\\/li&gt;\\r\\n\\t&lt;li&gt;&lt;a href=&quot;https:\\/\\/plus.google.com\\/+Magentech-responsive-magento-theme&quot; target=&quot;_blank&quot;&gt; &lt;i class=&quot;fa fa-google-plus social-icon&quot;&gt;&lt;\\/i&gt;&lt;\\/a&gt;&lt;\\/li&gt;\\r\\n&lt;\\/ul&gt;\\t\",\"menufooter_status\":\"1\",\"footermenus\":[{\"name\":\"Gift Certificates\",\"link\":\"index.php?route=account\\/voucher\",\"sort\":\"1\"},{\"name\":\"Wishlist\",\"link\":\"index.php?route=account\\/wishlist\",\"sort\":\"2\"},{\"name\":\"Affiliate\",\"link\":\"index.php?route=affiliate\\/login\",\"sort\":\"3\"},{\"name\":\"Special\",\"link\":\"index.php?route=product\\/special\",\"sort\":\"4\"},{\"name\":\"Manufacturer\",\"link\":\"?route=product\\/manufacturer\",\"sort\":\"5\"},{\"name\":\"About Us\",\"link\":\"index.php?route=information\\/information&amp;information_id=4\",\"sort\":\"6\"},{\"name\":\"Blogs\",\"link\":\"index.php?route=simple_blog\\/article\",\"sort\":\"7\"},{\"name\":\"Contact\",\"link\":\"index.php?route=information\\/contact\",\"sort\":\"\"},{\"name\":\"Site Map\",\"link\":\"index.php?route=information\\/sitemap\",\"sort\":\"\"},{\"name\":\"Order History\",\"link\":\"index.php?route=account\\/order\",\"sort\":\"\"}],\"barmore_status\":\"1\",\"listmenus\":[{\"name\":\"Home\",\"link\":\"http:\\/\\/dev.ytcvn.com\\/ytc_templates\\/opencart\\/so23_revo\",\"sort\":\"1\"},{\"name\":\"Home 2\",\"link\":\"http:\\/\\/dev.ytcvn.com\\/ytc_templates\\/opencart\\/so23_revo\\/layout2\\/\",\"sort\":\"2\"},{\"name\":\"Home 3\",\"link\":\"http:\\/\\/dev.ytcvn.com\\/ytc_templates\\/opencart\\/so23_revo\\/layout3\",\"sort\":\"3\"}],\"barsearch_status\":\"1\",\"barwistlist_status\":\"1\",\"barcompare_status\":\"1\",\"barcurenty_status\":\"1\",\"barlanguage_status\":\"1\",\"category_more\":\"1\",\"compare_status\":\"1\",\"wishlist_status\":\"1\",\"addcart_status\":\"1\",\"body_status\":\"google\",\"normal_body\":\"inherit\",\"url_body\":\"https:\\/\\/fonts.googleapis.com\\/css?family=Open+Sans:400,600,700\",\"family_body\":\"Open Sans, sans-serif;\",\"selector_body\":\"body\",\"heading_status\":\"google\",\"normal_heading\":\"inherit\",\"url_heading\":\"https:\\/\\/fonts.googleapis.com\\/css?family=Raleway:600,700\",\"family_heading\":\"Raleway, sans-serif;\",\"selector_heading\":\".font-ct, h1, h2, h3, .static-menu a.main-menu, .container-megamenu.vertical .vertical-wrapper ul li &gt; a strong, .container-megamenu.vertical .vertical-wrapper ul.megamenu li .sub-menu .content .static-menu .menu ul li a.main-menu, .horizontal ul.megamenu &gt; li &gt; a, .footertitle, .module h3.modtitle span, .breadcrumb li a,  .right-block .caption, .item-title a, .best-seller-custom .item-info, .product-box-desc, .product_page_price .price-new, .list-group-item a\",\"scsscompile\":\"0\",\"scssformat\":\"Expanded\",\"compilemuticolor\":\"0\"}","1");

INSERT INTO {table_prefix}modification VALUES
(null, 'So Mobile', 'so_mobile', 'OpenCartWorks', '1.0.0', 'http://www.opencartworks.com/', '<?xml version="1.0" encoding="utf-8"?>\r\n<modification>\r\n	<name><![CDATA[So Mobile]]></name>\r\n	<code>so-mobile</code>\r\n    <version><![CDATA[1.0.0]]></version>\r\n    <author><![CDATA[OpenCartWorks]]></author>\r\n	<link>http://www.opencartworks.com/</link>\r\n	<!--Catalog/controller/common-->\r\n	<file path="catalog/controller/common/home.php">\r\n		<operation  >\r\n			<search ><![CDATA[$data[''header''] = $this->load->controller(''common/header'');]]></search>\r\n			<add position="before"><![CDATA[\r\n				$data[''mobile''] = $this->config->get(''mobile_general'');\r\n		]]></add>\r\n		</operation>\r\n		<operation  >\r\n	<search ><![CDATA[$this->response->setOutput($this->load->view(''common/home'', $data));]]></search>\r\n	    <add position="replace"><![CDATA[\r\n		     if($this->session->data[''device'']==''mobile'' && $data[''mobile''][''platforms_mobile''])$this->response->redirect($this->url->link(''mobile/home''));\r\n		    else $this->response->setOutput($this->load->view(''common/home'', $data));\r\n        ]]></add>\r\n   </operation>\r\n	</file>\r\n	\r\n	<file path="catalog/controller/common/header.php">\r\n		<operation  >\r\n			<search ><![CDATA[$data[''language''] = $this->load->controller(''common/language'')]]></search>\r\n			<add position="before"><![CDATA[\r\n				$this->load->language(''extension/soconfig/mobile'');\r\n				$data[''objlang''] = $this->language;\r\n				$data[''menu_search''] = $this->url->link(''product/search'', '''', true);\r\n				$data[''mobile''] = $this->config->get(''mobile_general'');\r\n				$data[''text_items''] = sprintf($this->language->get(''text_itemcount''), $this->cart->countProducts() + (isset($this->session->data[''vouchers'']) ? count($this->session->data[''vouchers'']) : 0));\r\n				if($this->session->data[''device'']==''mobile''){\r\n					$data[''home''] = $this->url->link(''mobile/home'');\r\n				}else{\r\n					$data[''home''] = $this->url->link(''common/home'');\r\n				}\r\n				if(isset($this->request->get[''layoutmobile''])) $data[''layoutmobile''] = $this->request->get[''layoutmobile''];\r\n		]]></add>\r\n		</operation>\r\n	</file>\r\n	\r\n	<file path="catalog/controller/common/footer.php">\r\n		<operation>\r\n			<search ><![CDATA[return $this->load->view(''common/footer'', $data); ]]></search>\r\n			<add position="before"><![CDATA[\r\n				// Menu Mobile\r\n				$this->load->model(''catalog/category'');\r\n				$this->load->model(''catalog/product'');\r\n				$this->load->language(''extension/soconfig/mobile'');\r\n				$data[''objlang''] = $this->language;\r\n				$data[''categories''] = array();\r\n				$data[''mobile''] = $this->config->get(''mobile_general'');\r\n				$data[''text_account''] = $this->language->get(''text_account'');\r\n				$data[''text_register''] = $this->language->get(''text_register'');\r\n				$data[''text_login''] = $this->language->get(''text_login'');\r\n				\r\n				$categories = $this->model_catalog_category->getCategories(0);\r\n				\r\n				\r\n				foreach ($categories as $category) {\r\n					if ($category[''top'']) {\r\n						// Level 2\r\n						$children_data = array();\r\n\r\n						$children = $this->model_catalog_category->getCategories($category[''category_id'']);\r\n\r\n						foreach ($children as $child) {\r\n							$filter_data = array(\r\n								''filter_category_id''  => $child[''category_id''],\r\n								''filter_sub_category'' => true\r\n							);\r\n\r\n							$children_data[] = array(\r\n								''name''  => $child[''name''] . ($this->config->get(''config_product_count'') ? '' ('' . $this->model_catalog_product->getTotalProducts($filter_data) . '')'' : ''''),\r\n								''href''  => $this->url->link(''product/category'', ''path='' . $category[''category_id''] . ''_'' . $child[''category_id''])\r\n							);\r\n						}\r\n\r\n						// Level 1\r\n						$data[''categories''][] = array(\r\n							''name''     => $category[''name''],\r\n							''children'' => $children_data,\r\n							''column''   => $category[''column''] ? $category[''column''] : 1,\r\n							''href''     => $this->url->link(''product/category'', ''path='' . $category[''category_id''])\r\n						);\r\n					}\r\n				}\r\n\r\n				$data[''language''] = $this->load->controller(''common/language'');\r\n				$data[''currency''] = $this->load->controller(''common/currency'');\r\n				$data[''search''] = $this->load->controller(''common/search'');\r\n				$data[''cart''] = $this->load->controller(''common/cart'');\r\n				$data[''wishlist''] = $this->url->link(''account/wishlist'', '''', true);\r\n				$data[''compare''] = $this->url->link(''product/compare'', '''', ''SSL'');\r\n				$data[''text_compare'']  = sprintf($this->language->get(''text_compare''),(isset($this->session->data[''compare'']) ? count($this->session->data[''compare'']) : 0));\r\n				$data[''logged''] = $this->customer->isLogged();\r\n				$data[''account''] = $this->url->link(''account/account'', '''', true);\r\n				$data[''register''] = $this->url->link(''account/register'', '''', true);\r\n				$data[''login''] = $this->url->link(''account/login'', '''', true);\r\n				\r\n			\r\n			]]></add>\r\n		</operation>\r\n		\r\n	</file>\r\n	<!--End Catalog/controller/common-->\r\n	\r\n	<!--Catalog/controller/product-->\r\n	<file path="catalog/controller/product/category.php">\r\n		<operation>\r\n			<search ><![CDATA[$data[''heading_title''] = $category_info[''name'']]]></search>\r\n			<add position="before"><![CDATA[$data[''mobile''] = $this->config->get(''mobile_general'');]]></add>\r\n		</operation>\r\n	</file>\r\n	<file path="catalog/controller/product/{search,special,manufacturer}*.php">\r\n		<operation>\r\n			<search ><![CDATA[$this->load->model(''tool/image'')]]></search>\r\n			<add position="after"><![CDATA[$data[''mobile''] = $this->config->get(''mobile_general'');]]></add>\r\n		</operation> \r\n      \r\n    </file>\r\n	<file path="catalog/controller/product/product.php">\r\n		<operation error="skip">\r\n			<search ><![CDATA[$this->document->addScript(''catalog/view/javascript/jquery/datetimepicker/moment.js'');]]></search>\r\n			<add position="before"><![CDATA[\r\n			if($this->session->data[''device'']==''mobile''){\r\n				$this->document->addStyle(''catalog/view/javascript/soconfig/css/mobile/slick.css'');\r\n				$this->document->addScript(''catalog/view/javascript/soconfig/js/mobile/slick.min.js'');\r\n			}\r\n			]]></add>\r\n		</operation>\r\n	</file>\r\n	<!--End Catalog/controller/product-->\r\n	<file path="catalog/controller/extension/module/so_filter_shop_by.php">\r\n       <operation>\r\n            <search><![CDATA[$footer 			= '''';]]></search>\r\n            <add position="after"><![CDATA[$mobile = $this->config->get(''mobile_general'');\r\n			$objlang = $this->language;\r\n            ]]></add>\r\n        </operation>\r\n	</file>\r\n</modification>', 1, '2017-02-16 17:27:40');

