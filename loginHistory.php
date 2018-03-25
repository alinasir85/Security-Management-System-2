<?php
require 'conn.php';session_start();


 if($_SESSION["user"]==NULL)
 {
      header('location:LOGIN.php');
 }
 else
 {
     
 $user=$_SESSION["user"];

$sql="select * from users where login='$user' AND isadmin=1";
$result= mysqli_query($con, $sql);
$rows= mysqli_num_rows($result);

if(!($rows>0))
{
  header('location:LOGIN.php');
}

}  
?>
<?php


if(isset($_REQUEST['createNew']))
{
    $_SESSION['edituserid']=NULL;
    header('location:permission.php');
}

if(isset($_REQUEST['delete']))
{
    $uid=$_REQUEST['delete'];
    $sql="delete from permissions where permissionid=$uid";
    $result= mysqli_query($con, $sql);
    if($result)
    {
        header('location:permissionList.php');
    }
}

if(isset($_REQUEST['edit']))
{
    $uid=$_REQUEST['edit'];
    $_SESSION['edituserid']=$uid;  
    header('location:permission.php');
}

?>

<html>
    <head>
            <style>
            
             
                
           .container .btn-group .header
            {
               background-color: #555;
               color: white;
               float: left;
               border: none;
               outline: none;
               cursor: pointer;
               padding: 8px;
               font-size: 11px;
               width: 12.5%;
               margin: 0px;
               
            }
          .container .btn-group .header:hover
           {
               background-color: black;
               
           }
           
        
       
        </style>
    </head>
    <body style="background-color:whitesmoke">
        <div class="container">
        <div class="btn-group">
        <button class="header" onclick="window.location='Home.php'">Home</button>
        <button class="header" onclick="window.location='user.php'">User Management</button>
        <button class="header" onclick="window.location='role.php'">Role Management</button>
        <button class="header" onclick="window.location='permission.php'">Permission Management</button>
        <button class="header" onclick="window.location='rolePermission.php'">Role-Permissions Management</button>
        <button class="header" onclick="window.location='UserRole.php'">User-Role Management</button>
        <button class="header" onclick="window.location='loginHistory.php'">Login History</button>
        <button class="header" onclick="window.location='logout.php'">Logout</button>
        </div>
        <br><br><br>
        <form action="">
        <table border="1" cellpadding="20">
            <thead>
                <tr><th>User ID</th><th>Login</th><th>Login Time</th><th>Machine IP</th></tr>
            </thead>
          
            <tbody>
                <?php
                $sql="select * from loginhistory";
                $result= mysqli_query($con, $sql);
                $rows= mysqli_num_rows($result);
                if($rows>0)
                {
                    while($record= mysqli_fetch_assoc($result))
                    {
                        echo "<tr><td>".$record['userid']."</td><td>".$record['login']."</td><td>".$record['logintime']."</td><td>".$record['machineip']."</td></tr>";
                    }
                }
                ?>
                
            </tbody>
        </table>
      
        </form>
        </div>
    </body>
        
</html>