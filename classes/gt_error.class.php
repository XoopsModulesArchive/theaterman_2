<?php
class gt_error
{
    public $text;

    public $type;

    public $system;

    public $log;

    public $types;

    public $level;

    public function __construct()
    {
        $this->text = '';

        $this->type = 'warning';

        $this->set_system('errorhandler.class');

        $this->set_level('warning fatal');

        $this->types[] = 'fatal';

        $this->types[] = 'warning';

        $this->types[] = 'notice';

        $this->types[] = 'debug';
    }

    public function set_system($input)
    {
        $this->system = $input;

        return(1);
    }

    public function set_level($input)
    {
        $this->level = explode(' ', $input);

        return(1);
    }

    public function new_error($type, $text)
    {
        global $gt_page;

        if (in_array($type, $this->types, true)) {
            $this->type = $type;
        } else {
            $this->type = 'warning';
        }

        $this->text = $text;

        $this->log[] = [
        'system' => $this->system,
        'text' => $this->text,
        'type' => $this->type,
      ];

        if (in_array($this->type, $this->level, true)) {
            echo $this->return_last_error();
        }

        if ('fatal' == $this->type) {
            echo '/nscript terminated by gt_error';

            $this->dump_file('cache/gt_error.log');

            $gt_page->print_footer();

            exit();
        }

        return(1);
    }

    public function return_last_error()
    {
        $system = $this->system;

        $type = $this->type;

        $text = $this->text;

        return("<div><b>$system</b>: <i>$type</i>: $text</div>");
    }

    public function print_error_log_type($types)
    {
        $types2 = $types;

        $types = explode(' ', $types);

        echo "/n<div><b>Error Log for <i>$types2</i> Type(s):</b></div>";

        foreach ($this->log as $error) {
            if (in_array($error['type'], $types, true)) {
                echo '/n<div><b>' . $error['system'] . '</b>: <i>' . $error['type'] . '</i>: ' . $error['text'] . '</div>';
            }
        }
    }

    public function print_error_log_system($types)
    {
        $system = $types;

        $types = explode(' ', $types);

        echo "/n<div><b>Error Log for <i>$system</i> System(s):</b></div>";

        foreach ($this->log as $error) {
            if (in_array($error['system'], $types, true)) {
                echo '/n<div><b>' . $error['system'] . '</b>: <i>' . $error['type'] . '</i>: ' . $error['text'] . '</div>';
            }
        }
    }

    public function dump_file($filename)
    {
        $file = fopen($filename, 'ab');

        fwrite($file, "\n" . date('r', time()));

        foreach ($this->log as $error) {
            fwrite($file, "\n  " . $error['system'] . ': ' . $error['type'] . ': ' . $error['text']);
        }

        fclose($file);

        echo '/nerror log dump initiated';
    }
}
