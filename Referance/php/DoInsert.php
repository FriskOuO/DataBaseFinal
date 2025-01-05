<?php
require_once "./DB.php";
function DoInsert(){
    $response = DB();

    $member_id = $_POST['member_id'];      
    $member_name = $_POST['member_name'];
    $member_celephone = $_POST['member_celephone'];    
    $member_email = $_POST['member_email'];

    if($response['status']==200) {
        $conn = $response['result'];

        $sql = "INSERT INTO `member` (`member_id`, `member_name`, `member_celephone`, `member_email`) VALUES (?,?,?,?)";
        
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$member_id, $member_name, $member_celephone, $member_email]);

        if($result) {
            $count=$stmt->rowCount();

            if($count<1){
                $response['status'] = 204;
                $response['message'] = "註冊失敗";
            }else{
                $response['status'] = 200; 
                $response['message'] = "註冊成功";
            }
        }else {
        $response['status'] = 400;
        $response['message'] = "SQL錯誤";
        }

    }
    
   
   return($response); 
}

