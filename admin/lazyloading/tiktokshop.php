<?php
$nod        = $main->get('nod');

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}
if ($act == 'product') {
    if ($nod == 'edit') {
        $imgArray = $main->post('img');
        $data_array['size_chart'] = array('img_id' => ''); // Khởi tạo mảng con 'size_chart'
        $data_array['images'] = array(); // Khởi tạo mảng con 'images'
        foreach ($imgArray as $item) {
            // Tách dữ liệu của hình ảnh từ chuỗi Base64
            list(, $data) = explode(',', $item);

            // Giải mã dữ liệu Base64 thành dữ liệu nhị phân của hình ảnh
            $image_data = base64_decode($data);
            $result = $client->Product->uploadImage($image_data);
            // echo $result['img_id'];
            array_push($data_array['size_chart']['img_id'], $result['img_id']);
            array_push($data_array['images'], $result['img_id']);
        }
        // print_r($img_list);
        // exit();
        $product_id = $main->post('product_id');
        $data_array = [
            "product_name" => $main->post('product_name'),
            "description" => "Hasagi_SIUUUaaa",
            "category_id" => "601213",
            "package_weight" => "0.01",
            "skus" => [
                [
                    "stock_infos" => [
                        [
                            "warehouse_id" => "7261661409196427013",
                            "available_stock" => $main->post('stock')
                        ]
                    ],
                    "original_price" => $main->post('price'),
                    "sales_attributes" => []
                ]
            ],
            "size_chart" => [
                "img_id" => "tos-maliva-i-o3syd03w52-us/d358c00aff7343418c3b6d615c0bcd04"
            ],
            "images" => [
                [
                    "id" => "tos-maliva-i-o3syd03w52-us/d358c00aff7343418c3b6d615c0bcd04"
                ]
            ]
        ];
        // $data = array('product_name' => $main->post('product_name'), 
        // 'stock_infos' => $main->post('stock'), 'price' => $main->post('price'), 'description' => 'adu');
        // $data['product_name'] = $main->post('product_name');
        // $data['description'] = 'adu';
        // $data['category_id'] = '601213';
        // // $data['brand_id'] = '7158094830659340038';
        // $data['package_weight'] = '0.01';
        // $data['skus'] = array(  'id'=> 1729671560796277504, 
        //                         'price' => array('currency' => 'VND', 'original_price' => 1), 
        //                         // 'sales_attributes' => array(array(   'id'=>7262242688203310854, 
        //                         //                                     'name' => 'Specification', 
        //                         //                                     'value_id' => 7262242688203327238, 
        //                         //                                     'value_name' => 'Default')), 
        //                         'seller_sku' => null, 
        //                         'stock_infos' => array(array('warehouse_id' =>"7261661409196427013",
        //                                                     'available_stock' => 1)),
        //                         'original_price' => 100
        //                     );
        // $data = '{

        //     "product_name": "Áo hoodie nam nữ local brand unisex cặp đôi nỉ ngoại cotton form rộng có mũ xám đen dày oversize",
        //     "description": "áo ba mua",
        //     "category_id": "601213",
        //     "package_weight": "0.01",
        //     "skus": [
        //       {
        //         "stock_infos": [
        //           {
        //             "warehouse_id": "7261661409196427013",
        //             "available_stock": 0
        //           }
        //         ],
        //         "original_price": "100",
        //         "sales_attributes": []
        //       }
        //     ],
        //     "size_chart": {
        //       "img_id": "tos-maliva-i-o3syd03w52-us/84e5afc195f34bc8a8a6160b2f1b6c93"
        //     },
        //     "images": [
        //       {
        //         "id": "tos-maliva-i-o3syd03w52-us/84e5afc195f34bc8a8a6160b2f1b6c93"
        //       }
        //     ]
        //   }';

        // Chuyển đổi JSON thành mảng PHP
        // $arrayData = json_decode($data, true);
        echo '<pre>';
        print_r($data_array);
        exit();
        $result = $client->Product->editProduct($product_id, $data_array);

        if (gettype($result) == 'array') {
            echo 'done##' . $main->toJsonData(200, null, $result);
        }
    }
} else {
    echo 'Missing action';
    $db->close();
    exit();
}
