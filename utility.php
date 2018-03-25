<?php

function getCountries($con,$id)
{
    $sql="select * from country";
    $result=mysqli_query($con,$sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        while($record= mysqli_fetch_assoc($result))
        {
            $s="";
            $cid=$record['id'];
            if($cid==$id)
            {
                $s="selected";
            }
            $name=$record['name'];
            echo "<option value='$cid' $s>$name</option>";
        }
    }
}

function getCountryById($con,$id)
{
    $sql="select * from country where id=$id";
    $result=mysqli_query($con,$sql);
    $row= mysqli_num_rows($result);
    $record="";
    if($row>0)
    {
        $record= mysqli_fetch_assoc($result);
          
    return $record;
     
    }
  
}

function getCityById($con,$id)
{
    $sql="select * from city where id=$id";
    $result=mysqli_query($con,$sql);
    $row= mysqli_num_rows($result);
    $record="";
    if($row>0)
    {
        $record= mysqli_fetch_assoc($result);
          
    return $record;
     
    }
  
}

function getRoles($con,$id)
{
    $sql="select * from roles";
    $result=mysqli_query($con,$sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        while($record= mysqli_fetch_assoc($result))
        {
            $s="";
            $roleid=$record['roleid'];
            if($roleid==$id)
            {
                $s="selected";
            }
            $role=$record['name'];
            echo "<option value='$roleid' $s>$role</option>";
        }
    }
               
}



function getPermissions($con,$id)
{
    $sql="select * from permissions";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        while($record= mysqli_fetch_assoc($result))
        {
            $s="";
            $permissionid=$record['permissionid'];
            if($permissionid==$id)
            {
                $s="selected";
            }
            $permission=$record['name'];
            echo "<option value='$permissionid' $s>$permission</option>";
        }
    }
}

function getUsers($con,$id)
{
    $sql="select * from users";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        while($record= mysqli_fetch_assoc($result))
        {
            $s="";
            $userid=$record['userid'];
            if($userid==$id)
            {
                $s="selected";
            }
            $user=$record['login'];
            echo "<option value='$userid' $s>$user</option>";
        }
    }
}


function getRoleById($con,$id)
{
    $sql="select * from roles where roleid='$id'";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
       $record= mysqli_fetch_assoc($result);
       return $record;               
    }
}


function getPermissionById($con,$id)
{
    $sql="select * from permissions where permissionid='$id'";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
       $record= mysqli_fetch_assoc($result);
       return $record;               
    }
}


function getRolePermissionById($con,$id)
{
    $sql="select * from role_permission where id='$id'";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
       $record= mysqli_fetch_assoc($result);
       return $record;               
    }
}

function getUserRoleById($con,$id)
{
    $sql="select * from user_role where id='$id'";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
       $record= mysqli_fetch_assoc($result);
       return $record;               
    }
}



function getAllRolesbyId($con,$id)
{
    $k=0;
    $record=[];
    $sql="select roleid from user_role where userid='$id'";
    $result= mysqli_query($con, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
       while($r= mysqli_fetch_assoc($result))
       {
           $record[$k]=$r['roleid'];
           $k++;
           
       }
       return $record;               
    }
}


function isUniquePermission($arr,$p)
{
   for($i=0;$i<count($arr);$i++)
   {
       if($arr[$i]==$p)
           return 0;
   }
    
    return 1;
}

function getAllPermissionsByRolesId($conn,$arr)
{   
    if(count($arr)==0)
    {
        return;
    }
    $record=[];
    $k=0;
   foreach($arr as $role=>$value)
   {
    $j=(int)$value;

    $sql="select permissionid from role_permission where roleid=$j"; 
     $result= mysqli_query($conn, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        
        while($r= mysqli_fetch_assoc($result))
        {
            $p=$r['permissionid'];
            $f=isUniquePermission($record,$p);
            if($f==1)
            {
             $record[$k]=$p;
             $k++;
            }
        }
      }
   }
   return $record;
}


function getAllRolesByRolesArray($conn,$arr)
{
     if(count($arr)==0)
    {
        return;
    }
    $record=[];
    $k=0;
   foreach($arr as $role=>$value)
   {
    $j=(int)$value;

    $sql="select * from roles where roleid=$j"; 
     $result= mysqli_query($conn, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        
        while($r= mysqli_fetch_assoc($result))
        {
            
            $record[$k]=$r['name'];
           $k++;
        }
      }
   }
   return $record;
}


function getAllPermissionsByPermissionsArray($conn,$arr)
{
     if(count($arr)==0)
    {
        return;
    }
    $record=[];
    $k=0;
   foreach($arr as $role=>$value)
   {
    $j=(int)$value;

    $sql="select * from permissions where permissionid=$j"; 
     $result= mysqli_query($conn, $sql);
    $row= mysqli_num_rows($result);
    if($row>0)
    {
        
        while($r= mysqli_fetch_assoc($result))
        {
            
            $record[$k]=$r['name'];
           $k++;
        }
      }
   }
   return $record;
}



function getUserById($con,$id)
{  
    $sql="select * from users where userid='$id'";
    $result= mysqli_query($con, $sql);
    $rows= mysqli_num_rows($result);
    if($rows>0)
    {
        $record= mysqli_fetch_assoc($result);
    }
    
    return $record;
}

