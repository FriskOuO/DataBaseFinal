<?php
function authenticate_user($account, $password) {
    $users = [
        'user1' => 'password1',
        'user2' => 'password2'
    ];

    return isset($users[$account]) && $users[$account] == $password;
}

function authenticate_admin($account, $password) {
    $admins = [
        'admin1' => 'adminpassword1',
        'admin2' => 'adminpassword2'
    ];

    return isset($admins[$account]) && $admins[$account] == $password;
}
?>