<?php
include 'DB.php';
$course = DB::select("SELECT * FROM courses");
$query = DB::select("SELECT * FROM queries");
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Course assignemnt</title>
</head>

<body>
    <div class="container ">
        <div class="row p-5 text-center">
            <div class="col-12">
                <button class="btn btn-success" id="toggleBtn">Show Queris</button>
            </div>
        </div>

        <div class="container-fluid query">
            <div class="row bg-dark alert text-white">
                <div class="col-1">Sr. NO</div>
                <div class="col-1">Name</div>
                <div class="col-3">Email</div>
                <div class="col-6">Query</div>
                <div class="col-1">Status</div>
            </div>
            <?php
            $sr = 1;
            foreach ($query as $list) {
                echo "
                <div class='row border p-1'>
                <div class='col-1'>$sr</div>
                <div class='col-1'>$list[name]</div>
                <div class='col-3' >$list[email]</div>
                <div class='col-6'>$list[query] </div>
                <div class='col-1'>$list[status] </div>
            </div>
                ";
                $sr++;
            }

            ?>
        </div>

        <div class="container-fluid course border">
            <div class="row bg-dark alert text-white">
                <div class="col-1">Sr. NO</div>
                <div class="col-2">Course Name</div>
                <div class="col-7">Details</div>
                <div class="col-2">Action</div>
            </div>
            <?php
            $sr = 1;
            foreach ($course as $list) {
                echo "
                <div class='row border p-1'>
                <div class='col-1'>$sr</div>
                <div class='col-2'>$list[name]</div>
                <div class='col-8' >$list[description]</div>
                <div class='col-1'>
                    <a href='#query_form' class='btn btn-secondary mt-4 query-btn' data-id='$list[id]'>Query</a>
                </div>
            </div>
                ";
                $sr++;
            }

            ?>

        </div>

        <div class="container-fluid mt-5 p-2 border bg-dark text-white rounded" id="query_form" hidden>
            <div class="row">
                <div class="col-12 text-center text-secondary">
                    <h1>Query form</h1>
                </div>
            </div>
            <div class="row">
                <form action="">
                    <div class="form-group m-1">
                        <input type="hidden" name="id" id="course_id">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group m-1">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="form-group m-1">
                        <textarea style="resize: none;" rows="5" cols="12" class="form-control" placeholder="Enter your query" id="input_query"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="alert  text-danger input-error"></div>
                    </div>
                    <div class="form-group m-1 text-center">
                        <button class="btn btn-success form-control p-3" id="add_query" style="width: 50%;">Submit</button>
                        <button id="resetForm" type="reset" hidden></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var inputError = $(".input-error");

        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
        $(document).ready(function() {

            // init stage
            $(".query").hide();

            $(document).on("click", ".query-btn", function() {
                $("#query_form").removeAttr("hidden");
                var id = $(this).data("id");
                $("#course_id").val(id);
            })


            $("#add_query").click(function() {
                var id = $("#course_id").val();
                var name = $("#name").val();
                var email = $("#email").val();
                var query = $("#input_query").val();
                if (id != '') {
                    if (name != '') {
                        if (isEmail(email)) {
                            if (query != '') {
                                $.ajax("ajaxReq.php", {
                                    type: "POST",
                                    data: {
                                        'id': id,
                                        'name': name,
                                        'email': email,
                                        'query': query
                                    },
                                    success: function(data) {
                                        alert("Query submitted !");
                                        $("#resetForm").click();
                                        $("#query_form").hide();
                                    },
                                    error: function(data) {
                                        alert("data can not be submitted !");
                                    }
                                });
                            } else {
                                inputError.html("Please enter the query");
                            }
                        } else {
                            inputError.html("Please enter valide email");
                        }
                    } else {
                        inputError.html("Please enter the name");
                    }
                } else {
                    inputError.html("Please refresh the page and try again");
                }

            })

            // Show and hide queries
            $("#toggleBtn").click(function() {
                var btn = $("#toggleBtn");
                if (btn.html() == 'Show Queris') {
                    btn.html("Show Course");
                    $(".course").hide();
                    $(".query").show();
                } else {
                    btn.html("Show Queris");
                    $(".course").show();
                    $(".query").hide();
                }
            });

            // ready functions end
        })
    </script>
</body>

</html>