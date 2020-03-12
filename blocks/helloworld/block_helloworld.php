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
        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = $this->config->text ? $this->config->text : '<h4>'.get_string('helloworld:defaultblocktext','block_helloworld').'</h4>';
        $this->content->footer = '<p><i>'.get_string('helloworld:defaultblockfooter', 'block_helloworld').'</i></p>';
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
