<?php

require_once('../../config.php');
require_once('helloworld_form.php');

global $DB, $OUTPUT, $PAGE;
// Check for all required variables.
$courseid = required_param(
    'courseid',
    PARAM_INT
);
//breadcrumb
$blockid = optional_param(
  'blockid',
  PARAM_INT
);

$viewpage = optional_param(
  'viewpage',
    false,
    PARAM_BOOL
);

$id = optional_param(   'id', 0, PARAM_INT);

$settingsnode = $PAGE->settinsnav->add(
    get_string(
        'helloworldsettings',
        'block_helloworld'
    )
);

$editurl = new moodle_url(
    '/block/hello/view.php',
    array(
        'id' => $id,
        'courseid' => $courseid,
        'blockid' => $blockid
    )
);

$editnode = $settingsnode->add(
    get_string(
    'editpage',
    'block_helloworld'
    ),
    $editurl
);

$editnode->make_active();

if(!$course = $DB->get_record('course', array('id'=>$courseid))){
    print_error('invalidcourse','block_helloworld', $courseid);
}

require_login($course);

$PAGE->set_url('/blocks/helloworld/view.php', array('id'=> $courseid));
$PAGE->set_pagelayout('standart');
$PAGE->set_heading(
    get_string(
        'edithtml',
        'block_helloworld'
    )
);

$helloworld = new helloworld_form();

$toform['blockid'] = $blockid;
$toform['courseid'] = $courseid;

$helloworld->set_data($toform);

if($helloworld->is_cancelled()){
    // Cancelled forms redirect to the course main page.
    $couseurl = new moodle_url('/course/view.php', array('id' => $id));
    redirect($courseurl);
}else if ($fromform = $helloworld->get_data()){
    // We need to add code to appropriately act on and store the submitted data
    // but for now we will just redirect back to the course main page.
    if(!$DB->insert_record('block_helloworld', $fromform)){
        print_error('inserterror', 'block_helloworld');
    }

    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($courseurl);
}else{
    // form didn't validate or this is the first display
    $site = get_site();
    echo $OUTPUT->header();
    if($viewpage){
        $helloworld = $DB->get_record('block_helloworld', array('id' => $id));
        block_helloworld_print_page($helloworldpage);
    }else{
        $helloworld->display();
    }
    echo $OUTPUT->footer();
}





