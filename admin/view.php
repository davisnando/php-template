<?php
function index(){
    LoadTemplates();
    GetTemplate('main','header.php');
    GetTemplate('sign_in','index.php');
    GetTemplate('main','footer.php');
}
function login(){
    require("admin/model.php");
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $pass = hash("sha512",$pass.$user);
    $db = new model("Framework");
    $db->prepare("SELECT * FROM Users WHERE username=:user AND password=:pass");
    $db->bind(":user",$user);
    $db->bind(":pass", $pass);
    $result = $db->GetAll();
    if(count($result) == 1){
        $_SESSION['username'] = $user;
        echo json_encode("True");
    }else{
       echo json_encode("False");        
    }
}
function logout(){
    session_destroy();
    $_SESSION['username'] = "";
    session_unset();
    header("location: ../admin");
}
function dashboard(){
    dashboardPerm();
    LoadTemplates();
    GetTemplate('main','header.php');
    GetTemplate('dashboard','index.php');
    GetTemplate('main','footer.php'); 
}
function dashboardPerm(){
    require("admin/model.php");
    if(!isset($_SESSION['username'])){
        header("location: /admin");
    }
    $username = $_SESSION['username'];
    // $bool = RoleExist($username,"adminpanel");
    // print_r($bool);
    if(!RoleExist($username,"adminpanel")){
        header("location: /admin");
        die();
    }
}

?>