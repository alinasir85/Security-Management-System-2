<?php
require 'conn.php';
require 'utility.php';
session_start();

$action=$_REQUEST["action"];

if($action=="saveUser")
{
$obj=$_REQUEST["data"];
$msg="";
$output=[];
$login=$obj['login'];
$pass=$obj['password'];
$name=$obj['name'];
$email=$obj['email'];
$country=$obj['country'];
$city=$obj['city'];
$uid= $_SESSION["userid"];
$isadmin=$obj['isadmin'];
$editFlag=$obj['editFlag'];

if($editFlag==0)
{
    if($login=="" ||$pass==""||$name==""||$email=="")
{
    $msg="Cannot Accept Empty values.";
}
    
$sql="select * from users where login='$login' OR email='$email'";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);
if($rows>0)
{
    
    $msg="User with login/email already exists.";
}
else
{
    $datetime=date('Y-m-d H:i:s');
    $sql="insert into users (login,password,name,email,countryid,createdon,createdby,isadmin,cityid)  values ('$login','$pass','$name','$email',$country,'$datetime',$uid,$isadmin,$city)";
    $result= mysqli_query($con, $sql);
    if($result)
    {$msg="Added Successfully";
    }
}

if($msg=="Added Successfully")
{
    $sql2="select * from users where login='$login'";
    $result2= mysqli_query($con, $sql2);
    $record= mysqli_fetch_assoc($result2);
    $output["userid"]=$record['userid'];
    $output["createdon"]=$record['createdon'];
}
    $output["msg"]=$msg;
    echo json_encode($output);
}

else
{
  
    $sql2="select * from users where login='$login'";
    $result2= mysqli_query($con, $sql2);
    $record= mysqli_fetch_assoc($result2);
    $output["userid"]=$record['userid'];
    $id=$output["userid"];
    $output["createdon"]=$record['createdon'];
    
    $sql="UPDATE `users`
   SET
  `login` = '$login',
  `password` = '$pass',
  `name` = '$name',
  `email` = '$email',
  `countryid` = $country,
  `isadmin` = $isadmin,
  `cityid` = $city
WHERE `userid` = '$id';";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        $msg="Updated Successfully";
    }
    
    $output["msg"]=$msg;
    
    echo json_encode($output);    
}
}

else if($action=="city")
{
    $cid=$_REQUEST["cid"];
    $cities=[];
    $sql="select * from city where countryid=$cid";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row)
    {
        $i=0;
        while($record= mysqli_fetch_assoc($result))
        {
            $cities[$i]=$record;
            $i=$i+1;
        }
    }
    
    
    echo json_encode($cities);
}

else if($action=="deleteUser")
{
    $id=$_REQUEST['id'];
    $msg="Not Removed";
    $sql="delete from users where userid='$id'";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        $msg="Removed Successfully";
    }
    
    echo json_encode($msg);
}

else if($action=="editUser")
{
    $id=$_REQUEST['id'];
    $obj=getUserById($con, $id);
    echo json_encode($obj);
}

else if($action=="getUsersGrid")
{
    $res = getAllUsersGrid($con);
    echo json_encode($res);
}

else if($action=="getRolesGrid")
{
   $res = getAllRolesGrid($con);
    echo json_encode($res);   
}

else if($action=="deleteRole")
{
    $id=$_REQUEST['id'];
    $msg="Not Removed";
    $sql="delete from roles where roleid='$id'";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        $msg="Removed Successfully";
    }
    
    echo json_encode($msg);
}

else if($action=="editRole")
{
    $id=$_REQUEST['id'];
    $obj=getRoleById($con, $id);
    echo json_encode($obj);
}

else if($action=="saveRole")
{
$obj=$_REQUEST["data"];
$msg="";
$output=[];
$name=$obj['name'];
$description=$obj['description'];
$editFlag=$obj['editFlag'];
$uid= $_SESSION["userid"];

if($editFlag==0)
{
    if($name=="" ||$description=="")
{
    $msg="Cannot Accept Empty values.";
}
    
$sql="select * from roles where name='$name'";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);
if($rows>0)
{
    
    $msg="Role already exists.";
}
else
{
    $datetime=date('Y-m-d H:i:s');
    $sql="insert into roles (name,description,createdon,createdby)  values ('$name','$description','$datetime',$uid)";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        $msg="Added Successfully";
    }
}

/*if($msg=="Added Successfully")
{
    $sql2="select * from users where login='$login'";
    $result2= mysqli_query($con, $sql2);
    $record= mysqli_fetch_assoc($result2);
    $output["userid"]=$record['userid'];
    $output["createdon"]=$record['createdon'];
}*/
    $output["msg"]=$msg;
    echo json_encode($output);
}

else
{
    $sql2="select * from roles where name='$name'";
    $result2= mysqli_query($con, $sql2);
    $record= mysqli_fetch_assoc($result2);
    $id=$record["roleid"];
    $sql="update roles set description='$description' where roleid=$id";
    $result= mysqli_query($con, $sql);
    
    if($result)
    {
        $msg="Updated Successfully";
    }
    
    $output["msg"]=$msg;
    
    echo json_encode($output);    
}
}

else if($action=="getPermissionGrid")
{
   $res = getAllPermissionGrid($con);
    echo json_encode($res);   
}

else if($action=="deletePermission")
{
    $id=$_REQUEST['id'];
    $msg="Not Removed";
    $sql="delete from permissions where permissionid='$id'";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        $msg="Removed Successfully";
    }
    
    echo json_encode($msg);
}

