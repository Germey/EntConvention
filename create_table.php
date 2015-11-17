<?php
/**
 * Created by PhpStorm.
 * User: Jia
 * Date: 2015/11/8
 * Time: 23:18
 */

/*
require_once('initsql.php');

for($i=1;$i<=200;$i++){
    $id=md5($i);
    $sql="INSERT INTO ticket (id,kind) VALUES ('{$id}',1)";
    var_dump(mysqli_query($con,$sql));
    echo $sql.'<br>';
}

for($i=201;$i<=1000;$i++){
    $id=md5($i);
    $sql="INSERT INTO ticket (id,kind) VALUES ('{$id}',2)";
    var_dump(mysqli_query($con,$sql));
    echo $sql.'<br>';
}

for($i=1001;$i<=2500;$i++){
    $id=md5($i);
    $sql="INSERT INTO ticket (id,kind) VALUES ('{$id}',3)";
    var_dump(mysqli_query($con,$sql));
    echo $sql.'<br>';
}


for($i=2501;$i<=4000;$i++){
    $id=md5($i);
    $sql="INSERT INTO ticket (id,kind) VALUES ('{$id}',4)";
    var_dump(mysqli_query($con,$sql));
    echo $sql.'<br>';
}

for($i=4001;$i<=5500;$i++){
    $id=md5($i);
    $sql="INSERT INTO ticket (id,kind) VALUES ('{$id}',5)";
    var_dump(mysqli_query($con,$sql));
    echo $sql.'<br>';
}
