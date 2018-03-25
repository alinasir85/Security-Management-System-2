<?php require ('conn.php'); session_start();?>

<?php
$error="";
//$_SESSION["user"]="";

if(isset($_REQUEST['button_user']))
{
    
    $user=$_REQUEST['login_user'];
    $pass=$_REQUEST['pass_user'];
    if($user=="" || $pass=="")
    {
        $error="Cannot Accept Empty values ";
        return false;
    }
    $sql="Select * from users where login='$user' AND password='$pass'";
    $result= mysqli_query($con, $sql);
    $rows= mysqli_num_rows($result);
    if($rows>0)
    {
     $uid= mysqli_fetch_assoc($result);   
     $_SESSION["userid"]=$uid['userid'];
     $_SESSION["user"]=$user;
     
     $uid=$_SESSION["userid"];
     date_default_timezone_set('Asia/Karachi'); 
     $datetime=date('Y-m-d H:i:s');
     $ip=$_SERVER['REMOTE_ADDR'];
     $sql="insert into loginhistory (userid,login,logintime,machineip) values('$uid','$user','$datetime','$ip')";
     $result= mysqli_query($con, $sql);
     if($result)
     {header('location:Home.php');}

    }
 else {
      $error="User doesnot exists.";  
      }
}
?>

<html>
<head>
  
<script>

function main()
{

    document.getElementById('button_user').onclick=function()
  {
	    
  var user_name=document.getElementById('login_user').value;
  var user_pass=document.getElementById('pass_user').value;
  var alphanumExp = /^[0-9a-zA-Z]+$/;
	  if(user_name==="")
	  {
		  alert('Name cannot be empty.');
		  return false;
	  }
	 else if(user_pass==="")
	  {
		   alert('Password cannot be empty.');
         return false;
	  } 
          
          else if(!user_name.match(alphanumExp) || !user_pass.match(alphanumExp))
             {
                 alert('Must contain alpha num only.');
                 return false;
             }
       
  };
  
  
  
}


</script>

</head>
<body onload="return(main());">
<div style="margin-left: 510px;">
    <font style="color:black;font-size:50px;font-family: Arial"><b>Security Manager</b></font><br><br>
    <form action="">
<table style="margin-left: 90px;">
<thead>
<tr><th style="background-color:dimgray;" width=200px; height=40px;><font style="color:white;">Login User</font></th></tr>
</thead>
<tbody>
<tr style="background-color:white;border-collapse: collapse;"><td height="70">Username:<br><input type="text" id="login_user" name ="login_user" style="width: 180px;"> </td></tr>

<tr style="background-color:white;border-collapse: collapse;"><td height="70">Password:<br><input type="password" id="pass_user" name="pass_user" style="width: 180px;"> </td></tr>
<tr style="background-color:white;"></tr><tr style="background-color:white;"></tr>

<tr style="background-color:dimgray;" ><td height="30"><input type="submit" id="button_user" name="button_user" value="Login" style="float: right; width:100px;"></td></tr>
</tbody>
</table>
    </form>
    <span style="color: red; margin-left:90px; "><b><?php echo $error ?></b></span>
    
</div>
</body>
</html>
