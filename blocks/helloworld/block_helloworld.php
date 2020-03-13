<?php
defined('MOODLE_INTERNAL') || die();

class block_helloworld extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_helloworld');
    }

    public function get_content()
    {
        global $COURSE, $DB;
        if ($this->content !== NULL) {
            return $this->content;
        }
        
        $this->content = new stdClass;
        $this->content->text = $this->config->text ? $this->config->text : '<h4>'.get_string('helloworld:defaultblocktext','block_helloworld').'</h4>';

        if($helloworldpages = $DB->get_record('block_helloworld', array('blockid' =>  37))){
            $this->content->text .= html_writer::start_tag('ul');
            foreach ($helloworldpages as $helloworldpage){
                $pageurl = new moodle_url(
                    '/blocks/helloworld/view.php',
                    array(
                         'blockid' => 37,
                         'courseid' => $COURSE->id,
                         'id' => $helloworldpages->id,
                         'viewpage' => '1'
                    )
                );
                $this->content->text .= html_writer::start_tag('li');
                $this->content->text .= html_writer::link($pageurl, $helloworldpages->title);
                $this->content->text .= html_writer::end_tag('li');
            }
            $this->content->text .= html_writer::end_tag('ul');
        }

        $url = new moodle_url('/blocks/helloworld/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
        $this->content->footer = html_writer::link($url, get_string('addpage', 'block_helloworld'));
        return $this->content;
    }

    public function specialization()
    {
        if ($this->config) {
            //let's set up the block title
            $this->title = $this->config->title ? $this->config->title : get_string('helloworld:defaultblocktitle', 'block_helloworld');
        }
    }

    public function html_attributes()
    {
        $attributes = parent::html_attributes();
        if (get_config('helloworld', 'Colored_Text')) {
            $attributes['class'] .= ' colored-text';
        }
        return $attributes;
    }

    public function instance_allow_multiple()
    {
        return true;
    }

    public function has_config()
    {
        return true;
    }
}