function getAllUsersGrid($con)
{
    $sql="select * from users";
    $obj=[];
                $result= mysqli_query($con, $sql);
                $rows= mysqli_num_rows($result);
                if($rows>0)
                {
                    $i=0;
                    while($record= mysqli_fetch_assoc($result))
                    {
                        
                        if($record['isadmin']==1)
                        {
                            $admin="Yes";
                        }
                        else {
                            $admin="No";
                                    
                        }
                        $country= getCountryById($con, $record['countryid']);
                        $city= getCityById($con, $record['cityid']);
                        $obj[$i] = "<tr><td>".$record['userid']."</td><td>".$record['login']."</td><td>".$record['password']."</td><td>".$record['name']."</td><td>".$record['email']."</td><td>".$country['name']."</td><td>".$city['name']."</td><td>".$record['createdon']."</td><td>".$record['createdby']."</td><td>$admin</td><td><button class='edit' name='edit' value='".$record['userid']."' onclick='editUser(".$record['userid'].")'>Edit</button></td> <td><button class='delete' name='delete' value='".$record['userid']."' onclick='deleteUser(".$record['userid'].");' >DELETE</button></td></tr>";
                    
                        $i++;
                        }
                }
                return $obj;
}

function getAllRolesGrid($con)
{
    $sql="select * from roles";
     $obj=[];
                $result= mysqli_query($con, $sql);
                $rows= mysqli_num_rows($result);
                if($rows>0)
                {
                    $i=0;
                    while($record= mysqli_fetch_assoc($result))
                    {
                        $obj[$i] = "<tr><td>".$record['roleid']."</td><td>".$record['name']."</td><td>".$record['description']."</td><td>".$record['createdon']."</td><td>".$record['createdby']."</td><td><button name='edit' value='".$record['roleid']."' onclick='editRole(".$record['roleid'].");'>Edit</button></td> <td><button name='delete' value='".$record['roleid']."' onclick='deleteRole(".$record['roleid'].");'>DELETE</button></td></tr>";
                    
                        $i++;
                    }
                }
                return $obj;
}


function getAllPermissionGrid($con)
{
    $sql="select * from permissions";
     $obj=[];
                $result= mysqli_query($con, $sql);
                $rows= mysqli_num_rows($result);
                if($rows>0)
                {
                    $i=0;
                    while($record= mysqli_fetch_assoc($result))
                    {
                        $obj[$i] = "<tr><td>".$record['permissionid']."</td><td>".$record['name']."</td><td>".$record['description']."</td><td>".$record['createdon']."</td><td>".$record['createdby']."</td><td><button name='edit' value='".$record['permissionid']."' onclick='editPermission(".$record['permissionid'].");'>Edit</button></td> <td><button name='delete' value='".$record['permissionid']."' onclick='deletePermission(".$record['permissionid'].");'>DELETE</button></td></tr>";
                    
                        $i++;
                    }
                }
                return $obj;
}

function getRolePermissionGrid($con)
{
    $sql="select * from role_permission";
    $obj=[];
                $result= mysqli_query($con, $sql);
                $rows= mysqli_num_rows($result);
                if($rows>0)
                {
                    $i=0;
                    while($record= mysqli_fetch_assoc($result))
                    {
                        $roleid=$record['roleid'];
                        $permissionid=$record['permissionid'];
                        $query1="select * from roles where roleid='$roleid'";
                        $query2="select * from permissions where permissionid='$permissionid'";
                        $r1= mysqli_query($con, $query1);
                        $r2= mysqli_query($con, $query2);
                        $role= mysqli_fetch_assoc($r1);
                        $permission= mysqli_fetch_assoc($r2);
                        
                         $obj[$i]= "<tr><td>".$role['name']."</td><td>".$role['description']."</td><td>".$permission['name']."</td><td>".$permission['description']."</td><td><button name='edit' value='".$record['id']."' onclick='editRolePermission(".$record['id'].");'>Edit</button></td> <td><button name='delete' value='".$record['id']."' onclick='deleteRolePermission(".$record['id'].");'>DELETE</button></td></tr>";
                    
                         $i++;
                    }
                }
               return $obj;
}


function getUserRoleGrid($con)
{
     $sql="select * from user_role";
       $obj=[];
                $result= mysqli_query($con, $sql);
                $rows= mysqli_num_rows($result);
                if($rows>0)
                {
                    $i=0;
                    while($record= mysqli_fetch_assoc($result))
                    {
                        $roleid=$record['roleid'];
                        $userid=$record['userid'];
                        
                        $query1="select * from roles where roleid='$roleid'";
                        $query2="select * from users where userid='$userid'";
                        $r1= mysqli_query($con, $query1);
                        $r2= mysqli_query($con, $query2);
                        $role= mysqli_fetch_assoc($r1);
                        $user= mysqli_fetch_assoc($r2);
                        
                        $obj[$i]= "<tr><td>".$role['name']."</td><td>".$user['login']."</td><td><button type='submit' name='edit' value='".$record['id']."' onclick='editUserRole(".$record['id'].");'>Edit</button></td> <td><button name='delete' value='".$record['id']."' onclick='DeleteUserRole(".$record['id'].");'>DELETE</button></td></tr>";
                    
                        $i++;
                    }
                }
                return $obj;
}
?>
