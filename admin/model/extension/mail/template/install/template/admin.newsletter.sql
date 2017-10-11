INSERT INTO `oc_emailtemplate` SET
`emailtemplate_key` = 'admin.newsletter',
`emailtemplate_label` = 'Newsletter',
`emailtemplate_type` = 'admin',
`emailtemplate_template` = '',
`emailtemplate_mail_to` = '{$email}',
`emailtemplate_mail_cc` = '',
`emailtemplate_mail_bcc` = '',
`emailtemplate_mail_from` = '{$store_email}',
`emailtemplate_mail_html` = 1,
`emailtemplate_mail_plain_text` = 1,
`emailtemplate_mail_sender` = '{$store_name}',
`emailtemplate_mail_replyto` = '',
`emailtemplate_mail_replyto_name` = '',
`emailtemplate_mail_attachment` = '',
`emailtemplate_attach_invoice` = 0,
`emailtemplate_language_files` = '',
`emailtemplate_wrapper_tpl` = '',
`emailtemplate_status` = 1,
`emailtemplate_default` = 1,
`emailtemplate_shortcodes` = 0,
`emailtemplate_showcase` = 0,
`emailtemplate_condition` = '',
`emailtemplate_modified` = NOW(),
`emailtemplate_log` = 1,
`emailtemplate_view_browser` = 1,
`emailtemplate_config_id` = 0,
`store_id` = NULL,
`customer_group_id` = 0,
`order_status_id` = 0,
`event_id` = '';

INSERT INTO `oc_emailtemplate_description` SET 
`emailtemplate_id` = {_ID},
`language_id` = 0,
`emailtemplate_description_subject` = '{$store_name}',
`emailtemplate_description_preview` = '{$store_name}',
`emailtemplate_description_content1` = '',
`emailtemplate_description_content2` = '',
`emailtemplate_description_content3` = '',
`emailtemplate_description_comment` = '&lt;p&gt;Hi  {$firstname},&lt;br&gt;&lt;/p&gt;',
`emailtemplate_description_unsubscribe_text` = '&lt;a href=&quot;%s&quot;&gt;Unsubscribe&lt;/a&gt;';