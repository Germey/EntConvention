<?php
/**
 * Created by PhpStorm.
 * User: Jia
 * Date: 2015/11/8
 * Time: 1:48
 */

$con = mysqli_connect("localhost", "futree", "Futree2015","wx_ticket","3306");
if (!$con)
{
    die('Could not connect: '.mysqli_connect_error());
}
mysqli_set_charset($con,'utf8');