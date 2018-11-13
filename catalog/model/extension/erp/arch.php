<?php
class ModelExtensionErpArch extends Model { 
    
    public function mungXML($xml) {
        // A REGULAR EXPRESSION TO MUNG THE XML
        $rgx
        = '#'           // REGEX DELIMITER
        . '('           // GROUP PATTERN 1
        . '\<'          // LOCATE A LEFT WICKET
        . '/{0,1}'      // MAYBE FOLLOWED BY A SLASH
        . '.*?'         // ANYTHING OR NOTHING
        . ')'           // END GROUP PATTERN
        . '('           // GROUP PATTERN 2
        . ':{1}'        // A COLON (EXACTLY ONE)
        . ')'           // END GROUP PATTERN
        . '#'           // REGEX DELIMITER
        ;
        // INSERT THE UNDERSCORE INTO THE TAG NAME
        $rep
        = '$1'          // BACKREFERENCE TO GROUP 1
        . '_'           // LITERAL UNDERSCORE IN PLACE OF GROUP 2
        ;
        // PERFORM THE REPLACEMENT
        return preg_replace($rgx, $rep, $xml);
    }

    function out($var, $var_dump=true)
    {
        if ($var_dump) {
            echo "<pre>";
            var_dump($var);
            echo "<br></pre>";
        } else {
            echo "<pre>";
            print_r($var);
            echo "<br></pre>";
        }
    }

    public function get($function, $params) { 
        try {
            $aHttp['http']['header'] = "Content-Type: text/xml; charset=utf-8";
            $aHttp['http']['header'].= "SOAPAction: http://tempuri.org/IECommerceBO/$function";
            $context = stream_context_create($aHttp);
            $client = new SoapClient(ARCH_API, array('trace'=>1, "stream_context"=>$context));

            $response = $client->$function($params);
            return $response;
            //out($response->GetDepartmentsResult, false);
        } catch (Exception $e) { 
            $this->out($e);
        }
    }

    public function post($function, $xmlBody, $xmlns="") {
        try {
            $soapRequest  = "<x:Envelope xmlns:x=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:tem=\"http://tempuri.org/\" $xmlns>";
            $soapRequest .= "<x:Header/>";
            $soapRequest .= "<x:Body><tem:$function>$xmlBody</tem:$function></x:Body>";
            $soapRequest .= "</x:Envelope>";
            $log = new Log ('request.log');
            $log->write($soapRequest);
           
            $header = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: http://tempuri.org/IECommerceBO/$function",
                "Content-length: ".strlen($soapRequest),
            );
            $soapCh = curl_init();
            curl_setopt($soapCh, CURLOPT_URL, ARCH_API);
            curl_setopt($soapCh, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($soapCh, CURLOPT_TIMEOUT,        10);
            curl_setopt($soapCh, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($soapCh, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($soapCh, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($soapCh, CURLOPT_POST,           true );
            curl_setopt($soapCh, CURLOPT_POSTFIELDS,     $soapRequest);
            curl_setopt($soapCh, CURLOPT_HTTPHEADER,     $header);
            
            $xmlResponse = curl_exec($soapCh);
            if ($xmlResponse === false) {
                $err = 'Curl error: ' . curl_error($soapCh);
                curl_close($soapCh);
                print $err;
            } else {
                
                curl_close($soapCh);
                $log_response = new Log ('response.log');
                $log_response->write($xmlResponse);
                return json_decode(json_encode(@simplexml_load_string($this->mungXML($xmlResponse))), true);
            }
        } catch (Exception $e) {
            out($e);
        }
    }
    public function submitNewQuotation ($debtor_code,$order_number ,$products,$order_status) {
        // ArchSubmitNewQuotationCall
        $this->load->model('checkout/order');
        $xmlProductList = "";
        if (is_array($products)) {
            
            foreach ($products as $key => $value) {
                $xmlProductList .= "<spi1:SubmitQuotationRequest.SubmitQuotationProductList>";
                $xmlProductList .= "    <spi1:ProductCode>" . $value['model'] . "</spi1:ProductCode>";
                $xmlProductList .= "    <spi1:Quantity>" . $value['quantity'] . "</spi1:Quantity>";
                $xmlProductList .= "</spi1:SubmitQuotationRequest.SubmitQuotationProductList>";
            }
        } else {
            return null;
        }

        $xmlBody  = "    <tem:request>";
        $xmlBody .= "        <spi1:DebtorCode>" . $debtor_code . "</spi1:DebtorCode>";
        $xmlBody .= "        <spi1:ProductList>". $xmlProductList . "</spi1:ProductList>";
        $xmlBody .= "        <spi1:TransactionTrackingNumber> </spi1:TransactionTrackingNumber>";
        $xmlBody .= "    </tem:request>";
        $xmlns    = "xmlns:spi1=\"http://schemas.datacontract.org/2004/07/Spinnaker.Arch.BL.BusinessObjectReaders.ECommerce.Readers.Request\"";
      
        $result   = $this->post("SubmitNewQuotation", $xmlBody, $xmlns);
        $success = $result['s_Body']['SubmitNewQuotationResponse']['SubmitNewQuotationResult']['Success'];
        $transaction_tracking_number = $result['s_Body']['SubmitNewQuotationResponse']['SubmitNewQuotationResult']['a_TransactionTrackingNumber'];
        
        if ($success =='true') { 
            $this->model_checkout_order->addOrderHistory($order_number, $order_status,'Pricing Applied <br/> TTN : '.$transaction_tracking_number,true);
           $this->acceptQuotation($order_number, $transaction_tracking_number);
            //return $transaction_tracking_number;
            return true;
        } else {
            return false;
        }
       
    }

    public function acceptQuotation ($order_number,$ttn){
        $xmlBody  = "    <tem:request>";
        $xmlBody .= "        <spi1:OrderNumber>". $order_number ."</spi1:OrderNumber>";
        $xmlBody .= "        <spi1:TransactionTrackingNumber>". $ttn ."</spi1:TransactionTrackingNumber>";
        $xmlBody .= "    </tem:request>";
        $xmlns    = "xmlns:spi1=\"http://schemas.datacontract.org/2004/07/Spinnaker.Arch.BL.BusinessObjectReaders.ECommerce.Readers.Request\"";
      
        $result   = $this->post("AcceptQuotation", $xmlBody, $xmlns);
    }

    public function getDebtorCode($customer_id) {
        // Get Arch debtor ID
        $query = $this->db->query("SELECT debtor_code FROM `" . DB_PREFIX . "customer` WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row['debtor_code'];
    }

    public function fetchBalance($lastUpdated){
        //CON200
        $params = array("lastUpdate"=>"1900-01-01");
             $response = get("GetDebtors", $params);
             $results = $response->GetDebtorsResult;
             foreach ($results->ECommerceDebtorsReader as $result) {
               $debtor = $result->AccountName;
               $accountNum = $result->DebtorNumber;
               $email = $result->EmailAddress;
               $balance = $result->AccountBalance;
      
               echo '<p>Name: '.$debtor.'<br/>Account#: '.$accountNum.'<br>Email: '.$email.'<br/>Account Balance: R'.number_format((float)$balance, 2, '.', '').'</p>';
             }
             
    }
}