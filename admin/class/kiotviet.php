<?php
    class kiotviet
    {
        private $clientId;
        private $clientSecret;
        private $scopes;
        private $grant_type;
        private $tokenUrl;
        private $url;
        private $retailer = 'vinawares';
        public function __construct()
        {
            $this->clientId = 'f21d1f36-9c7d-466f-aac6-5b778e4c58ce';
            $this->clientSecret = 'B0E66CF68EA8B119F4A4BEAB02DAE7D7C97EF886';
            $this->scopes = 'PublicApi.Access';
            $this->grant_type = 'client_credentials';
            $this->tokenUrl = 'https://id.kiotviet.vn/connect/token';
            $this->url = 'https://public.kiotapi.com/';
    
        }
        public function getAccessToken()
        {
            $postData = [
                'scopes' => $this->scopes,
                'grant_type' => $this->grant_type,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ];
    
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, $this->tokenUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    
            $response = curl_exec($ch);
    
            if (curl_errno($ch)) {
                // Xử lý lỗi nếu có
                echo 'Error: ' . curl_error($ch);
            }
    
            curl_close($ch);
    
            $data = json_decode($response, true);
    
    
            // In thông tin Access Token
            $_SESSION['access_token'] = $data['access_token'];
            $_SESSION['token_type'] = $data['token_type'];
            $_SESSION['expires_in'] = $data['expires_in'];
    
            return $_SESSION['access_token'];
        }
        public function getList($type = ''){
            if($type != ''){
                $accessToken = $this->getAccessToken();
    
                $ch = curl_init();
        
                $this->url .=$type;
        
                curl_setopt($ch, CURLOPT_URL, $this ->url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Retailer:'.$this->retailer,
                    'Authorization: Bearer ' . $accessToken
                ]);
        
                $response = curl_exec($ch);
        
                if (curl_errno($ch)) {
                    // Xử lý lỗi nếu có
                    echo 'Error: ' . curl_error($ch);
                }
        
                curl_close($ch);
        
                $data = json_decode($response, true);
        
                return $data;
            }
        }
        public function get_instance($type, $id){
            if($type != ''){
                $accessToken = $this->getAccessToken();
    
                $ch = curl_init();
        
                $this->url .=$type.'/'.$id;
                curl_setopt($ch, CURLOPT_URL, $this ->url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Retailer:'.$this->retailer,
                    'Authorization: Bearer ' . $accessToken
                ]);
        
                $response = curl_exec($ch);
        
                if (curl_errno($ch)) {
                    // Xử lý lỗi nếu có
                echo 'Error: ' . curl_error($ch);
            }
    
            curl_close($ch);
    
            $data = json_decode($response, true);
    
            return $data;
        }
    }
    public function get_data_online_shop($category, $shop_name,$type = 'list'){
       global $main;
        $ch = curl_init();
    
        if($type == 'detail'){
            $this->url .=$category.'/'.$main->get('id');
        }else{
            $this->url .=$category.'?source='.$shop_name;
        }
        
        curl_setopt($ch, CURLOPT_URL, $this ->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Retailer:'.$this->retailer,
            'Authorization: Bearer ' . $this->getAccessToken()
        ]);
        $response = curl_exec($ch);
        $error = curl_errno($ch);
        if ($error) {
            // Xử lý lỗi nếu có
            echo 'Error: ' . $error;
        }

        curl_close($ch);
        $data = json_decode($response, true);
        $data['shop_name'] = $shop_name;
        return $data;

    }
    public function add($category, $post_fields){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://public.kiotapi.com/'.$category);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Retailer:'.$this->retailer,
            'Authorization: Bearer ' . $this->getAccessToken()
        ]);
        $response = curl_exec($ch);
        $error = curl_errno($ch);
        if ($error) {
            // Xử lý lỗi nếu có
            echo 'Error: ' . $error;
        }

        curl_close($ch);
        $data = json_decode($response, true);
        return $data;
    }

    public function update_products($id, $name, $code, $basePrice,$img, $onhand)
        {
            $data = array(
                "name" => $name,
                "code" => $code,
                "basePrice" => $basePrice,
                "images" => $img,
                // "barCode" => "1234567890123456",
                // "categoryId" => 1,
                // "allowsSale" => true,
                // "description" => "Mô tả sản phẩm",
                // "hasVariants" => false,
                // "attributes" => array(
                //     array(
                //         "attributeName" => "Màu sắc",
                //         "attributeValue" => "Đỏ"
                //     ),
                //     array(
                //         "attributeName" => "Kích thước",
                //         "attributeValue" => "L"
                //     )
                // ),
                // "unit" => "Cái",
                // "masterUnitId" => null,
                // "conversionValue" => null,
                // "inventories" => array(
                //     array(
                //         "branchId" => 1,
                //         "branchName" => "Chi nhánh A",
                //         "onHand" => 100,
                //         "cost" => 10.5,
                //         "reserved" => 20
                //     )
                // ),
                // "basePrice" => 25.0,
                // "weight" => 0.5,
                // "isActive" => true,
                // "isRewardPoint" => true
            );
            
            // Chuyển dữ liệu thành chuỗi JSON
            $jsonData = json_encode($data);
    
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, $this->url.'/products/'.$id.'?code='.$code);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Retailer:'.$this->retailer,
                'Authorization: Bearer ' . $this->getAccessToken()
            ]);
    
            // Thực thi yêu cầu cURL và lấy kết quả
            $response = curl_exec($ch);

            // Kiểm tra xem có lỗi xảy ra không
            if (curl_errno($ch)) {
                echo 'Lỗi cURL: ' . curl_error($ch);
            }

            // Đóng cURL
            curl_close($ch);

            // Xử lý kết quả (tuỳ thuộc vào cách API phản hồi dữ liệu)
            echo $response;
        }

    public function Delete_product($id)
    {
        $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, $this->url.'/products/'.$id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Retailer:'.$this->retailer,
                'Authorization: Bearer ' . $this->getAccessToken()
            ]);
    
            // Thực thi yêu cầu cURL và lấy kết quả
            $response = curl_exec($ch);

            // Kiểm tra xem có lỗi xảy ra không
            if (curl_errno($ch)) {
                echo 'Lỗi cURL: ' . curl_error($ch);
            }

            // Đóng cURL
            curl_close($ch);

            // Xử lý kết quả (tuỳ thuộc vào cách API phản hồi dữ liệu)
            echo $response;
    }

    public function Delete_orders($id)
    {
        $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, $this->url.'/orders/'.$id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Retailer:'.$this->retailer,
                'Authorization: Bearer ' . $this->getAccessToken()
            ]);
    
            // Thực thi yêu cầu cURL và lấy kết quả
            $response = curl_exec($ch);

            // Kiểm tra xem có lỗi xảy ra không
            if (curl_errno($ch)) {
                echo 'Lỗi cURL: ' . curl_error($ch);
            }

            // Đóng cURL
            curl_close($ch);

            // Xử lý kết quả (tuỳ thuộc vào cách API phản hồi dữ liệu)
            echo $response;
    }

    public function add_product($post)
    {
        $data = array(
            "name" => $post['name'],
            "code" => $post['code'],
            "barCode" => "SP_".rand(0,9999),
            "fullName" => $post['name'],
            "categoryId" => $post['category'], // Id nhóm hàng hóa
            "allowsSale" => true,
            "description" => "testing",
            "hasVariants" => false,
            "isActive" => true,
            "isProductSerial" => false,
            // "attributes" => array(
            //     array(
            //         "attributeName" => "Tên thuộc tính",
            //         "attributeValue" => "Giá trị thuộc tính"
            //     )
            // ),
            "unit" => "cái",
            "conversionValue" => 1,
            "inventories" => array(
                array(
                    "branchId" => '42081', // Id của chi nhánh
                    "branchName" => "Chi nhánh trung tâm",
                    "cost" => 100000,
                    "onHand" => $post['onHand'],
                )
            ),
            "basePrice" => $post['price'],
            "weight" => 4.0,
            "images" => $post['img']
        );
        $jsonData = json_encode($data);
    
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, $this->url.'/products');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Retailer:'.$this->retailer,
                'Authorization: Bearer ' . $this->getAccessToken()
            ]);
    
            // Thực thi yêu cầu cURL và lấy kết quả
            $response = curl_exec($ch);

            // Kiểm tra xem có lỗi xảy ra không
            if (curl_errno($ch)) {
                echo 'Lỗi cURL: ' . curl_error($ch);
            }

            // Đóng cURL
            curl_close($ch);

            // Xử lý kết quả (tuỳ thuộc vào cách API phản hồi dữ liệu)
            echo '<pre>';
            print_r($data);
    }

    public function add_category($post)
    {
        $data = array(
            "categoryName" => $post['name'],
        );
        $jsonData = json_encode($data);
    
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, $this->url.'/categories');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Retailer:'.$this->retailer,
                'Authorization: Bearer ' . $this->getAccessToken()
            ]);
    
            // Thực thi yêu cầu cURL và lấy kết quả
            $response = curl_exec($ch);

            // Kiểm tra xem có lỗi xảy ra không
            if (curl_errno($ch)) {
                echo 'Lỗi cURL: ' . curl_error($ch);
            }

            // Đóng cURL
            curl_close($ch);

            // Xử lý kết quả (tuỳ thuộc vào cách API phản hồi dữ liệu)
            echo '<pre>';
            print_r($data);
    }

    public function delete_category($id) {
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $this->url.'/categories/'.$id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Retailer:'.$this->retailer,
            'Authorization: Bearer ' . $this->getAccessToken()
        ]);

        // Thực thi yêu cầu cURL và lấy kết quả
        $response = curl_exec($ch);

        // Kiểm tra xem có lỗi xảy ra không
        if (curl_errno($ch)) {
            echo 'Lỗi cURL: ' . curl_error($ch);
        }

        // Đóng cURL
        curl_close($ch);

        // Xử lý kết quả (tuỳ thuộc vào cách API phản hồi dữ liệu)
        echo $response;
    }

}

$kiotviet = new kiotviet();
?>