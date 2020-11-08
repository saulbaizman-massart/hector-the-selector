<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hector the selector</title>
    <link rel="stylesheet" href="hector.css" type="text/css">
</head>
<body>
    <!-- <div id="minimap"></div> -->
    <h1>hector the selector</h1>

    <?php

    require_once ('shared.php') ;

    ?>
    <div id="main">

        <!-- div#clues -->
        <div id="tasks">
            <p class="task_label">task</p>
            <?php

            $task_counter = 0 ;
            foreach ( $tasks_json->tasks as $task ) {
                printf ( '<p class="task_%2$s task_description"><a href="javascript:choose_task(\'%2$s\')">%1$s</a></p>',($task_counter+1),$task_counter) ; // %1$02d for two-digit zero-prepended "01" formatting
            
                $task_counter++ ;
            }
            // var_dump($tasks_json);


            ?>    
        <!-- end div#clues -->
        </div>    
    
        <!-- div#code -->
        <div id="code">
            <div id="code_browser">
                <?php 

                $line_number = 1 ;
                foreach ( $tree_contents as $number => $line ) {
                    // skip empty lines.
                    if ( empty ( $line ) ) {
                        continue ;
                    }
                    
                    $tab_count = substr_count ( $line, "\t") ;
                    $line = trim ($line) ; // remove all whitespace
                    $paragraph_classes = [] ;
                    $paragraph_classes[] = 'source' ;
                    $paragraph_classes[] = sprintf('line_%s',$line_number );
                    $paragraph_classes[] = sprintf('indentation_level_%s',$tab_count );
                    printf ('<p class="line_number">%1$s</p><p class="%4$s"> %2$s</p>', $line_number, $line, $tab_count, implode ( ' ', $paragraph_classes ) ) ;
                    print "\n" ;
                    
                    $line_number++ ;
                }
                
                ?>

            </div>

            <div id="task_description">
                <p>Click a task number in the left column.</p>
            </div>

            <div id="input_fields">
                <!-- no form tag needed -->
                <input type="text" id="selector" placeholder="Enter selector">
                <input type="button" id="validate" value="validate">
            </div>
    
        <!-- end div#code -->
        </div>

    </div>
    <p class="beta_tester">Thanks to Chloe A. for beta testing.</p>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Local scripts -->
    <script src="hector.js.php"></script>
 
</body>
</html>