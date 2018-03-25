<?php
require 'conn.php';
require 'utility.php';
session_start();
$roleid=0;
$permissionid=0;
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



<html> 
 <head>
     <script src="jquery-3.2.1.min.js" type="text/javascript"></script> 
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
        
  <script>
    
       
    var editFlag=0;  
    var editUser=0;
    $(document).ready(
    function()
    {
        show();

      
       $("#save").click(function(){
           
         var role=$('#role').val();  
         var permission=$('#permission').val();
          
          
          var obj={"role":role,"permission":permission,"editFlag":editFlag,"editUser":editUser};
          
             var alphaExp = /^[A-Za-z\d\s]+$/;
	     var numExp = /^[0-9]+$/;
	     var alphanumExp = /^[0-9a-zA-Z\d\s]+$/;
          
             if(role==0||permission==0)
             {
                 alert("Cannot accept empty values.");
                 return false;
             }
             
             else
             {
                 var dataToSend = {"action":"saveRolePermission","data":obj};
                 
                 var settings={
                     type:"POST",
                     dataType:"json",
                     url:"phpApi.php",
                     data:dataToSend,
                     success:function(result)
                     {
                         //console.log(result);
                         alert(result.msg);
                         show();
                       
   
                     }
                     
                 };
                 
                 $.ajax(settings);
                 //console.log("request sent");
                 editFlag=0;
                 return false;
             }
             
       });
       
       
       $("#clear").click(function(){
        var role=$('#role').val(0);  
          var permission=$('#permission').val(0);
        
    });
          
      
    });
    
    function deleteRolePermission(id){
        var r = confirm('Do you want to remove it?');
        if (r) {
        $(this).closest('tr').remove();
       // var id=$(this).val();
       // alert(id);
        var dataToSend = {"action":"deleteRolePermission","id":id};
                 
                 var settings={
                     type:"POST",
                     dataType:"json",
                     url:"phpApi.php",
                     data:dataToSend,
                     success:function(result)
                     {
                         //console.log(result);
                         alert(result);
                         show();
                     }
                     
                 };
                 
                 $.ajax(settings);
                 //console.log("request sent");
                 return false;
        
           }
            }
            
    function editRolePermission(id)
    {
           editFlag=1;
           //var id=$(this).val();
           var data={"action":"editRolePermission","id":id};
           var settings={
               type:"POST",
               dataType:"json",
               data:data,
               url:"phpApi.php",
               success:function(result){
                   //alert(result);
                   console.log(result);
          var role=$('#role').val(result.roleid);  
          var permission=$('#permission').val(result.permissionid);
          editUser=result.id;        
               }
           };
           
           $.ajax(settings);
           return false;
    }
    
    function show(){
    
			var dataToSend = {"action":"getRolePermissionGrid"};
			
			//Step-2: Create an Object to make AJAX call
			var settings= {
				type: "POST",
				dataType: "json",
				url: "phpApi.php",
				data: dataToSend,
				success: function(result){
					//result.Cities contains cities
					console.log(result);
                                         $("#users").empty();
                                        for(var i=0;i<result.length;i++)
                                        {
                                            $("#users").append(result[i]);
                                        }
				}
			};
			
			//Step-3: Make AJAX call
			$.ajax(settings);
			console.log('request sent');
			//return false;	
    } 
    
   
                    
   </script>
           
    </head>
    <body style="background-color:whitesmoke" >
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
        
                <div class="main">
            <div class="left">
               
                <table style=" border-collapse: collapse;">
                    <thead>
                        <tr>
                            <td style="background-color:#555;color:white;padding-left:20px;" width="230px" height="40px"><b>Role Permission Management</b></td>
                       </tr>
                    </thead>
                    <tbody style="background-color: white;border-spacing:0;">
                        <tr>
                            <td style="padding:0;border-spacing: 0; ">Name:<br><select name="role" id="role" style="width: 220px;<?php if($editFlag==1){?>background-color: lightgray;<?php } ?>" <?php if($editFlag==1){?>  readonly="true" disabled="true"<?php } ?>>
                                    <option value="0">--Select--</option>
                                   <?php getRoles($con,$roleid); ?>
                                    
                                </select></td>
                        </tr>
                         <tr>
                            <td>Permission:<br><select name="permission" id="permission" style="width: 220px;" >
                                 <option value="0">--Select--</option>
                                   <?php getPermissions($con,$permissionid); ?>
                                    
                                
                                </select></td>
                        </tr>
                          
                        <tr style="background-color:#555;">
                            
                            <td height="35px"><button style="float:right;width:100px;margin-right:10px;" id="save" name="save">Save</button><button style="float:right; width:100px;" id="clear">Clear</button></td>
                                 
                        </tr>
                    </tbody>
                </table>
                          
             
                
            </div>
                    
                    <br><br>
        <table border="1" cellpadding="10">
            <thead>
                <tr><th>Role</th><th>Description</th><th>Permission</th><th>Description</th><th>Edit</th><th>Delete</th></tr>
            </thead>
          
            <tbody id="users">
                
                
            </tbody>
        </table>
                </div>
    </body>


</html>
   