else if($action=="editPermission")
{
    $id=$_REQUEST['id'];
    $obj= getPermissionById($con, $id);
    echo json_encode($obj);
}


else if($action=="savePermission")
{
$obj=$_REQUEST["data"];
$msg="";
$output=[];
$name=$obj['name'];
$description=$obj['description'];
$editFlag=$obj['editFlag'];
$uid= $_SESSION["userid"];

if($editFlag==0)
{
    if($name=="" ||$description=="")
{
    $msg="Cannot Accept Empty values.";
}
    
$sql="select * from permissions where name='$name'";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);
if($rows>0)
{
    
    $msg="Permission already exists.";
}
else
{
    $datetime=date('Y-m-d H:i:s');
    $sql="insert into permissions (name,description,createdon,createdby)  values ('$name','$description','$datetime',$uid)";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        $msg="Added Successfully";
    }
}

    $output["msg"]=$msg;
    echo json_encode($output);
}

else
{
    $sql2="select * from permissions where name='$name'";
    $result2= mysqli_query($con, $sql2);
    $record= mysqli_fetch_assoc($result2);
    $id=$record["permissionid"];
    $sql="update permissions set description='$description' where permissionid=$id";
    $result= mysqli_query($con, $sql);
    
    if($result)
    {
        $msg="Updated Successfully";
    }
    
    $output["msg"]=$msg;
    
    echo json_encode($output);    
}
}

else if($action=="getRolePermissionGrid")
{
   $res = getRolePermissionGrid($con);
    echo json_encode($res);   
}


else if($action=="saveRolePermission")
{
$obj=$_REQUEST["data"];
$msg="";
$output=[];
$role=$obj['role'];
$permission=$obj['permission'];
$editFlag=$obj['editFlag'];
$uid= $_SESSION["userid"];
$editUser=$obj["editUser"];
if($editFlag==0)
{
    if($role=="" ||$permission=="")
{
    $msg="Cannot Accept Empty values.";
}
    
$sql="select * from role_permission where roleid='$role' AND permissionid='$permission'";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);
if($rows>0)
{
    
    $msg="Role Permission already exists.";
}
else
{
   $sql="insert into role_permission (roleid,permissionid)  values ('$role','$permission')";
    $result= mysqli_query($con, $sql);
    $msg="Added Successfully";
}

    $output["msg"]=$msg;
    echo json_encode($output);
}

else
{
    /*$sql2="select * from role_permission where id='$editUser'";
    $result2= mysqli_query($con, $sql2);
    $record= mysqli_fetch_assoc($result2);
    $id=$record["id"];*/
    $sql="select * from role_permission where roleid='$role' AND permissionid='$permission'";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);
if($rows>0)
{
    
    $msg="Role Permission already exists.";
}
 else{   $sql="update role_permission set permissionid='$permission' where id=$editUser";
    $result= mysqli_query($con, $sql);
    
    if($result)
    {
        $msg="Updated Successfully";
    }
 }
    $output["msg"]=$msg;
    
    echo json_encode($output);    
}
}

else if($action=="deleteRolePermission")
{
    $id=$_REQUEST['id'];
    $msg="Not Removed";
    $sql="delete from role_permission where id='$id'";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        $msg="Removed Successfully";
    }
    
    echo json_encode($msg);
}

else if($action=="editRolePermission")
{
    $id=$_REQUEST['id'];
    $obj= getRolePermissionById($con, $id);
    echo json_encode($obj);
}


else if($action=="getUserRoleGrid")
{
   $res = getUserRoleGrid($con);
    echo json_encode($res);   
}

else if($action=="deleteUserRole")
{
    $id=$_REQUEST['id'];
    $msg="Not Removed";
    $sql="delete from user_role where id='$id'";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        $msg="Removed Successfully";
    }
    
    echo json_encode($msg);
}

else if($action=="editUserRole")
{
    $id=$_REQUEST['id'];
    $obj= getUserRoleById($con, $id);
    echo json_encode($obj);
}

else if($action=="saveUserRole")
{
$obj=$_REQUEST["data"];
$msg="";
$output=[];
$role=$obj['role'];
$user=$obj['user'];
$editFlag=$obj['editFlag'];
$uid= $_SESSION["userid"];
$editUser=$obj["editUser"];
if($editFlag==0)
{
    if($role=="" ||$user=="")
{
    $msg="Cannot Accept Empty values.";
}
    
$sql="select * from user_role where roleid='$role' AND userid='$user'";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);
if($rows>0)
{
    
    $msg="User Role already exists.";
}
else
{
   $sql="insert into user_role (userid,roleid)  values ('$user','$role')";
    $result= mysqli_query($con, $sql);
    $msg="Added Successfully";
}

    $output["msg"]=$msg;
    echo json_encode($output);
}

else
{
    /*$sql2="select * from role_permission where id='$editUser'";
    $result2= mysqli_query($con, $sql2);
    $record= mysqli_fetch_assoc($result2);
    $id=$record["id"];*/
    $sql="select * from user_role where roleid='$role' AND userid='$user'";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);
if($rows>0)
{
    
    $msg="User Role already exists.";
}
else
{$sql="update user_role set roleid='$role' where id=$editUser";
    $result= mysqli_query($con, $sql);
    
    if($result)
    {
        $msg="Updated Successfully";
    }
}   
    $output["msg"]=$msg;
    
    echo json_encode($output);    
}
}

?>