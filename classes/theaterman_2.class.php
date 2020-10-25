<?php
//  ------------------------------------------------------------------------ //
//             THEATERMAN 2 - PERFORMANCE LISTING MANAGER                    //
//                  Copyright (c) 2000 Joby Elliott                          //
//                   <http://www.greentinted.net>                           //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Joby Elliott (AKA Hober)                                          //
// URL: www.greentinted.net, pas.nmt.edu, greentinted.ods.org                //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
  class theaterman
  {
      // name of data files

      public $name;

      // configuration

      // next_id

      // location

      // season

      // show

      // sponsor

      public $config;

      // locations

      // [name] = name

      // [directions] = driving directions

      public $locations;

      // seasons

      // [year] = year i.e. 2003-2004

      // [name] = name i.e. subscription

      public $seasons;

      // shows

      // [title] = title of show

      // description = description of show

      // price = price of show

      // presspack = 1/0 (has *.zip press package?)

      // sponsors

      // [] = sponsor id

      // instance

      // [date] = date (UNIX timestamp)

      // [location] = location id

      // [season] = season id

      // [extra] = extra info, appears above to description

      public $shows;

      // sponsors

      // name = name

      // url = link to sponsor, will be ignored if null or http://

      // image = 1/0 (has image?)

      public $sponsors;

      // location_order - stores order to display locations in

      // [id] = id

      public $location_order;

      // season_order - stores order to display seasons in

      // [id] = id

      public $season_order;

      // constructor--------------------------------------------------------------

      public function __construct($name)
      {
          global $gt_data, $gt_cache, $gt_textsan, $gt_error;

          if (is_object($gt_data) && is_object($gt_cache) && is_object($gt_textsan) && is_object($gt_error)) {
              // all objects present, begin loading data

              $this->name = $name;

              $this->config = $this->read('config');

              $this->locations = $this->read('locations');

              foreach ($this->locations as $key => $value) {
                  $this->locations[$key]['name'] = gt_textsan::sanitize($value['name']);

                  $this->locations[$key]['directions'] = gt_textsan::sanitize($value['directions']);
              }

              $this->seasons = $this->read('seasons');

              foreach ($this->seasons as $key => $value) {
                  $this->seasons[$key]['year'] = gt_textsan::sanitize($value['year']);

                  $this->seasons[$key]['name'] = gt_textsan::sanitize($value['name']);
              }

              $this->shows = $this->read('shows');

              foreach ($this->shows as $key => $value) {
                  $this->shows[$key]['title'] = gt_textsan::sanitize($value['title']);

                  $this->shows[$key]['description'] = gt_textsan::sanitize($value['description']);

                  $instance = $value['instance'];

                  foreach ($instance as $ikey => $ivalue) {
                      $this->shows[$key]['instance'][$ikey]['extra'] = gt_textsan::sanitize($ivalue['extra']);
                  }
              }

              $this->sponsors = $this->read('sponsors');

              foreach ($this->sponsors as $key => $value) {
                  $this->sponsors[$key]['name'] = gt_textsan::sanitize($value['name']);
              }

              $this->location_order = $this->read('location_order');

              $this->season_order = $this->read('season_order');

              // just in case data files don't exist, save changes

              $this->save_all();
          } else {
              // objects are missing

              gt_alert::new_alert(0, 'all required objects are not present');
          }
      }

      // new_instance_form--------------------------------------------------------

      // prints a form to add a new instance to show $id

      public function new_instance_form($id)
      {
          ?>
        <form action=? method=get>
        <div><?php printf(_TM_ADDININST, $id, $this->shows[$id]['title']); ?></div>
        <input type=hidden name=step value=finish>
        <input type=hidden name=show value=<?php echo $id; ?>>
        <table>
          <tr><td><b><?php echo _TM_DATE; ?>:</b></td><td>
            <select size=1 name=month>
              <option value=01><?php echo _TM_JANUARY; ?></option>
              <option value=02><?php echo _TM_FEBRUARY; ?></option>
              <option value=03><?php echo _TM_MARCH; ?></option>
              <option value=04><?php echo _TM_APRIL; ?></option>
              <option value=05><?php echo _TM_MAY; ?></option>
              <option value=06><?php echo _TM_JUNE; ?></option>
              <option value=07><?php echo _TM_JULY; ?></option>
              <option value=08><?php echo _TM_AUGUST; ?></option>
              <option value=09><?php echo _TM_SEPTEMBER; ?></option>
              <option value=10><?php echo _TM_OCTOBER; ?></option>
              <option value=11><?php echo _TM_NOVEMBER; ?></option>
              <option value=12><?php echo _TM_DECEMBER; ?></option>
            </select>
            <select size=1 name=day>
              <option value=01>1</option>
              <option value=02>2</option>
              <option value=03>3</option>
              <option value=04>4</option>
              <option value=05>5</option>
              <option value=06>6</option>
              <option value=07>7</option>
              <option value=08>8</option>
              <option value=09>9</option>
              <option value=10>10</option>
              <option value=11>11</option>
              <option value=12>12</option>
              <option value=13>13</option>
              <option value=14>14</option>
              <option value=15>15</option>
              <option value=16>16</option>
              <option value=17>17</option>
              <option value=18>18</option>
              <option value=19>19</option>
              <option value=20>20</option>
              <option value=21>21</option>
              <option value=22>22</option>
              <option value=23>23</option>
              <option value=24>24</option>
              <option value=25>25</option>
              <option value=26>26</option>
              <option value=27>27</option>
              <option value=28>28</option>
              <option value=29>29</option>
              <option value=30>30</option>
              <option value=31>31</option>
            </select>
            <select size=1 name=year>
              <?php
                $now = date('Y', time());

          for ($i = $now + 5; $i >= $now - 5; $i--) {
              echo "\n              <option";

              if ($i == $now) {
                  echo ' selected';
              }

              echo ">$i</option>";
          }

          echo "\n"; ?>
            </select>
          </td></tr>
          <tr><td><b><?php echo _TM_TIME; ?>:</b></td><td>
            <select size=1 name=hour>
              <option value=01>1</option>
              <option value=02>2</option>
              <option value=03>3</option>
              <option value=04>4</option>
              <option value=05>5</option>
              <option value=06>6</option>
              <option value=07>7</option>
              <option value=08>8</option>
              <option value=09>9</option>
              <option value=10>10</option>
              <option value=11>11</option>
              <option value=12>12</option>
            </select>:<select size=1 name=minute>
              <option value=00>00</option>
              <option value=15>15</option>
              <option value=30>30</option>
              <option value=45>45</option>
            </select>
            <select size=1 name=meridium>
              <option value=12>pm</option>
              <option value=00>am</option>
            </select></td></tr>
          <tr><td><b><?php echo _TM_SEASON; ?>:</b></td><td><?php $this->listbox('seasons', 0); ?></td></tr>
          <tr><td><b><?php echo _TM_LOCATION; ?>:</b></td><td><?php $this->listbox('locations', 0); ?></td></tr>
          <tr><td><b><?php echo _TM_EXTRAINFO; ?>:</b></td><td><textarea rows=5 cols=40 name=extra></textarea></td></tr>
          <tr><td></td><td><input type=submit value="<?php echo _TM_SUBMIT; ?>"></td></tr>
        </table>
        </form>
      <?php
      }

      // new_show_form------------------------------------------------------------

      // prints a form to create a new show

      public function new_show_form()
      {
          ?>
        <form action=? method=get>
        <input type=hidden name=step value=finish>
        <div><?php echo _TM_ADDINSHOW; ?></div>
        <table>
          <tr><td><b><?php echo _TM_TITLE; ?>:</b></td><td><input type=text name='title'></td></tr>
          <tr><td><b><?php echo _TM_DESC; ?>:</b></td><td><textarea rows=5 cols=40 name='description'></textarea></td></tr>
          <tr><td><b><?php echo _TM_PRICE; ?>:</b></td><td><input type=text name='price'></td></tr>
          <tr><td><b><?php echo _TM_WEBSITE; ?>:</b></td><td><input type=text name='website'></td></tr>
          <tr><td><b><?php echo _TM_SPONSORS; ?>:</b></td><td><?php $this->listbox('sponsors', 0); ?></td></tr>
          <tr><td></td><td><input type=submit value="<?php echo _TM_SUBMIT; ?>"></td></tr>
        </table>
        </form>
      <?php
      }

      // new_instance-------------------------------------------------------------

      // prints new instance form and recieves it afterwards

      public function new_instance()
      {
          $step = var_retrieve('step');

          $show = var_retrieve('show');

          switch ($step) {
        case 'finish':
          $mm = var_retrieve('month');
          $dd = var_retrieve('day');
          $yyyy = var_retrieve('year');
          $merediem = var_retrieve('meridium');
          $hh = var_retrieve('hour');
          if (12 == $hh) {
              if (12 == $merediem) {
                  $merediem = 0;
              } else {
                  $merediem = 12;
              }
          }
          $hh += $merediem;
          if ($hh < 10) {
              $hh = "0$hh";
          }
          $mi = var_retrieve('minute');
          $date = "$mm/$dd/$yyyy $hh:$mi";
          $location = var_retrieve('location');
          $season = var_retrieve('season');
          $extra = var_retrieve('extra');
          $this->add_instance($show, $date, $location, $season, $extra);
          break;
        default:
          $this->new_instance_form($show);
      }
      }

      // add_instance-------------------------------------------------------------

      // adds new instance information and saves all

      // import date as NON-TIMESTAMP mm/dd/yyyy hh:mm (24 hour time!)

      public function add_instance($parent, $date, $location, $season, $extra)
      {
          if (isset($this->shows[$parent])) {
              if (!isset($this->config['next_id']['instance'])) {
                  $this->config['next_id']['instance'] = 1;

                  $nid = 1;
              } else {
                  $nid = $this->config['next_id']['instance'];
              }

              $checked = 1;

              if (!isset($this->locations[$location])) {
                  gt_alert::new_alert(0, "The location id $location does not exist");

                  $checked = 0;
              }

              if (!isset($this->seasons[$season])) {
                  gt_alert::new_alert(0, "The season id $season does not exist");

                  $checked = 0;
              }

              $newinstance['date'] = $this->stampfromdate($date);

              $newinstance['location'] = $location;

              $newinstance['season'] = $season;

              $newinstance['extra'] = $extra;

              if (1 == $checked) {
                  $this->shows[$parent]['instance'][$nid] = $newinstance;

                  $this->config['next_id']['instance'] = $nid + 1;

                  $this->save_all();

                  gt_alert::new_alert(1, "New instance $nid added for show $parent");

                  return($nid);
              }  

              gt_alert::new_alert(0, 'New instance creation encountered errors');
          } else {
              gt_alert::new_alert(0, "Show id $parent is not set");
          }
      }

      // update_instance----------------------------------------------------------

      // adds new instance information and saves all

      // import date as NON-TIMESTAMP mm/dd/yyyy hh:mm (24 hour time!)

      public function update_instance($id, $date, $location, $season, $extra)
      {
          $parent = 0;

          foreach ($this->shows as $sid => $sdat) {
              if (isset($sdat['instance'][$id])) {
                  $parent = $sid;
              }
          }

          if (0 != $parent) {
              $checked = 1;

              if (!isset($this->locations[$location])) {
                  gt_alert::new_alert(0, "The location id $location does not exist");

                  $checked = 0;
              }

              if (!isset($this->seasons[$season])) {
                  gt_alert::new_alert(0, "The season id $season does not exist");

                  $checked = 0;
              }

              $newinstance['date'] = $this->stampfromdate($date);

              $newinstance['location'] = $location;

              $newinstance['season'] = $season;

              $newinstance['extra'] = $extra;

              if (1 == $checked) {
                  $this->shows[$parent]['instance'][$id] = $newinstance;

                  $this->save_all();

                  gt_alert::new_alert(1, "Instance $id ($parent) was updated");

                  return(1);
              }  

              gt_alert::new_alert(0, 'Instance update encountered errors');

              return(0);
          }  

          gt_alert::new_alert(0, "Show id $parent is not set");
      }

      // new_show-----------------------------------------------------------------

      // prints new show form and recieves it afterwards

      public function new_show()
      {
          $step = var_retrieve('step');

          switch ($step) {
        case 'finish':
          $sponsors = var_retrieve('sponsors');
          $description = var_retrieve('description');
          $title = var_retrieve('title');
          $price = var_retrieve('price');
          $url = var_retrieve('website');
          $nid = $this->add_show($title, $description, $sponsors, $price, $url);
          printf('<p>' . _TM_SHOWADDED . '</p>', $nid, $nid);
          break;
        default:
          $this->new_show_form();
      }
      }

      // remove_show--------------------------------------------------------------

      // removes a show and all instances of it, then saves all

      public function remove_show($id)
      {
          if (isset($this->shows[$id])) {
              unset($this->shows[$id]);

              $slot = -1;

              while ($slot < 10) {
                  $slot++;

                  $sid = $slot;

                  if (file_exists("../cache/images/sh_$id" . '_' . "$sid.jpg")) {
                      unlink("../cache/images/sh_$id" . '_' . "$sid.jpg");

                      echo "<div>$slot <i>../cache/images/sh_$id" . '_' . "$sid.jpg</i></div>";
                  }
              }
          }

          $this->save_all();
      }

      // add_show-----------------------------------------------------------------

      // adds new show information and saves all

      public function add_show($title, $description, $sponsors, $price, $url)
      {
          if (!isset($this->config['next_id']['show'])) {
              $this->config['next_id']['show'] = 1;
          }

          $nid = $this->config['next_id']['show'];

          $newshow['title'] = $title;

          $newshow['description'] = $description;

          if (!is_array($sponsors)) {
              $sponsors = [];

              $sponsors[] = 'x';
          }

          $newshow['sponsors'] = $sponsors;

          $newshow['price'] = $price;

          $newshow['url'] = $url;

          $newshow['instance'] = [];

          $newshow['presspack'] = 0;

          $this->shows[$nid] = $newshow;

          $this->config['next_id']['show'] = $nid + 1;

          $this->save_all();

          return($nid);
      }

      // insert_sponsor-----------------------------------------------------------

      // adds a sponsor and saves all data

      public function insert_sponsor($name, $link)
      {
          if (!isset($this->config['next_id']['sponsor'])) {
              $this->config['next_id']['sponsor'] = 1;
          }

          $nid = $this->config['next_id']['sponsor'];

          $newsponsor['name'] = $name;

          $newsponsor['link'] = $link;

          $newsponsor['image'] = 0;

          $this->sponsors[$nid] = $newsponsor;

          $this->config['next_id']['sponsor'] = $nid + 1;

          $this->save_all();

          return($nid);
      }

      // insert_season------------------------------------------------------------

      // adds a season and saves all data

      public function insert_season($year, $name)
      {
          if (!isset($this->config['next_id']['season'])) {
              $this->config['next_id']['season'] = 1;

              $nid = 1;
          } else {
              $nid = $this->config['next_id']['season'];
          }

          $new['year'] = $year;

          $new['name'] = $name;

          $this->seasons[$nid] = $new;

          $this->config['next_id']['season'] = $nid + 1;

          $this->bump_season($nid);

          $this->save_all();

          return($nid);
      }

      // insert_location----------------------------------------------------------

      // adds a location and saves all data

      public function insert_location($name, $directions)
      {
          if (!isset($this->config['next_id']['location'])) {
              $this->config['next_id']['location'] = 1;

              $nid = 1;
          } else {
              $nid = $this->config['next_id']['location'];
          }

          $new['name'] = $name;

          $new['directions'] = $directions;

          $this->locations[$nid] = $new;

          $this->config['next_id']['location'] = $nid + 1;

          $this->bump_location($nid);

          $this->save_all();

          return($nid);
      }

      // print_datebox------------------------------------------------------------

      // prints a set of 3 boxes

      // listbox------------------------------------------------------------------

      // makes a listbox for the specified field

      public function listbox($field, $show)
      {
          switch ($field) {
        case 'seasons':
          echo "\n<select size=5 name='season'>";
          $all = $this->season_order;
          foreach ($all as $key => $value) {
              $select = '';

              if ($show == $key) {
                  $select = ' selected';
              }

              echo "\n  <option value=$key$select>" . $this->seasons[$key]['year'] . ' ' . $this->seasons[$key]['name'] . '</option>';
          }
          break;
        case 'locations':
          echo "\n<select size=5 name='location'>";
          $all = $this->location_order;
          foreach ($all as $key => $value) {
              $select = '';

              if ($show == $key) {
                  $select = ' selected';
              }

              echo "\n  <option value=$key$select>" . $this->locations[$key]['name'] . '</option>';
          }
          break;
        case 'sponsors':
          echo "\n<select size=5 multiple=multiple name='sponsors[]'>";
          echo "\n  <option value=x>" . _TM_NONE . '</option>';
          foreach ($this->sponsors as $q => $w) {
              $s2[$q] = $w['name'];
          }
          arsort($s2);
          $s2 = array_reverse($s2, true);
          foreach ($s2 as $q => $w) {
              $all[$q] = $q;
          }
          if (0 != $show) {
              $selected = $this->shows[$show]['sponsors'];
          }
          break;
      }

          if (0 == $show) {
              $selected = [];
          }

          if ('sponsors' == $field) {
              foreach ($all as $q) {
                  if (true === in_array($q, $selected, true)) {
                      echo "\n  <option value=$q  selected=selected>" . $this->sponsors[$q]['name'] . '</option>';
                  } else {
                      echo "\n  <option value=$q>" . $this->sponsors[$q]['name'] . '</option>';
                  }
              }
          }

          echo "\n</select>";
      }

      // bump_season--------------------------------------------------------------

      // moves a season to the top of the order

      public function bump_season($id)
      {
          $order = $this->season_order;

          if (isset($order[$id])) {
              unset($order[$id]);
          }

          $order = array_reverse($order, true);

          $order[$id] = $id;

          $order = array_reverse($order, true);

          $this->season_order = $order;

          $this->save_all();
      }

      // bump_location------------------------------------------------------------

      // moves a location to the top of the order

      public function bump_location($id)
      {
          $order = $this->location_order;

          if (isset($order[$id])) {
              unset($order[$id]);
          }

          $order = array_reverse($order, true);

          $order[$id] = $id;

          $order = array_reverse($order, true);

          $this->location_order = $order;

          $this->save_all();
      }

      // read---------------------------------------------------------------------

      // appends $name and opens with $gt_data

      public function read($name)
      {
          global $gt_data;

          //echo "\n<div>TM open</div>";

          $return = $gt_data->read($this->name . '_' . $name);

          //echo "\n<div>end TM open</div>";

          return($return);
      }

      // write--------------------------------------------------------------------

      // appends $name and opens with $gt_data

      public function write($name, $input)
      {
          global $gt_data;

          if (!is_array($input)) {
              $input = [];
          }

          return($gt_data->write($this->name . '_' . $name, $input));
      }

      // save_all-----------------------------------------------------------------

      // saves all data files with current values

      public function save_all()
      {
          //echo "\n<div>TM save_all</div>";

          $this->write('config', $this->config);

          $this->write('locations', $this->locations);

          $this->write('seasons', $this->seasons);

          $this->write('shows', $this->shows);

          $this->write('sponsors', $this->sponsors);

          $this->write('location_order', $this->location_order);

          $this->write('season_order', $this->season_order);

          //echo "\n<div>end TM save_all</div>";
      }

      // stampfromdate------------------------------------------------------------

      // creates a timestamp from a mm/dd/yyyy hh:mm date

      //                            08/14/2003 19:30

      //                            0123456789111111

      //                                      012345

      // somewhat inaccurate, skips leap seconds and is as such currently slow by

      // 18 seconds...not for precision timekeeping...

      // -------------------------------------------------------------------------

      // UPDATED TO USE MKTIME()!!!! requires PHP 3.0.10 to work as expected

      public function stampfromdate($date)
      {
          $date = eregi_replace("[\:\/ ]*", '', $date);

          //  081420031930

          //  012345678911

          //            01

          echo $date;

          $year = $date[4] . $date[5] . $date[6] . $date[7];

          $day = $date[2] . $date[3];

          $month = $date[0] . $date[1];

          $hours = $date[8] . $date[9];

          $minutes = $date[10] . $date[11];

          $seconds = mktime($hours, $minutes, 0, $month, $day, $year, -1);

          return($seconds);
      }

      // kill_maids---------------------------------------------------------------

      // searches for shows with no instances and removes them--------------------

      public function kill_maids()
      {
          echo '<div><b>' . _TM_KILLINGMAIDS . '</b>:<br>';

          $count = 0;

          foreach ($this->shows as $sid => $sdata) {
              if (count($sdata['instance']) < 1) {
                  $count++;

                  $this->remove_show($sid);
              }
          }

          $this->save_all();

          printf(_TM_MAIDSKILLED, $count);

          echo '</div>';
      }

      // kill_orphans-------------------------------------------------------------

      // searches for orphaned instances and removes them-------------------------

      public function kill_orphans()
      {
          echo '<div><b>' . _TM_KILLINGORPHANS . '</b>:<br>';

          $count = 0;

          foreach ($this->shows as $sid => $sdata) {
              $instances = $sdata['instance'];

              foreach ($instances as $iid => $idata) {
                  if (!isset($this->seasons[$idata['season']]) or !isset($this->locations[$idata['location']])) {
                      $count++;

                      unset($this->shows[$sid]['instance'][$iid]);
                  }
              }
          }

          $this->save_all();

          printf(_TM_ORPHANSKILLED, $count);

          echo '</div>';
      }

      // debug functions----------------------------------------------------------

      // debug_print_shows------------------------------------------------------

      // prints loaded show data

      public function debug_print_shows()
      {
          echo "\n<ul>";

          echo "\n<li><b>Debug : Printing shows</b></li>";

          if (is_array($this->shows)) {
              foreach ($this->shows as $skey => $sdata) {
                  echo "\n<li>$skey</li>";

                  echo "\n<ul>";

                  foreach ($sdata as $dkey => $ddata) {
                      if (!is_array($ddata)) {
                          echo "\n<li><b>$dkey</b> : $ddata</li>";
                      }
                  }

                  $array = $sdata['sponsors'];

                  echo "\n<li>Sponsors</li><ul>";

                  foreach ($array as $key => $value) {
                      echo "\n<li><b>$key</b> : $value</li>";
                  }

                  echo "\n</ul>";

                  $array = $sdata['instance'];

                  echo "\n<li>Instances</li><ul>";

                  foreach ($array as $key => $value) {
                      echo "\n<li><b>$key</b></li><ul>";

                      echo "\n<li><b>Date</b> : " . $value['date'] . '</li>';

                      echo "\n<li><b>Location</b> : " . $value['location'] . '</li>';

                      echo "\n<li><b>Season</b> : " . $value['season'] . '</li>';

                      echo "\n<li><b>Extra</b> : " . $value['extra'] . '</li>';

                      echo "\n</ul>";
                  }

                  echo "\n</ul>";

                  echo "\n</ul>";
              }

              echo "\n</ul>";
          }
      }
  }
  // theaterman_single_show-----------------------------------------------------
  // allows cleaner access of a single theaterman show, requires class
  // theaterman as $theaterman
  class theaterman_single_show
  {
      public $loaded_show;

      public $loaded_instance;

      public $show_raw;

      public $title;

      public $description;

      public $price;

      public $presspack;

      public $sponsors;

      public $instance;

      public $in_date;

      public $in_location;

      public $in_season;

      public $in_extra;

      public $in_sponsors;

      public $in_price;

      public function load_instance($show, $instance)
      {
          global $theaterman;

          if (isset($theaterman->shows[$show]['instance'][$instance])) {
              $this->loaded_show = $show;

              $this->loaded_show = $instance;

              $this->show_raw = $theaterman->shows[$show];

              $this->title = $this->show_raw['title'];

              $this->description = $this->show_raw['description'];

              $this->price = $this->show_raw['price'];

              $this->presspack = $this->show_raw['presspack'];

              $this->sponsors = $this->show_raw['sponsors'];

              $this->instance = $this->show_raw['instance'];

              $this->in_date = $this->show_raw['instance'][$instance]['date'];

              $this->in_location = $this->show_raw['instance'][$instance]['location'];

              $this->in_season = $this->show_raw['instance'][$instance]['season'];

              $this->in_extra = $this->show_raw['instance'][$instance]['extra'];

              $this->in_date = $this->show_raw['instance'][$instance]['date'];
          } else {
              gt_alert::new_alert(0, "The instance $instance was not found for the show $show");
          }
      }

      public function print_show()
      {
          // maybe the XOOPS date function?

          // function formatTimestamp($time, $format="l", $timeoffset="")

          $date = formatTimestamp($this->in_date);

          $description = gt_textsan::ubb_code($this->description);

          $title = gt_textsan::sanitize($this->title);

          $extra = gt_textsan::ubb_code($this->in_extra);

          include 'templates/show.php';
      }
  }
 ?>
