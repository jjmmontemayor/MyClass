<?php
$link = peb_pconnect('jenn3@192.168.1.105',  'myclass');

if (!$link) {
    die('Could not connect: ' . peb_error());
}
echo 'Connected successfully';
?>