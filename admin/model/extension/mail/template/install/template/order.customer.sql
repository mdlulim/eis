INSERT INTO `oc_emailtemplate` SET
`emailtemplate_key` = 'order.customer',
`emailtemplate_label` = 'Order Confirm - Customer',
`emailtemplate_type` = 'order',
`emailtemplate_template` = 'order_customer.tpl',
`emailtemplate_mail_to` = '',
`emailtemplate_mail_cc` = '',
`emailtemplate_mail_bcc` = '',
`emailtemplate_mail_from` = '',
`emailtemplate_mail_html` = 1,
`emailtemplate_mail_plain_text` = 0,
`emailtemplate_mail_sender` = '',
`emailtemplate_mail_replyto` = '',
`emailtemplate_mail_replyto_name` = '',
`emailtemplate_mail_attachment` = '',
`emailtemplate_attach_invoice` = 0,
`emailtemplate_language_files` = 'extension/mail/order',
`emailtemplate_wrapper_tpl` = '',
`emailtemplate_status` = 1,
`emailtemplate_default` = 1,
`emailtemplate_shortcodes` = 0,
`emailtemplate_showcase` = 1,
`emailtemplate_condition` = '',
`emailtemplate_modified` = NOW(),
`emailtemplate_log` = 0,
`emailtemplate_view_browser` = 0,
`emailtemplate_config_id` = 0,
`store_id` = NULL,
`customer_group_id` = 0,
`order_status_id` = 0,
`event_id` = '';

