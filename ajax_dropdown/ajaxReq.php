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
                    <button class='btn btn-success form-control' >Add to cart</button>                   
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




