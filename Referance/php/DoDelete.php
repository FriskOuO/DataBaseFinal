<?php
   require_once "./DB.php";
   function DoDelete(){
    $response = DB();

    $member_id = $_POST['member_id'];

    if($response['status']==200) {
        $conn = $response['result'];

        $sql = "DELETE  FROM `member` WHERE member_id=?";

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$member_id]);

        if($result) {
            $count = $stmt->rowCount();

            if($count<1){
                $response['status'] = 204; 
                $response['message'] = "刪除失敗";
            }else{
                $response['status'] = 200; 
                $response['message'] = "刪除成功";
            }
            
        } else {
        $response['status'] = 400; 
        $response['message'] = "SQL錯誤";
        }

    }
    
      return($response); 
   }

