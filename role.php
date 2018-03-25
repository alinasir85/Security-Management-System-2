<?php
require 'conn.php';session_start();require 'utility.php';
$cid=0;
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
    $(document).ready(
    function()
    {
        show();

     
       $("#save").click(function(){
           
         var name=$('#name').val();  
          var description=$('#description').val();
          
          
          var obj={"name":name,"description":description,"editFlag":editFlag};
          
             var alphaExp = /^[A-Za-z\d\s]+$/;
	     var numExp = /^[0-9]+$/;
	     var alphanumExp = /^[0-9a-zA-Z\d\s]+$/;
          
             if(name==""||description=="")
             {
                 alert("Cannot accept empty values.");
                 return false;
             }
             
             else if(!name.match(alphanumExp) || !description.match(alphanumExp))
             {
                 alert('Must contain alpha num only.');
                 return false;
             }
             
             else
             {
                 var dataToSend = {"action":"saveRole","data":obj};
                 
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
        var name=$('#name').val("");  
          var description=$('#description').val("");
        
    });
          
      
    });
    
    function deleteRole(id){
        var r = confirm('Do you want to remove it?');
        if (r) {
        $(this).closest('tr').remove();
       // var id=$(this).val();
       // alert(id);
        var dataToSend = {"action":"deleteRole","id":id};
                 
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
            
    function editRole(id)
    {
           editFlag=1;
           //var id=$(this).val();
           var data={"action":"editRole","id":id};
           var settings={
               type:"POST",
               dataType:"json",
               data:data,
               url:"phpApi.php",
               success:function(result){
                   //alert(result);
                   console.log(result);
          var name=$('#name').val(result.name);  
          var description=$('#description').val(result.description);
                  
               }
           };
           
           $.ajax(settings);
           return false;
    }
    
    function show(){
    
			var dataToSend = {"action":"getRolesGrid"};
			
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
        <br><br><br>
        
                <div class="main">
            <div class="left">
                
                <table style=" border-collapse: collapse;">
                    <thead>
                        <tr>
                            <td style="background-color:#555;color:white;padding-left:20px;" width="230px" height="40px"><b>Role Management</b></td>
                       </tr>
                    </thead>
                    <tbody style="background-color: white;border-spacing:0;">
                        <tr>
                            <td style="padding:0;border-spacing: 0; ">Name:<br><input type="text" name="name" id="name" style="width: 220px;" value="" ></td>
                        </tr>
                         <tr>
                            <td>Description:<br><input type="text" name="description" id="description" style="width: 220px;" value=""></td>
                        </tr>
                        

                        <tr style="background-color:#555;">
                            <td height="35px"><button  style="float:right;width:100px;margin-right:10px;" id="save" name="save">Save</button><button style="float:right; width:100px;" id="clear">Clear</button></td>
                                 
                        </tr>
                    </tbody>
                </table>
            
                
                 <span style="color: red; margin-left:10px; "><b></b></span>
            </div>
                    
                          <br><br>
          
        <table border="1" cellpadding="10">
          <thead>
                <tr><th>Role ID</th><th>Name</th><th>Description</th><th>createdon</th><th>createdby</th><th>Edit</th><th>Delete</th></tr>
            </thead>
          
            <tbody id="users">
                
            </tbody>
        </table>
        <br>
                           
    </body>
</html>