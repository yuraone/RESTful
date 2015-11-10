<?php
if (isset($_POST['name']) === true && empty($_POST['name']) === false){
    require '../db/connect.php';
    $name = $_POST['name'];

//    $sql = "SELECT description FROM msgs WHERE title = $name ";
//    SELECT 'msgs'.'description'
//    FROM 'msgs'
//    WHERE 'msgs'.'title'= '" . mysqli_real_escape_string($link,trim($_POST['name'])) ."'";
//    $query = mysqli_query($link,$sql);
//    $news=mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM `news`;"));
//    echo $news[0];
//    echo(mysqli_num_rows($query) !== false) ? mysql_result($query,0,'description') : 'Title not found';

//    $sql = "SELECT *
//            FROM msgs";
//            $result = mysqli_query($link,$sql);
//            $arr = array();
//
//            while ($row = mysqli_fetch_assoc($result)) {
//            $arr[] = $row;
//    }
//    var_dump($result);
//              mysqli_free_result($result);

    $sql = "DELETE
            FROM msgs
            WHERE id = $name";

    $result = mysqli_query($link,$sql);


    echo json_encode(['status' => 'ok']);
            //mysqli_free_result($result);
}