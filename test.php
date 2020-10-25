<?php
include 'classes/gt_textsan.class.php';
  echo '<pre>' . gt_textsan::html_to_ubb("  <i>
  foo
  bar
  </i>
  shouldn't be
  touched
  <b>
  foo
  bar 2
  </b>
  <i>also shouldn't be touched</i>") . '</pre>';
