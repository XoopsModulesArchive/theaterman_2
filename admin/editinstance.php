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
  include 'admin_header.php';
  
  echo "\n<h1>"._TM_ADEDITINSTANCE . '</h1>';
  $id = var_retrieve('id');
  $found = 0;
  foreach ($theaterman->shows as $sid => $sdat) {
    if (isset($sdat['instance'][$id])) {
      $found = $sid;
      break;
    }
  }
  if ($found == 0) {
    printf('<p>'._TM_EINSTANCENOTFOUND.'</p>',$id);
    include 'admin_footer.php';
    exit();
  }
  printf('<p>' . _TM_ONLYINSTANCE, $found, $found);
  if (var_retrieve('step') != 'finish') {
    // mm dd yyyy hh mm *m
    // 0123456789111111111
    //           012345678
    $date = date('m d Y h i a', $theaterman->shows[$found]['instance'][$id]['date']);
    $montht = $date{0}.$date{1};
    $month[$montht] = ' selected';
    $dayt = $date{3}.$date{4};
    $day[$dayt] = ' selected';
    $year = $date{6}.$date{7}.$date{8}.$date{9};
    $hourt = $date{11}.$date{12};
    $hour[$hourt] = ' selected';
    $minutet = $date{14}.$date{15};
    $minute[$minutet] = ' selected';
    $mert = $date{17}.$date{18};
    $mer[$$mert] = ' selected';
    if ($theaterman->shows[$found]['instance'][$id]['extra'] == '&666;') {
      $theaterman->shows[$found]['instance'][$id]['extra'] = '';
    }
    ?>
        <form action=? method=post>
        <input type=hidden name=step value=finish>
        <input type=hidden name=id value=<?php echo $id; ?>>
        <table>
          <tr><td><b><?php echo _TM_DATE; ?>:</b></td><td>
            <select size=1 name=month>
              <option value=01<?php echo $month['01']; ?>><?php echo _TM_JANUARY; ?></option>
              <option value=02<?php echo $month['02']; ?>><?php echo _TM_FEBRUARY; ?></option>
              <option value=03<?php echo $month['03']; ?>><?php echo _TM_MARCH; ?></option>
              <option value=04<?php echo $month['04']; ?>><?php echo _TM_APRIL; ?></option>
              <option value=05<?php echo $month['05']; ?>><?php echo _TM_MAY; ?></option>
              <option value=06<?php echo $month['06']; ?>><?php echo _TM_JUNE; ?></option>
              <option value=07<?php echo $month['07']; ?>><?php echo _TM_JULY; ?></option>
              <option value=08<?php echo $month['08']; ?>><?php echo _TM_AUGUST; ?></option>
              <option value=09<?php echo $month['09']; ?>><?php echo _TM_SEPTEMBER; ?></option>
              <option value=10<?php echo $month['10']; ?>><?php echo _TM_OCTOBER; ?></option>
              <option value=11<?php echo $month['11']; ?>><?php echo _TM_NOVEMBER; ?></option>
              <option value=12<?php echo $month['12']; ?>><?php echo _TM_DECEMBER; ?></option>
            </select>
            <select size=1 name=day>
              <option value=01<?php echo $day['01']; ?>>1</option>
              <option value=02<?php echo $day['02']; ?>>2</option>
              <option value=03<?php echo $day['03']; ?>>3</option>
              <option value=04<?php echo $day['04']; ?>>4</option>
              <option value=05<?php echo $day['05']; ?>>5</option>
              <option value=06<?php echo $day['06']; ?>>6</option>
              <option value=07<?php echo $day['07']; ?>>7</option>
              <option value=08<?php echo $day['08']; ?>>8</option>
              <option value=09<?php echo $day['09']; ?>>9</option>
              <option value=10<?php echo $day['10']; ?>>10</option>
              <option value=11<?php echo $day['11']; ?>>11</option>
              <option value=12<?php echo $day['12']; ?>>12</option>
              <option value=13<?php echo $day['13']; ?>>13</option>
              <option value=14<?php echo $day['14']; ?>>14</option>
              <option value=15<?php echo $day['15']; ?>>15</option>
              <option value=16<?php echo $day['16']; ?>>16</option>
              <option value=17<?php echo $day['17']; ?>>17</option>
              <option value=18<?php echo $day['18']; ?>>18</option>
              <option value=19<?php echo $day['19']; ?>>19</option>
              <option value=20<?php echo $day['20']; ?>>20</option>
              <option value=21<?php echo $day['21']; ?>>21</option>
              <option value=22<?php echo $day['22']; ?>>22</option>
              <option value=23<?php echo $day['23']; ?>>23</option>
              <option value=24<?php echo $day['24']; ?>>24</option>
              <option value=25<?php echo $day['25']; ?>>25</option>
              <option value=26<?php echo $day['26']; ?>>26</option>
              <option value=27<?php echo $day['27']; ?>>27</option>
              <option value=28<?php echo $day['28']; ?>>28</option>
              <option value=29<?php echo $day['29']; ?>>29</option>
              <option value=30<?php echo $day['30']; ?>>30</option>
              <option value=31<?php echo $day['31']; ?>>31</option>
            </select>
            <select size=1 name=year>
              <?php 
                $now = $year;
                for ($i = $now + 5; $i >= $now - 5; $i--) {
                  echo "\n              <option";
                    if ($i == $year) {
                      echo ' selected';
                    }
                  echo ">$i</option>";
                }
                echo "\n";
              ?>
            </select>
          </td></tr>
          <tr><td><b><?php echo _TM_TIME; ?>:</b></td><td>
            <select size=1 name=hour>
              <option value=01<?php echo $hour['01']; ?>>1</option>
              <option value=02<?php echo $hour['02']; ?>>2</option>
              <option value=03<?php echo $hour['03']; ?>>3</option>
              <option value=04<?php echo $hour['04']; ?>>4</option>
              <option value=05<?php echo $hour['05']; ?>>5</option>
              <option value=06<?php echo $hour['06']; ?>>6</option>
              <option value=07<?php echo $hour['07']; ?>>7</option>
              <option value=08<?php echo $hour['08']; ?>>8</option>
              <option value=09<?php echo $hour['09']; ?>>9</option>
              <option value=10<?php echo $hour['10']; ?>>10</option>
              <option value=11<?php echo $hour['11']; ?>>11</option>
              <option value=12<?php echo $hour['12']; ?>>12</option>
            </select>:<select size=1 name=minute>
              <option value=00<?php echo $minute['00']; ?>>00</option>
              <option value=15<?php echo $minute['15']; ?>>15</option>
              <option value=30<?php echo $minute['30']; ?>>30</option>
              <option value=45<?php echo $minute['45']; ?>>45</option>
            </select>
            <select size=1 name=meridium>
              <option value=12<?php echo $mer['pm']; ?>>pm</option>
              <option value=00<?php echo $mer['am']; ?>>am</option>
            </select></td></tr>
          <tr><td><b><?php echo _TM_SEASON; ?>:</b></td><td><?php $theaterman->listbox('seasons', $theaterman->shows[$found]['instance'][$id]['season']); ?></td></tr>
          <tr><td><b><?php echo _TM_LOCATION; ?>:</b></td><td><?php $theaterman->listbox('locations', $theaterman->shows[$found]['instance'][$id]['location']); ?></td></tr>
          <tr><td><b><?php echo _TM_EXTRAINFO; ?>:</b></td><td><textarea rows=5 cols=40 name=extra><?php echo $theaterman->shows[$found]['instance'][$id]['extra']; ?></textarea></td></tr>
          <tr><td></td><td><input type=submit value="<?php echo _TM_SUBMIT; ?>"></td></tr>
        </table>
        </form>
      <?php
  }else {
    $mm = var_retrieve('month');
    $dd = var_retrieve('day');
    $hh = var_retrieve('hour');
    $merediem = var_retrieve('meridium');
    if ($hh == 12 && 1 == 2) {
      if ($merediem == 12) {
        $merediem = 00;
      }else {
        $merediem = 12;
      }
    }
    $hh += $merediem;
    if ($hh < 10) {
      $hh = "0$hh";
    }
    $mi = var_retrieve('minute');
    $yyyy = var_retrieve('year');
    $date = "$mm/$dd/$yyyy $hh:$mi";
    echo $date;
    $location = var_retrieve('location');
    $season = var_retrieve('season');
    $extra = var_retrieve('extra');
    if ($extra == '') {
      $extra = "\n";
    }
    if ($theaterman->update_instance($id, $date, $location, $season, $extra)) {
      printf('<p>' . _TM_INSTANCECHANGED . '</p>', $id);
    }
    echo "<a href=\"allshows.php#i$id\">"._TM_BACK . '</a>';
  }
  include 'admin_footer.php';
 ?>
