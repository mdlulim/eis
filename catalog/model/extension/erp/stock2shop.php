<?php
class ModelExtensionErpStock2Shop extends Model {

    private $token;
    private $username;
    private $password;
    private $user;
    private $errors;

    public function __construct() {
        $this->setUsername(STOCK2SHOP_API_USERNAME);
        $this->setPassword(STOCK2SHOP_API_PASSWORD);
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setErrors($errors) {
        $this->errors[] = $errors;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getToken() {
        if (!empty($this->token)) {
            return $this->token;
        } else {
            $user = $this->auth($this->username, $this->password);
            if (isset($user['token'])) {
                $this->setToken($user['token']);
                $this->setUser($user);
                return $user['token'];
            } else {
                return false;
            }
        }
    }

    public function getUser() {
        if (!empty($this->user)) {
            return $this->user;
        } else {
            $user = $this->auth($this->username, $this->password);
            if (isset($user['token'])) {
                $this->setToken($user['token']);
                $this->setUser($user);
                return $user;
            } else {
                return false;
            }
        }
    }

    public function getChannelByDescription($description) {
        if (!empty($this->user)) {
            $user = $this->user;
        } else {
            $user = $this->auth($this->username, $this->password);
        }
        if (isset($user['channels']) && !empty($user['channels'])) {
            foreach($user['channels'] as $channel) {
                if (preg_match("/$description/", $channel['description'])) {
                    return $channel;
                    break;
                }
            }
        }
    }

    /**
     * Authenticate user
     * @param  {string} $username
     * @param  {string} $password
     * @return {array}
     */
    public function auth($username, $password) {
        $url  = "users/authenticate?format=json";
        $data = array(
            "system_user_auth" => array(  
                "username" => $username,
                "password" => $password
            )
        );
        $response = $this->post($url, $data);
        return (isset($response['system_user'])) ? $response['system_user'] : false;
    }

    /**
     * Check if auth token is valid
     * @param  {string} $token
     * @return {boolean}
     */
    public function validToken($token) {
        $url      = "users/valid_token/$token";
        $response = $this->get($url);
        if (isset($response['system_user']['id'])) {
            $this->setToken($response['system_user']['token']);
            $this->setUser($response['system_user']);
            return true;
        }
        return false;
    }

    /**
     * Get a list of all channel meta's
     * @param  {integer} $channel_id
     * @param  {string}  $token         [optional]
     * @return {mixed}
     */
    public function getChannelMeta($channel_id, $token=null) {
        $token    = (!is_null($token)) ? $token : $this->getToken();
        $url      = "channel_meta?channel_id=$channel_id&token=$token&format=json";
        $response = $this->get($url);
        return (isset($response['system_channel_meta'])) ? $response['system_channel_meta'] : false;
    }

    /**
     * Search customers
     * @param  {array} $params
     * @return {array}
     */
    public function searchCustomers($params) {
        if (isset($params['token'])) {
            $url   = "customers/search?" . http_build_query($params);
        } else {
            $token = $this->getToken();
            $url   = "customers/search?token=$token";
        }
        $response = $this->get($url);
        return $response;
    }

    /**
     * Get a single customer
     * @param  {integer} $customer_id
     * @param  {string}  $token         [optional]
     * @return {mixed}
     */
    public function getCustomer($customer_id, $token=null) {
        $token    = (!is_null($token)) ? $token : $this->getToken();
        $url      = "customers/$customer_id?token=$token&format=json";
        $response = $this->get($url);
        return (isset($response['system_customer'])) ? $response['system_customer'] : false;
    }

    /**
     * Post search query to elastic search
     * @param  {array} $params
     * @return {array}
     */
    public function searchProducts($params, $start=0, $size=10, $order="desc") {
        $token = (isset($params['token'])) ? $params['token'] : $this->getToken();
        $url   = "products/elastic_search?channel_id=".$param['channel_id']."&token=$token&format=json";
        $data  = array(
            "query" => array( 
                "bool" => array(
                    "must" => [
                        array( 
                            "multi_match" => array(
                                "query" => $params['search'],
                                "fields" => [
                                    "variants.sku^3",
                                    "title^3",
                                    "variants.barcode"
                                ],
                                "operator" => "or"
                            )
                        )
                    ]
                )
            ),
            "size" => $size,
            "from" => $start,
            "_source" => [  
                "id",
                "title",
                "options",
                "variants.id",
                "variants.sku",
                "variants.option1",
                "variants.option2",
                "variants.option3"
            ],
            "sort" => array(
                "_score" => array("order" => $order)
            )
        );
        $response = $this->post($url);
        if (isset($response['errors'])) {
            $this->setErrors($response['errors']);
        }
        return $response;
    }

    /**
     * Get a single product
     * @param  {integer} $product_id
     * @param  {string}  $token         [optional]
     * @return {mixed}
     */
    public function getProduct($product_id, $token=null) {
        $token    = (!is_null($token)) ? $token : $this->getToken();
        $url      = "products/$product_id?token=$token&format=json";
        $response = $this->get($url);
        return (isset($response['system_product'])) ? $response['system_product'] : false;
    }

    /**
     * Create an order on system. The order must be linked to a source.
     * @param  {array} $params
     * 
     *          EXAMPLE OF AN EXPECTED OBJECT BY S2S:
     *          {
     *                  "system_order": {
     *                      "line_items": [
     *                          {
     *                              "price": 5500,
     *                              "product_id": "200784",
     *                              "qty": 1,
     *                              "sku": "PC004",
     *                              "tax_lines": [
     *                                  {
     *                                      "code": "taxed",
     *                                      "price": 825,
     *                                      "rate": 15,
     *                                      "title": "TAX"
     *                                  }
     *                              ],
     *                              "title": "Desktop Computer",
     *                              "variant_id": "285812"
     *                          }
     *                      ],
     *                      "shipping_lines": [
     *                          {
     *                              "price": 100,
     *                              "tax_lines": [
     *                                  {
     *                                      "code": "taxed",
     *                                      "price": 15,
     *                                      "rate": 15,
     *                                      "title": "VAT"
     *                                  }
     *                              ],
     *                              "title": "Next Day"
     *                          }
     *                      ],
     *                      "shipping_total": 100,
     *                      "sub_total": 5500,
     *                      "tax_description": "TAX",
     *                      "tax_total": 840,
     *                      "total": 6440
     *                  }
     *          }
     * @return {array}
     *          EXAMPLE RESPONSE OBJECT:
     *          {
     *              "system_order_confirm": {
     *                  "line_item_messages": [],
     *                  "messages": [],
     *                  "shipping_lines": [
     *                      {
     *                          "price": 100,
     *                          "tax_lines": [
     *                              {
     *                                  "code": "taxed",
     *                                  "price": 15,
     *                                  "rate": 15,
     *                                  "title": "VAT"
     *                              }
     *                          ],
     *                          "title": "Next Day"
     *                      },
     *                      {
     *                          "price": 200,
     *                          "tax_lines": [
     *                              {
     *                                  "code": "taxed",
     *                                  "price": 28,
     *                                  "rate": 15,
     *                                  "title": "VAT"
     *                              }
     *                          ],
     *                          "title": "Same day delivery"
     *                      },
     *                      {
     *                          "price": 200,
     *                          "tax_lines": [
     *                              {
     *                                  "code": "taxed",
     *                                  "price": 28,
     *                                  "rate": 15,
     *                                  "title": "VAT"
     *                              }
     *                          ],
     *                          "title": "Rate based on cart"
     *                      }
     *                  ]
     *              }
     *          }
     */
    public function confirmOrder($params) {
        $token = (isset($params['token'])) ? $params['token'] : $this->getToken();
        $url   = "orders/confirm?channel_id=".$param['channel_id']."&token=$token&format=json";
        $data  = array(
            "system_order" => $params['order']
        );
        $response = $this->post($url, $data);
        return (isset($response['system_user']['channel_order_code'])) ? $response['system_user']['channel_order_code'] : false;
    }

    /**
     * Get next sequential order code
     * @param  {integer} $channe_id
     * @param  {string}  $token         [optional]
     * @return {mixed}
     */
    public function getOrderCode($channe_id, $token=null) {
        $token    = (!is_null($token)) ? $token : $this->getToken();
        $url      = "orders/code?channel_id=$channe_id?token=$token&format=json";
        $response = $this->get($url);
        return (isset($response['system_order']['channel_order_code'])) ? $response['system_order']['channel_order_code'] : false;
    }

    /**
     * Confirm order
     * @param  {array} $params
     * 
     *          EXAMPLE OF AN EXPECTED OBJECT BY S2S:
     *          {
     *              "system_order": {
     *                  "params": {
     *                      "customer_reference": "TEST"
     *                  },
     *                  "system_order": {
     *                      "billing_address": {
     *                          "address1": "2 Ncondo Place",
     *                          "city": "Umhlanga",
     *                          "province": "KwaZulu-Natal",
     *                          "zip": "4320"
     *                      },
     *                      "customer": {
     *                          "addresses": [],
     *                          "email": "kiroshan@cloudlogic.co.za",
     *                          "first_name": "Kiroshan",
     *                          "id": "250991",
     *                          "last_name": "Govender"
     *                      },
     *                      "id": "B2B0000251",
     *                      "instruction": "unpaid_order",
     *                      "line_items": [
     *                          {
     *                              "price": 5500,
     *                              "product_id": "200784",
     *                              "qty": 1,
     *                              "sku": "PC004",
     *                              "tax_lines": [
     *                                  {
     *                                      "code": "taxed",
     *                                      "price": 825,
     *                                      "rate": 15,
     *                                      "title": "TAX"
     *                                  }
     *                              ],
     *                              "title": "Desktop Computer",
     *                              "variant_id": "285812"
     *                          }
     *                      ],
     *                      "notes": "Test",
     *                      "shipping_address": {
     *                          "address1": "2 Ncondo Place",
     *                          "city": "Umhlanga",
     *                          "province": "KwaZulu-Natal",
     *                          "zip": "4320"
     *                      },
     *                      "shipping_lines": [
     *                          {
     *                              "price": 100,
     *                              "tax_lines": [
     *                                  {
     *                                      "code": "taxed",
     *                                      "price": 15,
     *                                      "rate": 15,
     *                                      "title": "VAT"
     *                                  }
     *                              ],
     *                              "title": "Next Day"
     *                          }
     *                      ],
     *                      "shipping_total": 100,
     *                      "sub_total": 5500,
     *                      "tax_description": "TAX",
     *                      "tax_total": 840,
     *                      "total": 6440
     *                  }
     *              }
     *          }
     * @return {array}
     *          EXAMPLE RESPONSE OBJECT:
     *          {
     *              "system_order": {
     *                  "queue_id": 103110060,
     *                  "sync_order": 1
     *              }
     *          }
     */
    public function queueOrder($params) {
        $token = (isset($params['token'])) ? $params['token'] : $this->getToken();
        $url   = "orders/queue?channel_id=".$param['channel_id']."&token=$token&format=json";
        $data  = array(
            "system_order" => $params['order']
        );
        $response = $this->post($url, $data);
        return (isset($response['system_order'])) ? $response['system_order'] : false;
    }

    /**
     * cURL get function
     * @param  {string} $url
     * @return {array}
     */
    private function get($url) {
        try {
            $curlUrl = STOCK2SHOP_API_URL . $url;
            $header  = array(
                "Content-type: application/json",
                "Cache-Control: no-cache"
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $curlUrl);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT,        10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
            
            if (curl_exec($ch) === false) {
                $err = 'Curl error: ' . curl_error($ch);
                curl_close($ch);
                print $err;
            } else {
                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            }
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    /**
     * cURL post function
     * @param  {string} $url
     * @param  {array}  $data [optional]
     * @return {array}
     */
    private function post($url, $data = array()) { 
        try {
            $curlUrl = STOCK2SHOP_API_URL . $url;
            $post    = $data;
            $header  = array(
                "Content-type: application/json",
                "Cache-Control: no-cache",
                "Content-length: ".strlen(json_encode($post))
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $curlUrl);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT,        10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POST,           true );
            curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode($post));
            curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
            
            if (curl_exec($ch) === false) {
                $err = 'Curl error: ' . curl_error($ch);
                curl_close($ch);
                $this->setErrors($err);
                return $err;
            } else {
                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response, true);
                if (isset($response['errors'])) {
                    $this->setErrors($response['errors']);
                }
                return $response;
            }
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
}