INSERT INTO `oc_emailtemplate_description` SET 
`emailtemplate_id` = {_ID},
`language_id` = 0,
`emailtemplate_description_subject` = '{$text_new_subject_customer}',
`emailtemplate_description_preview` = '{$text_new_preheader}',
`emailtemplate_description_content1` = '&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; style=&quot;width:auto;&quot;&gt;\r\n	&lt;tbody&gt;\r\n		&lt;tr&gt;\r\n			&lt;td width=&quot;2&quot;&gt; &lt;/td&gt;\r\n			&lt;td class=&quot;heading2&quot;&gt;&lt;strong&gt;{$text_new_heading}&lt;/strong&gt;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;3&quot; width=&quot;2&quot;&gt; &lt;/td&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;3&quot;&gt; &lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; bgcolor=&quot;#cccccc&quot; height=&quot;1&quot; width=&quot;2&quot;&gt; &lt;/td&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; bgcolor=&quot;#cccccc&quot; height=&quot;1&quot;&gt; &lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;15&quot; width=&quot;2&quot;&gt; &lt;/td&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;15&quot;&gt; &lt;/td&gt;\r\n		&lt;/tr&gt;\r\n	&lt;/tbody&gt;\r\n&lt;/table&gt;\r\n{$text_greeting}',
`emailtemplate_description_content2` = '&lt;table class=&quot;tableInfo tableStack&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;100%&quot;&gt;\r\n	&lt;tbody&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;\r\n				&lt;table align=&quot;left&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;33%&quot; style=&quot;width:33%&quot;&gt;\r\n					&lt;thead&gt;\r\n						&lt;tr&gt;\r\n							&lt;th style=&quot;font-size:14px;border-bottom: 1px solid #cccccc;padding: 8px 0 5px 0;&quot;&gt;{$text_order_detail}&lt;/th&gt;\r\n						&lt;/tr&gt;\r\n					&lt;/thead&gt;\r\n					&lt;tbody&gt;\r\n						&lt;tr&gt;\r\n							&lt;td style=&quot;padding:5px 0 0&quot;&gt;\r\n								&lt;table align=&quot;left&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; style=&quot;width:auto;&quot;&gt;\r\n									&lt;tbody&gt;&lt;tr&gt;\r\n										&lt;td style=&quot;font-size:13px;padding:1px 0&quot;&gt;&lt;b style=&quot;font-size:0.9em&quot;&gt;{$text_order_id}&lt;/b&gt;&lt;/td&gt;\r\n										&lt;td style=&quot;font-size:13px;padding:1px 0 1px 6px&quot;&gt;{$order_id}&lt;/td&gt;\r\n									&lt;/tr&gt;\r\n									&lt;tr&gt;\r\n										&lt;td style=&quot;font-size:13px;padding:1px 0&quot;&gt;&lt;b style=&quot;font-size:0.9em&quot;&gt;{$text_date_added}&lt;/b&gt;&lt;/td&gt;\r\n										&lt;td style=&quot;font-size:13px;padding:1px 0 1px 6px&quot;&gt;{$date_added}&lt;/td&gt;\r\n									&lt;/tr&gt;\r\n									&lt;tr&gt;\r\n										&lt;td style=&quot;font-size:13px;padding:1px 0&quot;&gt;&lt;b style=&quot;font-size:0.9em&quot;&gt;{$text_order_status}&lt;/b&gt;&lt;/td&gt;\r\n										&lt;td style=&quot;font-size:13px;padding:1px 0 1px 6px&quot;&gt;{$new_order_status}&lt;/td&gt;\r\n									&lt;/tr&gt;\r\n									&lt;tr&gt;\r\n										&lt;td style=&quot;font-size:13px;padding:1px 0&quot;&gt;&lt;b style=&quot;font-size:0.9em&quot;&gt;{$text_payment_method}&lt;/b&gt;&lt;/td&gt;\r\n										&lt;td style=&quot;font-size:13px;padding:1px 0 1px 6px&quot;&gt;{$payment_method}&lt;/td&gt;\r\n									&lt;/tr&gt;\r\n									&lt;tr&gt;\r\n										&lt;td style=&quot;font-size:13px;padding:1px 0&quot;&gt;&lt;b style=&quot;font-size:0.9em&quot;&gt;{$text_shipping_method}&lt;/b&gt;&lt;/td&gt;\r\n										&lt;td style=&quot;font-size:13px;padding:1px 0 1px 6px&quot;&gt;{$shipping_method}&lt;/td&gt;\r\n									&lt;/tr&gt;\r\n								&lt;/tbody&gt;&lt;/table&gt;\r\n							&lt;/td&gt;\r\n						&lt;/tr&gt;\r\n					&lt;/tbody&gt;\r\n				&lt;/table&gt;\r\n				&lt;table align=&quot;left&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;33%&quot; style=&quot;width:33%&quot;&gt;\r\n					&lt;thead&gt;\r\n						&lt;tr&gt;\r\n							&lt;th style=&quot;width:10px;padding: 8px 0 5px 0;&quot;&gt;&amp;nbsp;&lt;/th&gt;\r\n							&lt;th style=&quot;font-size:14px;border-bottom: 1px solid #cccccc;padding: 8px 0 5px 0;&quot;&gt;{$text_payment_address}&lt;/th&gt;\r\n						&lt;/tr&gt;\r\n					&lt;/thead&gt;\r\n					&lt;tbody&gt;\r\n						&lt;tr&gt;\r\n							&lt;td style=&quot;width:10px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n							&lt;td style=&quot;font-size:13px;padding:8px 0 3px;&quot;&gt;{$payment_address}&lt;/td&gt;\r\n						&lt;/tr&gt;\r\n					&lt;/tbody&gt;\r\n				&lt;/table&gt;\r\n				&lt;table align=&quot;left&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; width=&quot;33%&quot; style=&quot;width:33%&quot;&gt;\r\n					&lt;thead&gt;\r\n						&lt;tr&gt;\r\n							&lt;th style=&quot;width:10px;padding: 8px 0 5px 0;&quot;&gt;&amp;nbsp;&lt;/th&gt;\r\n							&lt;th style=&quot;font-size:14px;border-bottom: 1px solid #cccccc;padding:8px 0 5px 0;&quot;&gt;{$text_shipping_address}&lt;/th&gt;\r\n						&lt;/tr&gt;\r\n					&lt;/thead&gt;\r\n					&lt;tbody&gt;\r\n						&lt;tr&gt;\r\n							&lt;td style=&quot;width:10px;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n							&lt;td style=&quot;font-size:13px;padding:8px 0 3px;&quot;&gt;{$shipping_address}&lt;/td&gt;\r\n						&lt;/tr&gt;\r\n					&lt;/tbody&gt;\r\n				&lt;/table&gt;\r\n			&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n	&lt;/tbody&gt;\r\n&lt;/table&gt;',
`emailtemplate_description_content3` = '&lt;div class=&quot;last&quot;&gt;{$text_new_footer}&lt;br&gt;\r\n&lt;b&gt;{$store_name}&lt;/b&gt;&lt;/div&gt;\r\n',
`emailtemplate_description_comment` = '',
`emailtemplate_description_unsubscribe_text` = '';