<?php
$json = '{"adapt_url":"http://page.renren.com/601531781","image_lmobile":"http://a3.att.hudong.com/08/31/01000000000000119093168703508.jpg","content":"今晚将会有两个影片上映，一个是《导盲犬小Q》","begin_time":"2013-05-24 19:30:00","address":"iLibrary电影放映","owner":"iLibrary Space"}';
$get = file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/1/");
$get = file_get_contents("http://nanyang.xjtu.edu.cn:8080/young/");

#echo $json;
#echo $get;
$get =  str_replace("&quot;",'"',$get);
echo $get;
$new = json_decode($get);
echo $new->events[0]->title;
?>
