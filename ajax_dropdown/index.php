<?php
include 'DB.php';
$category = DB::select('SELECT * FROM category');

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Product assignment</title>
</head>

<body>

    <div class="container mt-3">
        <h1>Filters</h1>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="category">Select Category</label>
                    <select class="form-control" name="category" id="category">
                        <option value="">--Select</option>
                        <?php
                        foreach ($category as $cat) {
                            echo "<option value='$cat[id]'>$cat[name]</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="sub_category">Select Sub Category</label>
                    <select class="form-control" name="sub_category" id="sub_category" disabled>
                        <option value="">--Select </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="container p-3 bg-light">
            <div class="row">
                <div class="col-12">
                    <h3>Products</h3>
                </div>
            </div>
            <div class="row bg-white p-3 border " id="product-list">
                <div class="text-center text-secondary">
                    NO DATA
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function displayList() {
            $cat = $('#category').val();;
            $sub = $('#sub_category').val();
            if ($cat != '' && $sub != '') {
                $.ajax("ajaxReq.php", {
                    type: "POST",
                    data: {
                        'sub_id': $sub
                    },
                    success: function(data) {
                        $('#product-list').html(data);
                    }
                });
            } else {
                alert("please select category and sub category to product list");
            }
        }

       


        $(document).ready(function() {

            $('#category').change(function() {
                $val = $('#category').val();
                if ($val != '') {
                    $.ajax("ajaxReq.php", {
                        type: "POST",
                        data: {
                            'cat_id': $val
                        },
                        success: function(data) {
                            $("#sub_category").removeAttr("disabled");
                            $('#sub_category').html(data);
                        }
                    });
                }
            });

            $('#sub_category').change(function() {
                $val = $('#sub_category').val();
                if ($val != '') {
                    $.ajax("ajaxReq.php", {
                        type: "POST",
                        data: {
                            'sub_id': $val
                        },
                        success: function(data) {
                            $('#product-list').html(data);
                        }
                    });
                }
            })



 

            

            
        });
    </script>
</body>

</html>