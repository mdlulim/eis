<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?php echo $title; ?></title>

  <style type="text/css">

    @import url('https://fonts.googleapis.com/css?family=Titillium+Web:200,200i,300,300i,400,400i,600,600i,700,700i,900&subset=latin-ext');
    
    /* Outlines the grids, remove when sending */
    /*table td { border: 1px solid cyan; }*/

    /* CLIENT-SPECIFIC STYLES */
    body, table, td, a {
      -webkit-text-size-adjust: 100%; 
      -ms-text-size-adjust: 100%; 
      font-family: 'Titillium Web', sans-serif;
      font-size: 15px;
      font-weight: 300;
      line-height: 1.5em;
    }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    img { -ms-interpolation-mode: bicubic; }

    /* RESET STYLES */
    img { border: 0; outline: none; text-decoration: none; }
    table { border-collapse: collapse !important; }
    body { margin: 0 !important; padding: 0 !important; width: 100% !important; }

    h1,h2,h3,h4,h5,h6 {font-weight:normal;}
    h1 {font-size:2.65em;}
    h3 {font-size:1.5em;}
    h4 {font-size:1.25em;}

    /* iOS BLUE LINKS */
    a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] { margin: 0 !important; }

    /* MEDIA QUERIES */
    @media all and (max-width:639px){
      .wrapper{ width:320px!important; padding: 0 !important; }
      .container{ width:300px!important;  padding: 0 !important; }
      .mobile{ width:300px!important; display:block!important; padding: 0 !important; }
      .img{ width:100% !important; height:auto !important; }
      *[class="mobileOff"] { width: 0px !important; display: none !important; }
      *[class*="mobileOn"] { display: block !important; max-height:none !important; }
    }

  </style>    
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">
<div style="width: 680px;"><a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" style="margin-bottom: 20px; border: none;" /></a>
  <!--p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_greeting; ?></p-->
  <?php if ($customer_id) { ?>
  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_link; ?></p>
  <p style="margin-top: 0px; margin-bottom: 20px;"><a href="<?php echo $link; ?>"><?php echo $link; ?></a></p>
  <?php } ?>
  <?php if ($download) { ?>
  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_download; ?></p>
  <p style="margin-top: 0px; margin-bottom: 20px;"><a href="<?php echo $download; ?>"><?php echo $download; ?></a></p>
  <?php } ?>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td align="center" valign="top">

          <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper">
            <tr>
              <td align="center" valign="top">

                <table cellpadding="0" cellspacing="0" border="0" width="600" bgcolor="#FFFFFF">
                  <tr>
                    <td valign="top" align="center">
            
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="top">

                            <table width="560" cellpadding="0" cellspacing="0" border="0" class="container">
                              <tr>
                                <td align="center" valign="top">
                                  <h1>Online Order</h1>
                                  <p><strong>Order #<?php echo $order_id; ?></strong></p>
                                  <h4 style="color:#777777; font-weight:300;">
                                    for <?php echo $cust_name; ?><br>
                                    placed on <?php echo $order_date; ?>
                                  </h4>
                                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr><th align="center"><?php echo $store_name; ?></th></tr>
                                    <tr><td align="center"><?php echo $company_address; ?></th></tr>
                                  </table>
                                </td>
                              </tr>
                            </table>

                          </td>
                        </tr>
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                      </table>

                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="top">
                            <img src="https://uat.saleslogic.io/emails/wholesale/images/order-email-divider.png" border="0" style="width:100%"/>
                          </td>
                        </tr>
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                      </table>

                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="top">

                            <table width="560" cellpadding="0" cellspacing="0" border="0" class="container">
                              <tr>
                                <td align="center" valign="top">
                                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr><td>Dear Valued Client,</td></tr>
                                    <tr>
                                      <td height="25" style="font-size:25px; line-height:25px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td>
                                          The order with a value of <?php echo $order_total; ?> has been successfully received. The order was submitted via our online portal. Your order reference number is <strong>#<?php echo $order_id; ?></strong>.
                                      </td>
                                    </tr>
                                    <tr>
                                      <td height="25" style="font-size:25px; line-height:25px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td>
                                        A copy of this order has been attached to the email for your records. You can also view your order online at: <a href="<?php echo $order_url; ?>" target="_blank" style="color:#3E83B1;text-decoration:none;"><?php echo $order_url; ?></a>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td height="25" style="font-size:25px; line-height:25px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td>
                                        Yours Sincerely,
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <?php echo $store_name; ?>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>

                          </td>
                        </tr>
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                      </table>

                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="top">
                            <hr style="border-top:1px solid #E9E9EA;"/>
                          </td>
                        </tr>
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                      </table>

                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="top">

                            <table width="560" cellpadding="0" cellspacing="0" border="0" class="container">
                              <tr>
                                <td align="center" valign="top">
                                  <h3 style="padding:0;margin:0">Order Amount: <strong><?php echo $order_total; ?></strong></h3>
                                </td>
                              </tr>
                            </table>

                          </td>
                        </tr>
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                      </table>

                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="top">
                            <hr style="border-top:1px solid #E9E9EA;"/>
                          </td>
                        </tr>
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                      </table>

                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td height="30" style="font-size:30px; line-height:30px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="top">

                            <table width="560" cellpadding="0" cellspacing="0" border="0" class="container">
                              <tr>
                                <td align="center" valign="top">
                                  <a href="<?php echo $order_url; ?>" target="_blank">
                                      <img src="https://uat.saleslogic.io/emails/wholesale/images/view-order-button.png" width="220" height="40" border="0"/>
                                  </a>
                                </td>
                              </tr>
                            </table>

                          </td>
                        </tr>
                        <tr>
                          <td height="40" style="font-size:40px; line-height:40px;">&nbsp;</td>
                        </tr>
                      </table>

                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

          <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#F2F2F2">
            <tr>
              <td height="20" style="font-size:10px; line-height:10px;">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="top">

                <table width="560" cellpadding="0" cellspacing="0" border="0" class="container">
                  <tr>
                    <td align="center" valign="top" style="font-size:0.9em">
                      Thank you for your business. This order was generated using <span style="color:#3E83B1;">Saleslogic</span>. If this order was sent in error, please contact <a href="<?php echo $support_email; ?>" style="color:#3E83B1;text-decoration:none;"><?php echo $support_email; ?></a>
                    </td>
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
            </tr>
          </table>

        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?><br />
          <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
          <!-- b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
          <?php if ($shipping_method) { ?>
          <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?> -->
          <?php } ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b><?php echo $text_email; ?></b> <?php echo $email; ?><br />
          <b><?php echo $text_telephone; ?></b> <?php echo $telephone; ?><br />
          <b><?php echo $text_ip; ?></b> <?php echo $ip; ?><br />
          <b><?php echo $text_order_status; ?></b> <?php echo $order_status; ?><br /></td>
      </tr>
    </tbody>
  </table>
  <?php if ($comment) { ?>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_instruction; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $comment; ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
  <!--table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_shipping_address; ?></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $shipping_address; ?></td>
        <?php } ?>
      </tr>
    </tbody>
  </table-->
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_product; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_model; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_quantity; ?></td>
        <?php if (!$this->config->get('config_hide_price')) { ?>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_price; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_total; ?></td>
      <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $product['name']; ?>
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $product['model']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $product['quantity']; ?></td>
       <?php if (!$this->config->get('config_hide_price')) { ?>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo (!$this->config->get('config_hide_price')) ? $product['price'] : ''; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $product['total']; ?></td>
        <?php } ?>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $voucher['description']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">1</td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $voucher['amount']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $voucher['amount']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <?php if (!$this->config->get('config_hide_price')) { ?>
    <tfoot>
      
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4"><b><?php echo $total['title']; ?>:</b></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </tfoot>
    <?php } ?>
  </table>
  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_footer; ?></p>
</div>
</body>
</html>