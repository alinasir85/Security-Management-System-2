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
     
        
       $("#country").change(function(){
           var cid=$("#country").val();
           var data={"action":"city","cid":cid};
           var settings={
               type:"POST",
               dataType:"json",
               data:data,
               url:"phpApi.php",
               success:function(result){
                   //alert(result);
                   //console.log(result;  
                   $("#city").empty();
                   for(var i=0;i<result.length;i++)
                   {
                       var op="<option value='"+result[i].id+"'>"+result[i].name+"</option>";
                       $("#city").append(op);
                   }  
               }
           };
           
           $.ajax(settings);
           return false;
           
       });
  
            
       $(".edit").click(function(){
           editFlag=1;
           var id=$(this).val();
           var data={"action":"editUser","id":id};
           var settings={
               type:"POST",
               dataType:"json",
               data:data,
               url:"phpApi.php",
               success:function(result){
                   //alert(result);
                   //console.log(result);
          var login=$('#login').val(result.login);  
          var password=$('#password').val(result.password);
          var name=$('#name').val(result.name);
          var email=$('#email').val(result.email);
          var country=$('#country').val(result.countryid);
          var city=$('#city').val(result.cityid);
          if(result.isadmin==1)
          {
              var isadmin=$('#isadmin').prop("checked",true);
          }
          else
          {
              var isadmin=$('#isadmin').prop("checked",false);
          }
                  
               }
           };
           
           $.ajax(settings);
           return false;
           
           
       });
       
       $("#save").click(function(){
           
          var login=$('#login').val();  
          var password=$('#password').val();
          var name=$('#name').val();
          var email=$('#email').val();
          var country=$('#country').val();
          var city=$('#city').val();
          var isadmin="";
          if($('#isadmin').is(':checked'))
          {
              isadmin=1;
   
          }
          else
          {
              isadmin=0;
          }
     
          
          var obj={"login":login,"password":password,"name":name,"email":email,"country":country,"city":city,"isadmin":isadmin,"editFlag":editFlag};
          
             var alphaExp = /^[A-Za-z\d\s]+$/;
	     var numExp = /^[0-9]+$/;
	     var alphanumExp = /^[0-9a-zA-Z]+$/;
             var atpos=email.indexOf("@");
             var dotpos=email.lastIndexOf(".");
             if(login==""||password==""||name==""||email==""||country==0||city==0)
             {
                 alert("Cannot accept empty values.");
                 return false;
             }
             
             else if(!login.match(alphanumExp) || !password.match(alphanumExp))
             {
                 alert('login/password Must contain alpha num only.');
                 return false;
             }
             
             else if(!name.match(alphaExp))
             {
              alert('Name Must only contain Alphabets.');
              return false;
             }
             
             else if(atpos<1 || (dotpos-atpos<2))
             {
                 alert("Please enter your correct email.");
                 return false;
             }
             
             else
             {
                 var dataToSend = {"action":"saveUser","data":obj};
                 
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
                       /* if(editFlag==1)
                        {
                            show();
                        }
                        else
                        {
                         var row= "<tr><td>"+result.userid+"</td><td>"+login+"</td><td>"+password+"</td><td>"+name+"</td><td>"+email+"</td><td>"+country+"</td><td>"+result.createdon+"</td><td>"+userid+"</td><td>"+isadmin+"</td><td><button type='submit' class='edit' name='edit' value='"+result.userid+"'>Edit</button></td> <td><button type='submit' class='delete' name='delete' value='"+result.userid+"' >DELETE</button></td></tr>";
                         $("#users").append(row);
                     }*/
   
                     }
                     
                 };
                 
                 $.ajax(settings);
                 //console.log("request sent");
                 editFlag=0;
                 return false;
             }
             
       });
       
       
       $("#clear").click(function(){
          var login=$('#login').val("");  
          var password=$('#password').val("");
          var name=$('#name').val("");
          var email=$('#email').val("");
          var country=$('#country').val(0);
          var city=$('#city').val(0);
        
    });
          
      
    });
    
    function deleteUser(id){
        var r = confirm('Do you want to remove it?');
        if (r) {
        $(this).closest('tr').remove();
       // var id=$(this).val();
       // alert(id);
        var dataToSend = {"action":"deleteUser","id":id};
                 
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
            
    function editUser(id)
    {
           editFlag=1;
           //var id=$(this).val();
           var data={"action":"editUser","id":id};
           var settings={
               type:"POST",
               dataType:"json",
               data:data,
               url:"phpApi.php",
               success:function(result){
                   //alert(result);
                   //console.log(result);
          var login=$('#login').val(result.login);  
          var password=$('#password').val(result.password);
          var name=$('#name').val(result.name);
          var email=$('#email').val(result.email);
          var country=$('#country').val(result.countryid);
          var city=$('#city').val(result.cityid);
          if(result.isadmin==1)
          {
              var isadmin=$('#isadmin').prop("checked",true);
          }
          else
          {
              var isadmin=$('#isadmin').prop("checked",false);
          }
                  
               }
           };
           
           $.ajax(settings);
           return false;
    }
    
    function show(){
    
			var dataToSend = {"action":"getUsersGrid"};
			
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
                            <td style="background-color:#555;color:white;padding-left:20px;" width="230px" height="40px"><b>User Management</b></td>
                       </tr>
                    </thead>
                    <tbody style="background-color: white;border-spacing:0;">
                        <tr>
                            <td style="padding:0;border-spacing: 0; ">Login:<br><input type="text" name="login" id="login" style="width: 220px;" value="" ></td>
                        </tr>
                         <tr>
                            <td>Password:<br><input type="text" name="password" id="password" style="width: 220px;" value=""></td>
                        </tr>
                         <tr>
                            <td>Name:<br><input type="text" name="name" id="name" style="width: 220px;" value=""></td>
                        </tr>
                         <tr>
                             <td>Email:<br><input type="text" name="email" id="email" style="width: 220px;" value=""></td>
                        </tr>
                        <tr>
                                    <td> Country:<br> <select name="country" id="country" style="width: 220px;">
                                     <option value="0">--Select--</option>
                                     <?php getCountries($con, $cid) ?> 
                                            
                                            
                                </select></td>
                 
                        </tr>
                          <tr>
                                    <td> City:<br> <select name="city" id="city" style="width: 220px;">
                                     <option value="0">--Select--</option>
                                      
                                            
                                            
                                </select></td>
                 
                        </tr>
                        <tr>
                            <td> Is admin?:<input type="checkbox" id="isadmin" name="isadmin" value="checked">
                    
                            </td>
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
                <tr><th>User ID</th><th>login</th><th>password</th><th>name</th><th>email</th><th>country</th><th>city</th><th>createdon</th><th>createdby</th><th>isadmin</th><th>Edit</th><th>Delete</th></tr>
            </thead>
          
            <tbody id="users">
                
            </tbody>
        </table>
        <br>
                           
    </body>
</html>