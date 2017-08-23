<?php if (!empty($customer_group['approval'])) { ?>
<table border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td width="2">&nbsp;</td>
			<td class="heading2"><strong><?php echo $text_customer_approve;?></strong></td>
		</tr>
		<tr>
			<td style="font-size:1px;line-height:3px" height="3" width="2">&nbsp;</td>
			<td style="font-size:1px;line-height:3px" height="3">&nbsp;</td>
		</tr>
		<tr>
			<td style="font-size:1px;line-height:1px" height="1" bgcolor="#DBDBDB" width="2">&nbsp;</td>
			<td style="font-size:1px;line-height:1px" height="1" bgcolor="#DBDBDB">&nbsp;</td>
		</tr>
		<tr>
			<td style="font-size:1px;line-height:15px" height="15" width="2">&nbsp;</td>
			<td style="font-size:1px;line-height:15px" height="15">&nbsp;</td>
		</tr>
	</tbody>
</table>
<?php } ?>

<div class="emailContent"><?php echo $emailtemplate['content1'];?></div>

<?php if (!empty($customer_group)) { ?>
<br />
<div>
<strong><?php echo $text_customer_group;?></strong> <?php echo $customer_group;?>
</div>
<?php } ?>

<?php if (!empty($customer_link)) { ?>
<br />
<div class="link" style="padding-top:4px;padding-bottom:4px;">
  <b><?php echo $text_customer_link;?></b><br /><a href="<?php echo $customer_link;?>" target="_blank"><b><?php echo $customer_link;?></b></a>
</div>
<?php } ?>

<?php if (isset($emailtemplate['content2'])) { ?>
<div class="emailContent"><?php echo $emailtemplate['content2'];?></div>
<?php } ?>