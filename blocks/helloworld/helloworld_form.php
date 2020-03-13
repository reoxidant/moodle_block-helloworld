<?php

require_once("{$CFG->libdir}/formslib.php");
require_once($CFG->dirroot . '/blocks/helloworld/lib.php');

class helloworld_form extends moodleform
{
    function definition()
    {
        $mform =& $this->_form;

        $mform->addElement('header', 'displayinfo', get_string('textfields', 'block_hellowroild'));

        $mform->setType('title', PARAM_RAW);

        $mform->addRule('title', null, 'required', null, 'client');

        $mform->addElement('htmleditor', 'text', get_string('displayedhtml', 'block_helloworld'));

        $mform->addElement('header', 'optional', get_string('optional', 'form'), null, false);

        $mform->addElement('date_time_selector', 'date', get_string('date', 'block_helloworld'), array('optional' => true));

        $mform->setAdvanced('optional');
        $mform->addElement('hidden', 'blockid');
        $mform->addElement('hidden', 'courseid');
        $this->add_action_buttons();
    }
}