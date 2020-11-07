<?php

define ( 'TREE', 'tree.txt' ) ;
define ( 'TASKS', 'tasks.json' ) ;

if ( file_exists ( TREE ) ) {
    // load the tree into a string
    $tree_contents = file ( TREE ) ;

}
else {
    die ( sprintf ( '<p>Error: I could not locate %s. Exiting...</p>', TREE ) ) ;
}

if ( file_exists ( TASKS ) ) {
    // load the tree into a string
    $tasks = file_get_contents ( TASKS ) ;
    $tasks_json = json_decode ( $tasks ) ;
}
else {
    die ( sprintf ( '<p>Error: I could not locate %s. Exiting...</p>', TASKS ) ) ;
}
