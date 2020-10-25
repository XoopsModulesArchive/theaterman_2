<?php
class gt_alert
{
    public function new_alert($yn, $text)
    {
        global $gt_alert;

        //echo "<div><i>$yn</i>: $text</div>";

        $gt_alert[] = "<div><i>$yn</i>: $text</div>";
    }

    public function print_alerts()
    {
        global $gt_alert;

        if (is_array($gt_alert)) {
            foreach ($gt_alert as $alert) {
                echo (string)$alert;
            }
        }
    }
}
