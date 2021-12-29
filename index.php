<?php
    if($_GET){
        require('./Rate.php');
        
        try {
            $api = new Rate();
            $ret = $api->Changerate($_GET);

            echo json_encode($ret);  
        } catch (Exception $e) {
            http_response_code(401);
            $error = ['error' => ['ret' => $e->getMessage(), 'status' => 401]];

            echo json_encode($error);
        }
    }