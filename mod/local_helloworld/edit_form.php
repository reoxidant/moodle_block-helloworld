<?php
class helloworld_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // A sample string variable with a default value.
        $mform->addElement('text', 'config_text', get_string('helloworld:contentinputlabel', 'helloworld'));
        $mform->setDefault('config_text', 'default value');
        $mform->setType('config_text', PARAM_RAW);
    }
}