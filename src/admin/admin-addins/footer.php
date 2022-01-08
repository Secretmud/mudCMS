<?php 
function mem() {
    $mem = memory_get_usage();
    switch($mem) {
        case $mem < 1024:
            echo $mem." Bytes";
            break;
        case $mem < 1048576:
            echo round($mem/1024,2)." KB";
            break;
        default:
            echo round($mem/1048576,2)." MB";
            break;
    }
}

mem();
