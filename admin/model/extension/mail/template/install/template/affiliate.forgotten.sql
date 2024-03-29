INSERT INTO `oc_emailtemplate` SET
`emailtemplate_key` = 'affiliate.forgotten',
`emailtemplate_label` = 'Affiliate Forgotten Password',
`emailtemplate_type` = 'affiliate',
`emailtemplate_template` = '',
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
`emailtemplate_language_files` = 'extension/mail/forgotten',
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
`emailtemplate_description_subject` = '{$text_affiliate_subject}',
`emailtemplate_description_preview` = '{$text_login}',
`emailtemplate_description_content1` = '&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; style=&quot;width:auto;&quot;&gt;\r\n	&lt;tbody&gt;\r\n		&lt;tr&gt;\r\n			&lt;td width=&quot;2&quot;&gt; &lt;/td&gt;\r\n			&lt;td class=&quot;heading2&quot;&gt;&lt;strong&gt;{$text_heading}&lt;/strong&gt;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;3&quot; width=&quot;2&quot;&gt; &lt;/td&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;3&quot;&gt; &lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; bgcolor=&quot;#cccccc&quot; height=&quot;1&quot; width=&quot;2&quot;&gt; &lt;/td&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; bgcolor=&quot;#cccccc&quot; height=&quot;1&quot;&gt; &lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;15&quot; width=&quot;2&quot;&gt; &lt;/td&gt;\r\n			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;15&quot;&gt; &lt;/td&gt;\r\n		&lt;/tr&gt;\r\n	&lt;/tbody&gt;\r\n&lt;/table&gt;\r\n\r\n&lt;div class=&quot;link&quot; style=&quot;padding-top:4px;padding-bottom:4px;&quot;&gt;{$text_login}&lt;br&gt;\r\n&lt;a href=&quot;{$account_login}&quot; target=&quot;_blank&quot;&gt;&lt;b&gt;{$account_login}&lt;/b&gt; &lt;/a&gt;&lt;br&gt;\r\n &lt;/div&gt;\r\n\r\n&lt;div class=&quot;last&quot;&gt;&lt;a href=&quot;{$store_url}&quot; target=&quot;_blank&quot;&gt;{$store_name}&lt;/a&gt;&lt;/div&gt;\r\n',
`emailtemplate_description_content2` = '',
`emailtemplate_description_content3` = '',
`emailtemplate_description_comment` = '',
`emailtemplate_description_unsubscribe_text` = '';