<?php
class gt_data
{
    public $path;

    public $prefix;

    public function __construct()
    {
        $this->set_path('cache/');

        $this->set_prefix('gt_data_');
    }

    public function set_path($input)
    {
        $this->path = $input;

        return(1);
    }

    public function set_prefix($input)
    {
        $this->prefix = $input;

        return(1);
    }

    public function read($name)
    {
        $fname = $this->path . $this->prefix . $name . '.gtdat';

        if (is_file($fname)) {
            //echo "\n<div>reading $fname</div>";

            $data = file($fname);

            $data = implode('', $data);

            $data = unserialize($data);

            if (!is_array($data)) {
                return(0);
            }

            return($data);
        }  

        //echo "\n<div>not found: $fname</div>";

        $data = [];

        //$this->write($name,$data);

        return($data);
    }

    public function write($name, $data)
    {
        $name = gt_textsan::filename($name);

        $fname = $this->path . $this->prefix . $name . '.gtdat';

        //echo "\n<div>writing $fname</div>";

        $backup = $this->read($name);

        if (!is_array($data)) {
            $data = [];
        }

        $data = data_clean($data);

        $data = serialize($data);

        $file = fopen($fname, 'w+b');

        fwrite($file, $data);

        fclose($file);

        if (!is_array($this->read($name))) {
            echo "\n<div>Data file not written correctly, restoring backup</div>";

            $this->write($name, $backup);
        }

        return(1);
    }

    public function print_editor($name)
    {
        $data = $this->read($name);

        $vnames[0] = '';

        function data_deep($level, $input, $vnames)
        {
            $space = '&nbsp;';

            $bullet = '&nbsp;';

            for ($i = 0; $i < $level; $i++) {
                $struc .= $space;
            }

            echo "\n<tr><td colspan=2>$struc$bullet" . $vnames[$level] . '</td></tr>';

            foreach ($input as $q => $w) {
                if (!is_array($w)) {
                    $vname = 'gt_data';

                    foreach ($vnames as $e => $r) {
                        if ('' != $r) {
                            $vname .= "['$r']";
                        }
                    }

                    $vname .= "['$q']";

                    $w = gt_textsan::sanitize($w);

                    echo "\n<tr><td>$struc$space$bullet<b>$q</b>:</td><td><input type=text name=\"$vname\" value='$w'></td></tr>";
                } else {
                    //echo "<div>$struc|_$q</div>";

                    $vnames[$level + 1] = $q;

                    data_deep($level + 1, $w, $vnames);
                }
            }

            return(1);
        }

        echo "\n<form action=main.php method=post><table>";

        echo "\n<tr><td colspan=2><i>Set values to {null} (with brackets) to remove fields</i></td></tr>";

        echo "\n<input type=hidden name=dir value='system/gt_data/recieve_editor.php'>";

        echo "\n<input type=hidden name=file value='$name'>";

        data_deep(1, $data, $vnames);

        echo "\n<tr><td><b>Advanced</b>:</td><td><input type=text name=custom_key>=<input type=text name=custom_value></td></tr>";

        echo "\n</table><input type=submit></form>";
    }

    public function recieve_editor()
    {
        $file = var_retrieve('file');

        $data = var_retrieve('gt_data');

        if (!is_array($data)) {
            $data = [];
        }

        $vnames[] = '';

        function data_deep($level, $input, $vnames)
        {
            $space = '&nbsp;';

            $bullet = '&nbsp;';

            global $code;

            for ($i = 0; $i < $level; $i++) {
                $struc .= $space;
            }

            if (!is_array($input)) {
                $input['gt_killme'] = 'remove this field';
            }

            //echo "\n<tr><td colspan=2>$struc$bullet".$vnames[$level]."</td></tr>";

            foreach ($input as $q => $w) {
                if (!is_array($w)) {
                    $vname = '$new_data';

                    foreach ($vnames as $e => $r) {
                        if ('' != $r) {
                            $vname .= "[$r]";
                        }
                    }

                    $vname .= "[$q]";

                    if ('{null}' != $w) {
                        //echo "\n".stripslashes($vname)." = \"".stripslashes($w)."\"; ";

                        $code .= "\n" . stripslashes($vname) . ' = "' . $w . '"; ';

                    //echo "\n".$level.$code;
                    } else {
                        gt_alert::new_alert(1, "removing field <i>$vname</i>");

                        foreach ($vnames as $value) {
                            echo '<div>' . stripslashes($value) . '</div>';
                        }
                    }
                } else {
                    //echo "<div>$struc|_$q</div>";

                    $vnames[$level + 1] = $q;

                    data_deep($level + 1, $w, $vnames);
                }
            }

            return(1);
        }

        $array[0] = 'test';

        unset($array[0]);

        echo count($array);

        global $code, $gt_data;

        data_deep(1, $data, $vnames);

        $custom_key = stripslashes(var_retrieve('custom_key'));

        $custom_value = var_retrieve('custom_value');

        if (eregi('\[', $custom_key)) {
            $code .= "\n\$new_data$custom_key = \"$custom_value\";";
        }

        include gt_customcode::run($code);

        $gt_data->write($file, $new_data);
    }

    public function insert($name, $new_data)
    {
        $old_data = $this->read($name);

        function gt_insert_deep($old, $new)
        {
            foreach ($new as $key => $value) {
                if (is_array($old[$key]) or is_array($new[$key])) {
                    $old[$key] = gt_insert_deep($old[$key], $new[$key]);
                } else {
                    $old[$key] = $new[$key];
                }
            }

            return($old);
        }

        $updated = gt_insert_deep($old_data, $new_data);

        $file = var_retrieve('file');

        $this->write($file, $updated);
    }
}
