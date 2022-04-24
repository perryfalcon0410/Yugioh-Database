<?php
require_once("db.php");
require_once("component.php");

$con = Createdb();

//Create button click

if(isset($_POST['create'])){
    createData();
}

if(isset($_POST['update'])){
    updateData();
}
if(isset($_POST['delete'])){
    deleteRecord();
}
if(isset($_POST['deleteall'])){
    deleteAll();  
}
function createData(){
    $cardid=textboxValue('card_id');
    $cardname = textboxValue('card_name');
    $cardtype = textboxValue('card_type');
    $cardset = textboxValue('card_set');
    $price = textboxValue('price');

    if($cardname && $cardtype && $cardset && $price){
        if($cardid){
            $sql="INSERT INTO yugioh (id, card_name, card_type, card_set, price)
            VALUES ('$cardid','$cardname','$cardtype','$cardset','$price')";
        }else{
            $sql="INSERT INTO yugioh (card_name, card_type, card_set, price)
            VALUES ('$cardname','$cardtype','$cardset','$price')";
        }
        
        if(mysqli_query($GLOBALS['con'],$sql)){
            TextNode("success","Record successfully Inserted");
        }else{
            TextNode("error","Error");
        }
    }else{
        TextNode("error","Provide Data in the Textbox");
    }
   
   
}
function textboxValue($value){
    $textbox=mysqli_real_escape_string($GLOBALS['con'],trim($_POST[$value]));
    if(empty($textbox)){
        return false;
    }else{
        return $textbox;
    }
    
}

//messages
function TextNode($classname, $msg){
    $element ="<h6 class='$classname'>$msg</h6>";
    echo $element;
}

//get data from mysql database
function getData(){
    $sql="SELECT * FROM yugioh";
    $result = mysqli_query($GLOBALS['con'],$sql);

    if (mysqli_num_rows($result)>0){
        return $result;
    }
}
//update data
function UpdateData(){
    $cardid=textboxValue('card_id');
    $cardname = textboxValue('card_name');
    $cardtype = textboxValue('card_type');
    $cardset = textboxValue('card_set');
    $price = textboxValue('price');

    if($cardname && $cardtype && $cardset && $price){
        $sql="
            UPDATE yugioh SET card_name='$cardname', card_type='$cardtype', card_set='$cardset', price='$price' WHERE id='$cardid';
        ";
        if(mysqli_query($GLOBALS['con'],$sql)){
            TextNode("success","Data Successfully Updated");
        }else{
            TextNode("error","Unable to Update Data");
        }
    }else{
        TextNode("error","Select Data using Edit Icon");
    }

}

function deleteRecord(){
    $cardid=(int)textboxValue('card_id');
    $sql="DELETE FROM yugioh WHERE id='$cardid'";

    if(mysqli_query($GLOBALS['con'],$sql)){
        TextNode("success","Record Delete Successfully...!");
    }else{
        TextNode("error","Unable to delete record");
    }

}

function deleteBtn(){
    $result=getData();
    $i =0;
    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $i++;
            if($i>=3){
                buttonElement("btn-deleteAll","btn btn-danger","<i class='fas fa-trash'></i> Delete All","deleteall","");
                return;
            }
        }
    }

}
function deleteAll(){
    $sql = "DROP TABLE yugioh";
    if(mysqli_query($GLOBALS['con'],$sql)){
        TextNode("success","All Record Delete Successfully...!");
        createDb();
    }else{
        TextNode("error","Unable to delete record");
    }
}
//setID to textbox
function setID(){
    $getid=getData();
    $id=0;
    if($getid){
        while($row=mysqli_fetch_assoc($getid)){
            $id=$row['id'];
        }
    }
    return ($id+1);

}

