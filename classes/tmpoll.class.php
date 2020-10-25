<?php
class pollman
{
    public function __construct()
    {
    }
}
  class tmpoll
  {
      public function __construct()
      {
          global $gt_data, $theaterman;

          $this->config = $gt_data->read('pollconfig');

          if (1 == $this->config['frun']) {
              $this->polls = $gt_data->read('polls');
          }
      }
  }
