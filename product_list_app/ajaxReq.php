<?php
include 'DB.php';
if (isset($_POST['cat_id'])) {
    $id = $_POST['cat_id'];
    $data = DB::select("SELECT  * FROM sub_category WHERE cat_id = $id");
    echo "<option value=''>Select --</option>";
    foreach ($data as $cat) {
        echo "<option value='$cat[id]'>$cat[name]</option>";
    }
}

if (isset($_POST['sub_id'])) {
    $id = $_POST['sub_id'];
    $data = DB::select("SELECT  * FROM product WHERE sub_cat_id = $id");
    if ($data) {
        foreach ($data as $prod) {
            echo "<div class='col-md-4 p-1 '>
            <div class='card'>
                <div class='card-header bg-white'>
                    $prod[name]
                </div>
                <div class='card-body'>
                    <p>
                       $prod[description]
                    </p>
                    <p>
                        Price : <b>$prod[price]</b>
                    </p>
                </div>
                <div class='card-footer bg-white text-center'>
                    <button class='btn btn-danger delete-btn' data-id='$prod[id]'>Delete</button>
                    <a href='javascript:void(0);' class='btn btn-success update-btn' data-id='$prod[id]'>Update</a>
                </div>
            </div>
        </div>";
        }
    }else{
        echo '<div class="text-center text-danger">
        NO DATA
    </div>';
    }
}

if (isset($_POST['del_id'])) {
    $id = $_POST['del_id'];
    print_r(DB::query("DELETE FROM `product` WHERE `id` = $id"));
}

if(isset($_POST['addProd']) && !empty($_POST['name']) && !empty($_POST['descr']) && !empty($_POST['cat']) && !empty($_POST['sub_cat']) && !empty($_POST['price']))
{
    $name = $_POST['name'];
    $descr = $_POST['descr'];
    $cat = $_POST['cat'];
    $sub_cat = $_POST['sub_cat'];
    $price = $_POST['price'];
    DB::query("INSERT INTO product(`name`,`price`,`description`,`sub_cat_id`) VALUES('$name','$price','$descr','$sub_cat')");
    
}

if(isset($_POST['updateProd']) && !empty($_POST['name']) && !empty($_POST['descr']) && !empty($_POST['cat']) && !empty($_POST['sub_cat']) && !empty($_POST['price']) && !empty($_POST['id']))
{
    $id =$_POST['id'];
    $name = $_POST['name'];
    $descr = $_POST['descr'];
    $cat = $_POST['cat'];
    $sub_cat = $_POST['sub_cat'];
    $price = $_POST['price'];
    DB::query("UPDATE product SET `name`='$name',`description`='$descr',`sub_cat_id`='$sub_cat',`price`='$price'  WHERE id = $id");
    
}

if(isset($_POST['getUpdate']) && !empty($_POST['id']))
{   $id = $_POST['id'];
    $data = DB::selectOne("SELECT * FROM product where id=$id");
    print_r(json_encode($data));
}
