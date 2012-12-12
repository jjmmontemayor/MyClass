<?php

include "hello.php";

$h = new hello();


$date = $h->date();

echo $date."<br/>";

sleep(10);

$date2 = $h->date();
echo $date2;

?>
