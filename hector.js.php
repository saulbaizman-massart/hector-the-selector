<?php
// Send JavaScript headers.
header('Content-Type: text/javascript');
?>

<?php 
// Load tasks from JSON file, convert to JavaScript array

require_once ('shared.php') ;

// echo '/*' ;
// var_dump($tasks_json) ;
// echo '*/' ;

?>

let debug = true ;

if ( debug ) {
    console.info ('debug is enabled.') ;
}

// Global variable used in multiple functions.
let current_task_number = false ;

// create an array with the task numbers, line numbers, and correct selector
let tasks = [] ; // new empty array of tasks

<?php

$task_counter = 0 ;
foreach ( $tasks_json->tasks as $task ) {

    $task_description = $task->task ;
    $selector = $task->selector ;
    $lines = $task->line_numbers ;

    // FIXME: revisit stripping double quotes from task description
    // FIXME: revisit stripping double quotes from selector, which makes it incorrect
    printf ( 
        'tasks[%1$d] = { "description": "%2$s", "selector": "%3$s", "lines": [ %4$s ] } ; ' . PHP_EOL, 
        $task_counter, // array index 
        str_replace('"', "", $task_description ), // description
        str_replace('"', "", $selector ), // selector (answer)
        implode ( ',', $lines ) // array of line numbers
    ) ;

    $task_counter++ ;
}

?>

let correct_answers = [] ;

jQuery(document).ready ( function ( ) {

    // attach on click listener to validate button
    jQuery('input#validate').on('click', function (event) {

        if ( current_task_number != false ) {
            if ( debug ) {
                console.log ( 'validate button clicked') ;
            }

            let user_selector = jQuery('input#selector').val() ;
            if ( debug ) {
                console.log ( 'user selector:', user_selector ) ;
            }
            // https://stackoverflow.com/questions/1981349/regex-to-replace-multiple-spaces-with-a-single-space
            // condense all spaces into one space from user input, and lowercase the input.
            user_selector = user_selector.toLowerCase().replace(/  +/g, ' ') ;
            if ( debug ) {
                console.log ('user_selector:',user_selector) ;
            }

            // condense all spaces into one space from the correct answer, and lowercase the correct answer.
            let correct_answer = tasks[current_task_number].selector.toLowerCase().replace(/  +/g, ' ') ;
            if ( debug ) {
                console.log ('correct_answer:',correct_answer) ;
            }

            // Correct answer.
            if ( user_selector == correct_answer ) {
                // FIXME: create an animated green checkmark in the center of the screen.
                alert ( "That's correct. Nice job!" ) ;
                correct_answers[current_task_number] = user_selector ;
                // Change the CSS class for the task to completed.
                jQuery ( 'div#tasks p.task_' + current_task_number ).addClass ( 'completed' ) ;
            }
            // Incorrect answer.
            else {
                // FIXME: do something other than an alert dialogue box.
                alert ( 'Not quite. Try again!' ) ;
                // Clear the field? Eh, no, leave it alone.
                // In fact, maybe we save and list the history of incorrect attempts.
            }

        }
        else {
            alert ('Please choose a task first.') ;
        }
    } ) ;

} ) ;

function choose_task ( task_number ) {

    current_task_number = task_number ;

    if ( debug ) {
        console.log ("requested task:", task_number) ;
        console.log ("description:",tasks[task_number].description) ;
    }

    // Unhighlight any highlighted task number.
    jQuery ('div#tasks p.task_description').removeClass ('selected_task') ;

    // Highlight the clicked task number.
    jQuery ('div#tasks p.task_'+task_number).addClass ('selected_task') ;

    // First usage: replace the placeholder instructional text with the requested task description.
    // Subsequent usages: replace the existing task description with the requested task description.
    jQuery('div#task_description p').html ( tasks[task_number].description ) ;

    // Unhighlight all lines in the source code.
    jQuery('div#code div#code_browser p.source').removeClass('highlighted_source') ;

    if ( debug ) {
        console.log ('line array:',tasks[task_number].lines) ;
        console.log ('line array length:',tasks[task_number].lines.length) ;
    }

    // Highlight the relevant lines in the source code.
    for ( line = 0 ; line < tasks[task_number].lines.length; line++) {
        jQuery('div#code div#code_browser p.source.line_'+tasks[task_number].lines[line]).addClass('highlighted_source') ;
    }

    // Clear the input field.
    jQuery('input#selector').val( '' ) ;

    // If this task has already been completed, insert the selector into the input field.
    if ( correct_answers[task_number] ) {
        jQuery('input#selector').val( correct_answers[task_number] ) ;
    }

}

