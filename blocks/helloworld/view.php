<?php

require_once('../../config.php');
require_once('helloworld_form.php');

global $DB, $OUTPUT, $PAGE;
// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);

$blockid = required_param('blockid', PARAM_INT);

$id = optional_param('id', 0, PARAM_INT);

$viewpage = optional_param('viewpage', false, PARAM_BOOL);

//breadcrumb
$settingsnode = $PAGE->settingsnav->add(get_string('helloworldsettings', 'block_helloworld'));

$editurl = new moodle_url('/block/hello/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));

$editnode = $settingsnode->add(get_string('editpage', 'block_helloworld'), $editurl);

$editnode->make_active();

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_helloworld', $courseid);
}

require_login($course);

$PAGE->set_url('/blocks/helloworld/view.php', array('id' => $courseid));
$PAGE->set_pagelayout('standart');
$PAGE->set_heading(get_string('edithtml', 'block_helloworld'));

$helloworld = new helloworld_form();

$toform['blockid'] = $blockid;
$toform['courseid'] = $courseid;
$toform['id'] = $id;

$helloworld->set_data($toform);

if ($helloworld->is_cancelled()) {
    // Cancelled forms redirect to the course main page.
    $couseurl = new moodle_url('/course/view.php', array('id' => $id));
    redirect($courseurl);
} else if ($fromform = $helloworld->get_data()) {
    // We need to add code to appropriately act on and store the submitted data
    // but for now we will just redirect back to the course main page.
    if($fromform->id != 0){
        if(!$DB->update_record('block_helloworld', $fromform)){
            print_error('updateerror', 'block_helloworld');
        }
    }else{
        if (!$DB->insert_record('block_helloworld', $fromform)) {
            print_error('inserterror', 'block_helloworld');
        }
    }
    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($courseurl);
} else {
    // form didn't validate or this is the first display
    //$site = get_site();
    echo $OUTPUT->header();
    if ($id) {
        $helloworldpage = $DB->get_record('block_helloworld', array('id' => $id));
        if($viewpage){ //read only mode
            block_helloworld_print_page($helloworldpage);
        }else{
            $helloworld->set_data($helloworldpage);
            $helloworld->display();
        }
    } else {
        $helloworld->display();
    }
    echo $OUTPUT->footer();
}





