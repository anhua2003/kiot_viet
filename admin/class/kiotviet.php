<?php
    class kiotviet
    {
        private $clientId;
        private $clientSecret;
        private $scopes;
        private $grant_type;
        private $tokenUrl;
        private $url;
        private $retailer = 'shopApiTest';
        public function __construct()
        {
            $this->clientId = '9c57965c-c59a-44cb-8903-9f6b1bf76ab0';
            $this->clientSecret = 'BEB7A9F522E7F90080385147C632234ED6C783AF';
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

}
?>