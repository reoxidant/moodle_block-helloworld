<?php

require_once('../../config.php');

$courseid = required_param('courseid', PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$confirm = optional_param('confirm', 0, PARAM_INT);

if(!$course = $DB->get_record('course', array('id' => $courseid))){
    print_error('invalidcourse', 'block_helloworld', $courseid);
}

require_login($course);
require_capability('block/helloworld:manapages', context_course::instance($courseid));
if(!$helloworldpage = $DB->get_record('block_helloworld', array('id' => $id))){
    print_error('nopage', 'block_helloworld', '', $id);
}

$site = get_site();
$PAGE->set_url('/blocks/helloworld/view.php', array('id' => $id, 'courseid' => $courseid));
$heading = $site->fullname . "::" . $course->shortname . "::" . $helloworldpage->pagetitle;
$PAGE->set_heading($heading);
if(!$confirm){
    $optionsno = new moodle_url('/course/view.php', array('id' => $courseid));
    $optionsyes = new moodle_url('/blocks/helloworld/delete.php', array('id' => $id, 'courseid' => $courseid, 'confirm' => 1, 'sesskey' => sesskey()));
    echo $OUTPUT->confirm(get_string('deletepage', 'block_helloworld', $helloworldpage->pagetitle), $optionsyes, $optionsno);
} else {
    if(config_sesskey()){
        if(!$DB->delete_records('block_helloworld', array('id' => $id))){
            print_error('sessionerror', 'block_helloworld');
        }else{
            print_error('sessionerror', 'block_helloworld');
        }
        $url = new moodle_url('/course/view.php', array('id' => $courseid));
        redirect($url);
    }
}