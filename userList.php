<?php
header('Content-Type:text/html;charset=utf-8');

$type = $_GET['type'];
$page = $_GET['page'];
$userId = $_GET['userId'];
$name = $_GET['name'];
$sex = $_GET['sex'];
$age = $_GET['age'];
$phone = $_GET['phone'];

// 连接数据库
$link = mysqli_connect('localhost','root','root','gp03');
if (!$link) {
    echo '{"err":-1,"msg":"连接失败"}';
    die();
}

if ($type === 'page') {
    // 查询所有数据条数
    $all_sql = "select * from user";
    $all_res = mysqli_query($link,$all_sql);
    // 数据总条数
    $total = mysqli_affected_rows($link);

    // 每一页的起始位置，每一页8条数据
    $start = ($page-1)*8; 
    // 查询当前页码的数据
    $page_sql = "select * from user order by id limit $start,8";
    $page_res = mysqli_query($link,$page_sql);
    $page_arr = mysqli_fetch_all($page_res,1);
    $data = json_encode($page_arr);//把phps数组转换成json字符串
    if (count($page_arr) > 0) {
        echo '{"err":1,"msg":"分页数据","total":'.$total.',"data":'.$data.'}';
    } else {
        echo '{"err":0,"msg":"暂无数据","total":"","data":""}';
    }
} else if($type === 'update') {
    // 更新数据sql语句
    $update_sql = "update user set name='$name',sex='$sex',age='$age',phone='$phone' where id='$userId'";
    $update_res = mysqli_query($link,$update_sql);
    $num = mysqli_affected_rows($link);
    if ($num > 0) {
        echo '{"err":1,"msg":"修改成功"}';
    } else {
        echo '{"err":0,"msg":"修改失败"}';
    }
} else if($type === 'add') {
	//添加数据sql语句
	$add_sql = "insert into user(name,sex,age,phone) values ('$name','$sex','$age','$phone')";
	$add_res = mysqli_query($link,$add_sql);
	$num = mysqli_affected_rows($link);
	if($num > 0) {
		echo '{"err":1,"msg":"添加成功"}';
	} else {
		echo '{"err":0,"msg":"添加失败"}';
	}
} else if($type === 'delete') {
	//删除数据sql语句
	$del_sql = "delete from user where id = '$userId'";
	$add_res = mysqli_query($link,$del_sql);
	$num = mysqli_affected_rows($link);
	if($num > 0) {
		echo '{"err":1,"msg":"删除成功"}';
	} else {
		echo '{"err":0,"msg":"删除失败"}';
	}
}
else {
    echo '{"err":0,"msg":"参数错误"}';
}
mysqli_close($link);
?>