<?php
   require_once "./DB.php";
   function DoUpdate(){
    $response = DB();

    $member_id = $_POST['member_id'];      
    $member_name = $_POST['member_name'];
    $member_celephone = $_POST['member_celephone'];    
    $member_email = $_POST['member_email'];

    if($response['status']==200) {
        $conn = $response['result'];

        $sql = "UPDATE `member` SET `member_id` = ?, `member_name` = ?, `member_celephone` = ?, `member_email` = ? WHERE `member_id` = ?";  

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$member_id, $member_name, $member_celephone, $member_email, $member_id]);

        if($result) {
            $count = $stmt->rowCount();
            
            if($count<1){
                $response['status'] = 204; 
                $response['message'] = "更新失敗";
            }else{
                $response['status'] = 200; 
                $response['message'] = "更新成功";
            }
        }else {
        $response['status'] = 400; 
        $response['message'] = "SQL錯誤";
        }
        
    }
    
      return($response); 
   }

