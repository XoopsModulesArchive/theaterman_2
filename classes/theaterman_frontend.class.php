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
  class tmfront
  {
      public function __construct()
      {
      }

      public function list_byseason()
      {
          global $theaterman;

          $season_order = $theaterman->season_order;

          $request = var_retrieve('id');

          OpenTable();

          foreach ($season_order as $sid) {
              $slist = [];

              //begin check to display
        if (('' != $request && $sid == $request)) {// or ($request == "")) {
          echo '<tr><td class=head colspan=4 style="font-size: 13pt; text-align: left;"><b>' . $theaterman->seasons[$sid]['year'] . ' ' . $theaterman->seasons[$sid]['name'] . '</b></td></tr>';

            foreach ($theaterman->shows as $shid => $shdata) {
                $instance = $shdata['instance'];

                foreach ($instance as $inid => $indata) {
                    if ($indata['season'] == $sid) {
                        $slist[$inid] = $indata['date'];
                    }
                }
            }

            arsort($slist);

            $slist = array_reverse($slist, true); //(un)comment to reverse sort order

            if (is_array($slist)) {
                foreach ($slist as $inid => $indate) {
                    $this->print_tr_show($inid);
                }
            }
        } else {// end of check to display
            echo "<tr><td colspan=4 class=foot style=\"text-align: left\"><a href='byseason.php?id=$sid'>" . $theaterman->seasons[$sid]['year'] . ' ' . $theaterman->seasons[$sid]['name'] . '</a></td></tr>';
        }
          }

          CloseTable();
      }

      public function list_bylocation()
      {
          global $theaterman;

          $location_order = $theaterman->location_order;

          $request = var_retrieve('id');

          OpenTable();

          foreach ($location_order as $sid) {
              $slist = [];

              //begin check to display
        if (('' != $request && $sid == $request)) {// or ($request == "")) {
          echo '<tr><td class=head colspan=4 style="font-size: 13pt; text-align: left;"><b>' . $theaterman->locations[$sid]['name'] . '</b></td></tr>';

            if ('' != $theaterman->locations[$sid]['directions'] && "\n" != $theaterman->locations[$sid]['directions'] && $theaterman->locations[$sid]['directions'] != $theaterman->locations[$sid]['name']) {
                echo '<tr class=odd><td colspan=4>' . $theaterman->locations[$sid]['directions'] . '</td></tr>';
            }

            foreach ($theaterman->shows as $shid => $shdata) {
                $instance = $shdata['instance'];

                foreach ($instance as $inid => $indata) {
                    if ($indata['location'] == $sid) {
                        $slist[$inid] = $indata['date'];
                    }
                }
            }

            arsort($slist);

            $slist = array_reverse($slist, true); //(un)comment to reverse sort order

            if (is_array($slist)) {
                foreach ($slist as $inid => $indate) {
                    $this->print_tr_show($inid);
                }
            }
        } else {// end of check to display
            echo "<tr><td colspan=4 class=foot style=\"text-align: left\"><a href='byvenue.php?id=$sid'>" . $theaterman->locations[$sid]['name'] . '</a></td></tr>';
        }
          }

          CloseTable();
      }

      public function list_instances($sid, $ref)
      {
          global $theaterman;

          if (isset($theaterman->shows[$sid])) {
              OpenTable();

              $instances = $theaterman->shows[$sid]['instance'];

              if (isset($instances[$ref])) {
                  $this->print_tr_show($ref);

                  echo "\n<tr><td class=odd colspan=4><b>" . _TM_OTHERSHOWINGS . ':</b></td></tr>';
              }

              foreach ($instances as $iid => $idata) {
                  if ($iid != $ref) {
                      $slist[$iid] = $idata['date'];
                  }
              }

              arsort($slist);

              $slist = array_reverse($slist, true); //(un)comment to reverse sort order

              if (is_array($slist)) {
                  foreach ($slist as $inid => $indate) {
                      $this->print_tr_show($inid);
                  }
              }

              CloseTable();
          } else {
              if ($sid >= $theaterman->config['next_id']['show']) {
                  printf("\n<p>" . _TM_ESHOWNOTFOUND, $sid);
              } else {
                  printf("\n<p>" . _TM_ESHOWDELETED, $sid);
              }
          }
      }

      public function list_all()
      {
          global $theaterman;

          $shows = $theaterman->shows;

          foreach ($shows as $sid => $sdata) {
              $instances = $sdata['instance'];

              foreach ($instances as $iid => $idata) {
                  $slist[$iid] = $idata['date'];
              }
          }

          OpenTable();

          echo '<tr><td class=head colspan=4 style="font-size: 13pt; text-align: left;"><b>All Shows</b></td></tr>';

          arsort($slist);

          $slist = array_reverse($slist, true); //(un)comment to reverse sort order

          if (is_array($slist)) {
              foreach ($slist as $inid => $indate) {
                  $this->print_tr_show($inid);
              }
          }

          CloseTable();
      }

      public function print_instance($id)
      {
          global $theaterman;

          $found = 0;

          foreach ($theaterman->shows as $sid => $sdata) {
              if (isset($sdata['instance'][$id])) {
                  ob_start();

                  include 'templates/instance';

                  $template = ob_get_contents();

                  ob_clean();

                  if (count($sdata['instance']) > 1) {
                      if (2 != count($sdata['instance'])) {
                          $s = 's';
                      } else {
                          $s = ' ';
                      }

                      $also = str_replace('*s*', $s, _TM_ALSO);

                      $also = str_replace('*m*', count($sdata['instance']) - 1, $also);

                      $treps['others'] = "&lt;-- <a href='show.php?id=$sid&ref=$id'>$also</a></i>";
                  } else {
                      $treps['others'] = '';
                  }

                  if (1 == $theaterman->shows[$sid]['presspack']) {
                      $treps['ppack'] = "&lt;-- <a href=\"ppack.php?id=$sid\">" . _TM_PRESSPACK . '</a>';
                  } else {
                      $treps['ppack'] = '';
                  }

                  $treps['body'] = gt_textsan::ubb_code($sdata['description']);

                  $treps['title'] = gt_textsan::sanitize($sdata['title']);

                  $treps['sponsors'] = $this->sponsorbox($sdata['sponsors']);

                  $treps['date'] = date('l, F j, Y', $sdata['instance'][$id]['date']);

                  $treps['time'] = date('g:i a', $sdata['instance'][$id]['date']);

                  $treps['price'] = $sdata['price'];

                  if ("\n" != $sdata['instance'][$id]['extra']) {
                      $treps['extra'] = gt_textsan::sanitize($sdata['instance'][$id]['extra']) . '<hr>';
                  } else {
                      $treps['extra'] = '';
                  }

                  $treps['link'] = "<a href='" . $sdata['url'] . "' target=_blank>" . str_replace('http://', '', $sdata['url']) . '</a>';

                  $treps['images'] = $this->simages($sid);

                  $treps['season'] = "&lt;-- <a href='byseason.php?id=" . $sdata['instance'][$id]['season'] . "'>" . $theaterman->seasons[$sdata['instance'][$id]['season']]['year'] . ' ' . $theaterman->seasons[$sdata['instance'][$id]['season']]['name'] . '</a>';

                  $treps['location'] = "&lt;-- <a href='byvenue.php?id=" . $sdata['instance'][$id]['location'] . "'>" . $theaterman->locations[$sdata['instance'][$id]['location']]['name'] . '</a>';

                  foreach ($treps as $key => $value) {
                      $template = str_replace("\{$key}", (string)$value, $template);
                  }

                  echo (string)$template;

                  $found = 1;
              }

              if (1 == $found) {
                  break;
              }
          }

          if (($id >= $theaterman->config['next_id']['instance']) && (1 != $found)) {
              printf("\n<p>" . _TM_EINSTNOTFOUND, $id);
          } elseif (1 != $found) {
              printf("\n<p>" . _TM_EINSTDELETED, $id);
          }
      }

      public function sponsorbox($sponsors)
      {
          global $theaterman;

          if (is_array($sponsors)) {
              $output = '<div><b>' . _TM_SPONSOREDBY . ":</b></div>\n<center><table border=0 cellspacing=10 cellpadding=0 class=bg1>";

              foreach ($sponsors as $sid) {
                  if (isset($theaterman->sponsors[$sid])) {
                      if (file_exists('cache/images/sp_' . $sid . '.jpg')) {
                          $core = "<img src='cache/images/sp_" . $sid . ".jpg' border=0>";
                      } else {
                          $core = '<i>' . $theaterman->sponsors[$sid]['name'] . '</i>';
                      }

                      if ('' != $theaterman->sponsors[$sid]['link'] && 'http://' != $theaterman->sponsors[$sid]['link']) {
                          $core = "<a href='" . $theaterman->sponsors[$sid]['link'] . "' target=_blank>$core</a>";
                      }

                      $output .= "<tr><td>$core</td></tr>";
                  }
              }

              return($output . '</table></center>');
          }
      }

      public function simages($id)
      {
          $return = "\n<table border=0 cellspacing=0 cellpadding=0>";

          $si = 1;

          while (file_exists('cache/images/sh_' . $id . '_' . $si . '.jpg') or file_exists('cache/images/sh_' . $id . '_' . ($si + 1) . '.jpg') or file_exists('cache/images/sh_' . $id . '_' . ($si - 1) . '.jpg')) {
              if (file_exists('cache/images/sh_' . $id . '_' . $si . '.jpg')) {
                  $return .= "\n<tr><td><img src=\"cache/images/sh_" . $id . '_' . $si . '.jpg" alt=""></td></tr>';
              }

              $si++;
          }

          return($return . "\n</table>");
      }

      public function print_tr_show($rid)
      {
          global $theaterman;

          if ($theaterman->config['next_id']['instance'] > $rid) {
              foreach ($theaterman->shows as $sid => $sdata) {
                  if (isset($sdata['instance'][$rid])) {
                      if ($sdata['instance'][$rid]['date'] >= time()) {
                          $rclass = 'even';

                          $rclass2 = 'odd';

                          if (($sdata['instance'][$rid]['date'] - time()) <= 86400) {
                              $expired = ' -' . _TM_TODAY . '-';

                              $rclass = 'head';

                              $rclass2 = 'even';
                          }
                      } else {
                          $rclass = 'outer';

                          $rclass2 = 'even';

                          $expired = ' -' . _TM_ALREADYPLAYED . '-';
                      }

                      $title = $sdata['title'];

                      $blurb = gt_textsan::ubb_code($sdata['description']);

                      $blurb = explode(' ', $blurb);

                      for ($i = 1; $i <= 50; $i++) {
                          $blurb2 .= ' ' . $blurb[$i - 1];
                      }

                      if (mb_strlen($blurb2) < mb_strlen($blurb)) {
                          $blurb2 .= '...';
                      }

                      if (count($sdata['instance']) > 1) {
                          if (2 != count($sdata['instance'])) {
                              $s = 's';
                          } else {
                              $s = ' ';
                          }

                          $also = str_replace('*s*', $s, _TM_ALSO);

                          $also = str_replace('*m*', count($sdata['instance']) - 1, $also);

                          $blurb2 .= "\n<br><a href='show.php?id=$sid&ref=$rid' class=copyright>$also</a>";
                      }

                      if (file_exists('cache/images/sh_' . $sid . '_0.jpg')) {
                          $icon = "<a href='instance.php?id=$rid'><img src=\"cache/images/sh_" . $sid . '_0.jpg" alt="" border=0></a>';
                      } else {
                          $icon = "<a href='instance.php?id=$rid'><img src=\"cache/images/defaultbutton.gif\" alt=\"\" border=0></a>";
                      }

                      $blurb = $blurb2;

                      $date = date('l, M. j, Y', $sdata['instance'][$rid]['date']);

                      $location = "<a href='byvenue.php?id=" . $sdata['instance'][$rid]['location'] . "'>" . $theaterman->locations[$sdata['instance'][$rid]['location']]['name'] . '</a>';

                      echo "\n<tr class=$rclass><td rowspan=2 class=$rclass style='text-align: left;' width=1%>$icon</td><td class=$rclass style='text-align: left;'><a href='instance.php?id=$rid' style='font-size: 12pt;'><b>$title</b></a>$expired</td><td class=$rclass style='text-align: left;'>$date</td><td class=$rclass style='text-align: left;'>$location</td></tr>";

                      echo "\n<tr class=$rclass><td colspan=3 class=$rclass2 style='text-align: left;'><div><i>" . $sdata['instance'][$rid]['extra'] . "</i></div>\n$blurb</td></tr>";

                      break;
                  }
              }
          }
      }
  }
