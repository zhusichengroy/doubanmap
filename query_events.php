<?php

$events = file_get_contents('https://api.douban.com/v2/event/list?loc=beijing&day_type=today&type=film');
echo $events;

?>