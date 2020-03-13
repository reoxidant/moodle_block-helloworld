<?php

function pre($arr, $bool = false, $die = false)
{
    if ($bool && $die) {
        echo "<pre>";
        var_dump($arr);
        die($die);
        echo "</pre>";
    } else if ($bool && !$die) {
        echo "<pre>";
        var_dump($arr);
        echo "</pre>";
    }
}

function block_helloworld_images()
{
    return array(
        html_writer::tag('img', '', array('alt' => get_string('red', 'block_helloworld'), 'src' => "pix/picture0.gif")),
        html_writer::tag('img', '', array('alt' => get_string('blue', 'block_helloworld'), 'src' => 'pix/picture1.gif')),
        html_writer::tag('img', '', array('alt' => get_string('green', 'block_helloworld'), 'src' => 'pix/picture1.gif')),
    );
}

function block_helloworld_print_page($helloworld, $return = false)
{
    global $OUTPUT, $COURSE;
    $display = $OUTPUT->heading($helloworld->title);
    $display .= $OUTPUT->box_start();
    if ($helloworld->date) {
        $display .= html_writer::start_tag('div', array('class' => 'helloworld date'));
        $display .= userdate($helloworld->date);
        $display .= html_writer::end_tag('div');
    }
    $display .= clean_text($helloworld->text);
    if ($helloworld->filename) {
        $display .= $OUTPUT->box_start();
        $display .= $helloworld->filename;
        $display .= html_writer::start_tag('p');
        $display .= clean_text($helloworld->description);
        $display .= html_writer::end_tag('p');
        $display .= $OUTPUT->box_end();
    }

    //close the box
    $display .= $OUTPUT->box_end();
    if ($return) {
        return $display;
    } else {
        echo $display;
    }
}