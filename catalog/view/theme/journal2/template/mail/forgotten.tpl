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
<body style="margin:0; padding:0; background-color:#EEEEEE;">
  
  <span style="display: block; width: 640px !important; max-width: 640px; height: 1px" class="mobileOff"></span>
  
  <center>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
      <tr>
        <td align="center" valign="top">

          <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#EEEEEE">
            <tr>
              <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="top">

                <table width="560" cellpadding="0" cellspacing="0" border="0" class="container">
                  <tr>
                    <td height="64" style="font-size:10px; line-height:10px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">
                      <img src="https://uat.saleslogic.io/emails/wholesale/images/Saleslogic_Wholesale.png" border="0" width="350"/>
                    </td>
                  </tr>
                  <tr>
                    <td height="42" style="font-size:10px; line-height:10px;">&nbsp;</td>
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
            </tr>
          </table>

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
                                  <h1><?php echo $text_heading; ?></h1>
                                </td>
                              </tr>
                            </table>

                          </td>
                        </tr>
                      </table>

                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="top">
                            <img src="https://uat.saleslogic.io/emails/wholesale/images/password-email-divider.png" border="0" style="width:100%"/>
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
                                    <tr>
                                      <td valign="top">
                                        <?php echo $text_greeting; ?><br/><br/>

                                        <?php echo $text_change; ?><br/><br/>

                                        <?php echo $reset_link; ?><br/><br/>

                                        <?php echo $text_ip; ?>
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
                                <td valign="top">
                                    Urgent Notice!
                                  <br/><br/>
                                    <?php echo $text_notice; ?>
                                </td>
                              </tr>
                            </table>

                          </td>
                        </tr>
                        <tr>
                          <td height="60" style="font-size:10px; line-height:10px;">&nbsp;</td>
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
                      <?php echo $text_footer; ?>
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
    </table>
  </center>
</body>
</html>