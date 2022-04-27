<?php
    require_once("../crud/php/component.php");
    require_once("../crud/php/operation.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yugioh-card database</title>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://kit.fontawesome.com/5c6520a52b.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../crud/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>


</head>
<body>
<main>
    <div class="container text-center">
        <h1 class="py-4 bg-dark text-light rounded">
            <i class="fas fa-swatchbook"></i>
            Yugioh-card
        </h1>
             
        <div class="d-flex justify-content-center">
        <style>
        #preview{
        width: 420px;
        height: 400px;
        margin:0px auto;
        }
        </style>
        <video id="preview"></video>
        <script type="text/javascript">
        var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
        Instascan.Camera.getCameras().then(function (cameras){
            if(cameras.length>0){
              scanner.start(cameras[0]);
                 $('[name="options"]').on('change',function(){
                     if($(this).val()==1){
                       if(cameras[0]!=""){
                        scanner.start(cameras[0]);
                    }else{
                        alert('No Front camera found!');
                    }
                }else if($(this).val()==2){
                    if(cameras[1]!=""){
                        scanner.start(cameras[1]);
                    }else{
                        alert('No Back camera found!');
                    }
                }
            });
        }else{
            console.error('No cameras found.');
            alert('No cameras found.');
        }
    }).catch(function(e){
        console.error(e);
        alert(e);
    });
</script>
            <form action=""method="post"class="w-50">
                <div class="pt-2">
                    <?php inputElement(icon:"ID",placeholder:"Card ID",name:"card_id",value:"")?>
                </div>
                <div class="pt-2">
                    <?php inputElement(icon:"Name",placeholder:"Card Name",name:"card_name",value:"")?>
                </div>
                <div class="pt-2">
                    <?php inputElement(icon:"Type",placeholder:"Card Type",name:"card_type",value:"")?>
                </div>
                <div class="row pt-2">
                    <div class="col">
                        <?php inputElement(icon:"Set",placeholder:"Set",name:"card_set",value:"")?>
                    </div>
                    <div class="col">
                        <?php inputElement(icon:"$",placeholder:"Price",name:"price",value:"")?>                  
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <?php buttonElement("btn-create","btn btn-success","<i class='fas fa-plus'></i>","create","dat-toggle='tooltip' data-placement='bottom' title='Create'") ?>
                    <?php buttonElement("btn-read","btn btn-primary","<i class='fas fa-sync'></i>","read","dat-toggle='tooltip' data-placement='bottom' title='Read'") ?>
                    <?php buttonElement("btn-update","btn btn-light border","<i class='fas fa-pen-alt'></i>","update","dat-toggle='tooltip' data-placement='bottom' title='Update'") ?>
                    <?php buttonElement("btn-delete","btn btn-danger","<i class='fas fa-trash-alt'></i>","delete","dat-toggle='tooltip' data-placement='bottom' title='Delete'") ?>
                    <?php deleteBtn()?>
                </div>
                
            </form>
        </div>
        <script>
        scanner.addListener('scan',function(c){
            let myArray=c.split("\n");
            let id=$("input[name*='id']");
            let cardname = $("input[name*='card_name']");
            let cardtype = $("input[name*='card_type']");
            let cardset = $("input[name*='card_set']");
            let price = $("input[name*='price']");
            if (isNaN(myArray[0])){
                echo("QR code is not legal");
                
            }
            else{
                id.val(myArray[0]);
                cardname.val("");
                cardtype.val("");
                cardset.val("");
                price.val("");
                let table=document.getElementById('tbody'),rIndex;
                for (var i =0; i<table.rows.length;i++){
                    if (table.rows[i].cells[0].innerHTML==myArray[0]){
                        id.val(table.rows[i].cells[0].innerHTML);
                        cardname.val(table.rows[i].cells[1].innerHTML);
                        cardtype.val(table.rows[i].cells[2].innerHTML);
                        cardset.val(table.rows[i].cells[3].innerHTML);
                        price.val(table.rows[i].cells[4].innerHTML.replace("$", ""));    
                    }
                }
            }
            
            
        });
        </script>
        
        <!--Bootstrap table-->
        <div class="d-flex table-data">
            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Card Name</th>
                        <th>Card Type</th>
                        <th>Set</th>
                        <th>Price</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php
                    if(isset($_POST['read']) || isset($_POST['create']) || isset($_POST['delete'])|| isset($_POST['update'])){
                        $result=getData();
                        if($result){
                            while($row=mysqli_fetch_assoc($result)){?>
                            <tr>
                               <td data-id="<?php echo $row['id'];?>"><?php echo $row['id']?></td>
                               <td data-id="<?php echo $row['id']?>"><?php echo $row['card_name']?></td> 
                               <td data-id="<?php echo $row['id']?>"><?php echo $row['card_type']?></td> 
                               <td data-id="<?php echo $row['id']?>"><?php echo $row['card_set']?></td> 
                               <td data-id="<?php echo $row['id']?>"><?php echo '$'. $row['price']?></td>
                               <td ><i class="fas fa-edit btnedit" data-id="<?php echo $row['id']?>"></i></td>
                            </tr> 
                        <?php
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</main>   

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="../crud/php/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>