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
    <div class="container bg-light p-3">
        <h1>Add Product</h1>
        <form action="">
            <div class="row p-3">
                <div class="col-6">
                    <div class="form-group">
                        <input type="hidden" name="" id="update_id">
                        <label for="prod_name">Product Name</label>
                        <input type="text" class="form-control" id="prod_name">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="prod_dis">Descriptiobn</label>
                        <textarea class="form-control" name="" id="prod_dis" cols="" rows="2" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="form_category">Product Category</label>
                        <select class="form-control" name="category" id="form_category">
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
                        <label for="form_sub_category">Product Sub Category</label>
                        <select class="form-control" name="category" id="form_sub_category" disabled>
                            <option value="">--Select</option>

                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group p-3 mt-2">
                        <button class="btn btn-success form-control" type="button" id="add_prod">Add</button>
                        <button class="btn btn-warning form-control" type="button" hidden id="update_prod">Update</button>
                        <button type="reset" hidden id="resetForm"></button>
                    </div>
                </div>
                <div class="col-12" id="error_form">

                </div>
            </div>
        </form>
    </div>

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

        function resetForm() {
            $('#resetForm').click();
            $('#add_prod').removeAttr("disabled");
            $('#update_prod').attr("disabled", true);
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



            $(document).on("click", ".update-btn", function() {
                $prod_id = $(this).data("id");
                $.ajax("ajaxReq.php", {
                    type: "POST",
                    data: {
                        'id': $prod_id,
                        'getUpdate': true,
                    },
                    success: function(data) {

                        // console.log(data[id]);

                        var data = JSON.parse(data);
                        console.log(data)
                        $("#prod_name").val(data['name']);
                        $("#prod_dis").val(data['description']);
                        $("#price").val(data['price']);
                        $("#update_id").val(data['id']);
                        $("#add_prod").attr("hidden", true);
                        $("#update_prod").removeAttr("hidden");

                    }
                })
            })
            $(document).on("click", ".delete-btn", function() {
                var id = $(this).data("id");
                console.log(id);
                $.ajax("ajaxReq.php", {
                    type: "POST",
                    data: {
                        'del_id': id
                    },
                    success: function(data) {

                        displayList();
                    },
                    error: function(err) {
                        console.log(err)
                    }
                });
            });

            // Add product form



            $("#form_category").change(function() {
                $val = $('#form_category').val();
                if ($val != '') {
                    $.ajax("ajaxReq.php", {
                        type: "POST",
                        data: {
                            'cat_id': $val
                        },
                        success: function(data) {
                            $("#form_sub_category").removeAttr("disabled");
                            $('#form_sub_category').html(data);
                        }
                    });
                }
            });

            $("#add_prod").click(function() {
                var name = $("#prod_name").val();
                var descr = $("#prod_dis").val();
                var cat = $("#form_category").val();
                var sub_cat = $("#form_sub_category").val();
                var price = $("#price").val();
                if (name != '' && descr != '' && cat != '' && sub_cat != '' && price != '') {

                    $("#error_form").html("");
                    $.ajax("ajaxReq.php", {
                        type: "POST",
                        data: {
                            'addProd': true,
                            'name': name,
                            'descr': descr,
                            'cat': cat,
                            'sub_cat': sub_cat,
                            'price': price
                        },
                        success: function(data) {
                            $("#error_form").addClass(" alert alert-success");
                            $("#error_form").html("Product has been added !");
                            $("#error_form").fadeOut(4000);
                            $("#resetForm").click();
                            if ($("#sub_category").val() != '') {
                                displayList();
                            }
                        }

                    })

                } else {
                    $("#error_form").addClass(" alert alert-danger");
                    $("#error_form").html("Please check all fields . All fields are required !");
                    $("#error_form").fadeOut(4000);
                }
            })

            $("#update_prod").click(function() {
                var name = $("#prod_name").val();
                var id = $("#update_id").val();
                var descr = $("#prod_dis").val();
                var cat = $("#form_category").val();
                var sub_cat = $("#form_sub_category").val();
                var price = $("#price").val();
                if (name != '' && descr != '' && cat != '' && sub_cat != '' && price != '' && id != '') {

                    $("#error_form").html("");
                    $.ajax("ajaxReq.php", {
                        type: "POST",
                        data: {
                            'updateProd': true,
                            'id': id,
                            'name': name,
                            'descr': descr,
                            'cat': cat,
                            'sub_cat': sub_cat,
                            'price': price
                        },
                        success: function(data) {
                            $("#error_form").addClass("alert alert-success");
                            $("#error_form").html("Product has been updated !");
                            $("#error_form").fadeOut(4000);

                            $('#add_prod').removeAttr("disabled");
                            $('#update_prod').attr("disabled", true);
                            if ($("#sub_category").val() != '') {
                                displayList();
                            }
                        }

                    })

                } else {
                    $("#error_form").addClass(" alert alert-danger");
                    $("#error_form").html("Please check all fields . All fields are required !");
                    $("#error_form").fadeOut(4000);
                }
            })
        });
    </script>
</body>

</html>