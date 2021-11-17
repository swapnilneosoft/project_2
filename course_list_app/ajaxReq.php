<?php
    include 'DB.php';

    if(!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['query']))
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $query = $_POST['query'];
        DB::query("INSERT INTO `queries` (`id`, `name`, `email`, `query`, `status`, `course_id`) VALUES (NULL, '$name', '$email', '$query', '1', '$id')");
    }
    
?>