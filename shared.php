<?php

define ( 'TREE', 'tree.txt' ) ;
define ( 'TASKS', 'tasks.json' ) ;

if ( file_exists ( TREE ) ) {
    // Load the tree into a string.
    $tree_contents = file ( TREE ) ;

}
else {
    die ( sprintf ( '<p>Error: I could not locate %s. Exiting...</p>', TREE ) ) ;
}

if ( file_exists ( TASKS ) ) {
    // Load the tasks JSON into a string and then decode it, saving it as an object.
    $tasks = file_get_contents ( TASKS ) ;
    $tasks_json = json_decode ( $tasks ) ;
}
else {
    die ( sprintf ( '<p>Error: I could not locate %s. Exiting...</p>', TASKS ) ) ;
}
