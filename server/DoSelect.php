<?php
require_once './DB.php';
function DoSelect(){
    $response = DB();

    if($response['status']==200) {
        $conn = $response['result'];
        
        // $member_id = $_POST['member_id'];
        
        $sql = "SELECT  *  FROM  `member`";
        
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();

        if($result) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response['status'] = 200; //OK
            $response['message'] = "查詢成功";

            $response['result'] = $rows;
        }
        else {
            $response['status'] = 400; //Bad Request
            $response['message'] = "SQL錯誤";
        }
    }
    
    return($response); 
 }


