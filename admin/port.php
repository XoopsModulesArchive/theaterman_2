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

  echo '<h1>' . _TM_PORTING . '</h1>';
  if (is_dir('../../theaterman/')) {
      echo "\n<p>" . _TM_OLDDETECTED . '</p>';

      include '../../theaterman/class.theaterman.php';

      $tdata = new tmdata();

      $tdata->setpath('../../theaterman/cache/');

      $nseasons = $tdata->read('seasons');

      $nshows = $tdata->read('shows');

      $nsponsors = $tdata->read('sponsors');

      $nlocations = [];

      echo "\n<ul>";

      echo "\n<li>Importing Seasons</li>";

      foreach ($nseasons as $nid => $ndata) {
          $insert = 1;

          foreach ($theaterman->seasons as $sid => $sdata) {
              if ($sdata['year'] == $ndata['year'] && $sdata['name'] == $ndata['type']) {
                  $insert = 0;

                  $nseasons[$nid]['newid'] = $sid;
              }
          }

          if (1 == $insert) {
              echo "\n  <li>#$nid: " . $ndata['year'] . ' ' . $ndata['type'] . ': newid: ';

              $nseasons[$nid]['newid'] = $theaterman->insert_season($ndata['year'], $ndata['type']);

              echo $nseasons[$nid]['newid'] . '</li>';
          } else {
              echo "\n  <li>#$nid: " . $ndata['year'] . ' ' . $ndata['type'] . ': newid: ' . $nseasons[$nid]['newid'] . ': already exists</li>';
          }
      }

      echo "\n<li>Importing Sponsors</li>";

      foreach ($nsponsors as $nid => $ndata) {
          $exists = 0;

          foreach ($theaterman->sponsors as $sid => $sdata) {
              if ($sdata['name'] == $ndata['name']) {
                  $exists = $sid;
              }
          }

          if (0 == $exists) {
              $nsid = $theaterman->insert_sponsor($ndata['name'], $ndata['url']);

              $nsponsors[$nid]['newid'] = $nsid;

              echo "\n  <li>$nid = $nsid</li>";
          } else {
              echo "\n  <li>$nid = $exists</li>";

              $nsponsors[$nid]['newid'] = $exists;
          }
      }

      echo "\n<li>Importing Locations</li>";

      foreach ($nshows as $nid => $ndata) {
          if (!isset($nlocations[$ndata['place']])) {
              $exists = 0;

              foreach ($theaterman->locations as $lid => $ldata) {
                  if ($ldata['name'] == $ndata['place']) {
                      $exists = $lid;
                  }
              }

              if (0 != $exists) {
                  $nlocations[$ndata['place']] = $exists;
              } else {
                  $nlocations[$ndata['place']] = $theaterman->insert_location($ndata['place'], '');
              }

              echo "\n  <li>Location <i>" . $ndata['place'] . '</i>: ' . $nlocations[$ndata['place']] . '</li>';
          }
      }

      echo "\n<li>Importing Shows</li>";

      foreach ($nshows as $nid => $ndata) {
          echo "\n  <li>#$nid: " . $ndata['title'];

          $exists = 0;

          foreach ($theaterman->shows as $sid => $sdata) {
              if ($ndata['title'] == $sdata['title']) {
                  $exists = $sid;
              }
          }

          if (0 == $exists) {
              echo "\n  <ul>";

              if (preg_match("[0-9]*\:[0-9]*[am,pm]", $ndata['time'])) {
                  $hour = $ndata['time'][0];

                  $next = 2;

                  if (is_int($ndata['time'][1])) {
                      $hour .= $ndata['time'][1];

                      $next = 3;
                  }

                  $minute = $ndata['time'][$next] . $ndata['time'][$next + 1];

                  if ('pm' == $ndata['time'][$next + 2] . $ndata['time'][$next + 3]) {
                      $hour += 12;
                  }

                  $second = 0;
              } else {
                  $hour = 12;

                  $minute = '00';

                  $second = 0;
              }

              if ($hour < 10) {
                  $hour = '0' . $hour;
              }

              //  mm/dd/yy

              //  01234567

              $month = $ndata['date'][0] . $ndata['date'][1];

              $day = $ndata['date'][3] . $ndata['date'][4];

              $year = '20' . $ndata['date'][6] . $ndata['date'][7];

              //$newdate = mktime($hour, $minute, $second, $month, $day, $year);

              //echo "<br>Date: ".$ndata["date"].", ".$ndata["time"]." = ".$newdate." = ".date("m/d/y h:i:s A",$newdate);

              $title = $ndata['title'];

              $description = gt_textsan::html_to_ubb($ndata['body']);

              $sponsors = explode(' ', $ndata['sponsors']);

              foreach ($sponsors as $key => $sid) {
                  $sponsors[$key] = $nsponsors[$sid]['newid'];
              }

              $price = $ndata['price'];

              $url = $ndata['url'];

              $nsid = $theaterman->add_show($title, $description, $sponsors, $price, $url);

              if (0 != $nsid) {
                  echo "\n    <li>Show inserted as $nsid</li>";

                  // DATE: mm/dd/yyyy hh:mm

                  $season = $nseasons[$ndata['parent']]['newid'];

                  $date = "$month/$day/$year $hour:$minute";

                  $location = $nlocations[$ndata['place']];

                  $parent = $nsid;

                  $extra = '';

                  $niid = $theaterman->add_instance($parent, $date, $location, $season, "\n");

                  if (0 != $niid) {
                      echo "\n    <li>Instance $niid inserted</li>";
                  } else {
                      echo "\n    <li>Instance insertion failed</li>";
                  }
              } else {
                  echo "\n    <li>Show insertion failed</li>";
              }

              echo "\n  </ul>";
          } else {
              echo "<br>Already exists as $exists";
          }

          echo '</li>';
      }

      echo "\n</ul>";
  } else {
      echo "\n<p>" . _TM_NOOLD . '</p>';
  }

  include 'admin_footer.php';
