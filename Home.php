<?php require 'conn.php'; session_start();
 require 'utility.php';?>
<?php

$adminflag=0;

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

if($rows>0)
{
  $adminflag=1;
}

}  

if($adminflag==1)
{?>
    <html>
    <head>
        <title>Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <style>
            
           .btn-group .header
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
               
            }
          .btn-group .header:hover
           {
               background-color: black;
               
           }
        </style>
    </head>
    <body style="background-color:whitesmoke">
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
        <div style="clear:both">
        <font style="font-size:50px;padding-left:100px;font-family: Arial;"><b>Welcome Admin</b></font>   
        </div>
    </body>
</html>
<?php }

else if($adminflag==0)
{
?>

<html>
    <head>
        <title>Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       
        <style>
            
           .btn-group .header
            {
               background-color: #555;
               color: white;
               float: left;
               border: none;
               outline: none;
               cursor: pointer;
               padding: 8px;
               font-size: 11px;
             
               
            }
          .btn-group .header:hover
           {
               background-color: black;
               
           }
        </style>
        
    
        
        
    </head>
    <body style="background-color:whitesmoke;" onload='main();'>
        <?php
                $id=$_SESSION["userid"];
                $rolesArray=getAllRolesbyId($con, $id);
                $permissionsArray=getAllPermissionsByRolesId($con, $rolesArray);
                $roles= getAllRolesByRolesArray($con, $rolesArray);
                $permissions= getAllPermissionsByPermissionsArray($con, $permissionsArray);
        ?>
        <div class="btn-group">
        <button class="header" onclick="window.location='Home.php'" style='width:10%'>Home</button>
        <button class="header" onclick="window.location='logout.php'" style='width:90%;text-align:left; ' >Logout</button>
        </div>
        <br><br>
        
        
        <div style="margin-left:400px;width: 500px; ">
        <div style="clear:both;height:40px;background-color: #555;">    
        <span style="font-size:30px;color:white;font-family:arial;margin-left:30px;"><b>Welcome User</b></span>  
        </div>
        <div id='role' style="background-color: white;">
            <?php
            if(count($roles)!=0)
            { $i=1;
             
               foreach($roles as $role)
                {
                    echo "$i. Role: <b>$role</b><br><br>";
                    $i++;
                }
            }
            ?>
        </div>
            
            <div style='background-color: #555;color:white;'>
                Permission:
               
            </div>
            
            <div id='permission' style="background-color: white;">
                 <?php
              if(count($permissions)!=0)
              {  foreach($permissions as $permission)
                {
                    
                    echo "$permission<br>";
                }
              }
                ?>
                
            </div>
    </div>
        
    </body>
</html>


<?php } ?>

