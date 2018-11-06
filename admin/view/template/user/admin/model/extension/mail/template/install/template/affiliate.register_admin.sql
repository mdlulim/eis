INSERT INTO `oc_emailtemplate` SET
`emailtemplate_key` = 'affiliate.register_admin',
`emailtemplate_label` = 'Affiliate Register Admin',
`emailtemplate_type` = 'admin',
`emailtemplate_template` = '',
`emailtemplate_mail_to` = '{$store_email}',
`emailtemplate_mail_cc` = '',
`emailtemplate_mail_bcc` = '',
`emailtemplate_mail_from` = '{$email}',
`emailtemplate_mail_html` = 1,
`emailtemplate_mail_plain_text` = 0,
`emailtemplate_mail_sender` = '{$firstname} {$lastname}',
`emailtemplate_mail_replyto` = '',
`emailtemplate_mail_replyto_name` = '',
`emailtemplate_mail_attachment` = '',
`emailtemplate_attach_invoice` = 0,
`emailtemplate_language_files` = 'extension/mail/affiliate',
`emailtemplate_wrapper_tpl` = '',
`emailtemplate_status` = 1,
`emailtemplate_default` = 1,
`emailtemplate_shortcodes` = 0,
`emailtemplate_showcase` = 0,
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
`emailtemplate_description_subject` = '',
`emailtemplate_description_preview` = '',
`emailtemplate_description_content1` = '&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; style=&quot;width:auto;&quot;&gt;	&lt;tbody&gt;		&lt;tr&gt;			&lt;td width=&quot;2&quot;&gt; &lt;/td&gt;			&lt;td class=&quot;heading2&quot;&gt;&lt;strong&gt;{$text_signup}&lt;/strong&gt;&lt;/td&gt;		&lt;/tr&gt;		&lt;tr&gt;			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;3&quot; width=&quot;2&quot;&gt; &lt;/td&gt;			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;3&quot;&gt; &lt;/td&gt;		&lt;/tr&gt;		&lt;tr&gt;			&lt;td style=&quot;font-size:1px; line-height:0;&quot; bgcolor=&quot;#cccccc&quot; height=&quot;1&quot; width=&quot;2&quot;&gt; &lt;/td&gt;			&lt;td style=&quot;font-size:1px; line-height:0;&quot; bgcolor=&quot;#cccccc&quot; height=&quot;1&quot;&gt; &lt;/td&gt;		&lt;/tr&gt;		&lt;tr&gt;			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;15&quot; width=&quot;2&quot;&gt; &lt;/td&gt;			&lt;td style=&quot;font-size:1px; line-height:0;&quot; height=&quot;15&quot;&gt; &lt;/td&gt;		&lt;/tr&gt;	&lt;/tbody&gt;&lt;/table&gt;&lt;p&gt;&lt;strong&gt;{$text_name}&lt;/strong&gt; {$firstname} {$lastname}&lt;br&gt;&lt;br&gt;&lt;strong&gt;{$text_email}&lt;/strong&gt; &lt;a href=&quot;mailto:{$email}&quot;&gt;{$email}&lt;/a&gt;&lt;br&gt;&lt;br&gt;&lt;strong&gt;{$text_company}&lt;/strong&gt; {$company}&lt;br&gt;&lt;br&gt;&lt;strong&gt;{$text_telephone}&lt;/strong&gt; {$telephone}&lt;br&gt;&lt;br&gt;&lt;strong&gt;{$text_fax}&lt;/strong&gt; {$fax}&lt;/p&gt;',
`emailtemplate_description_content2` = '',
`emailtemplate_description_content3` = '',
`emailtemplate_description_comment` = '',
`emailtemplate_description_unsubscribe_text` = '';