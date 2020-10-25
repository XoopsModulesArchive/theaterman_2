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
  class tmadmin
  {
      public function __construct()
      {
      }

      public function list_byseason()
      {
          global $theaterman;

          $season_order = $theaterman->season_order;

          $request = var_retrieve('id');

          echo '<table width=100%>';

          foreach ($season_order as $sid) {
              $slist = [];

              //begin check to display
        if (('' != $request && $sid == $request)) {// or ($request == "")) {
          echo '<tr class=bg3><td class=lightRow colspan=5><b>' . $theaterman->seasons[$sid]['year'] . ' ' . $theaterman->seasons[$sid]['name'] . "</b>: <a href='editseason.php?id=$sid'>" . _TM_EDIT . "</a>: <a href='killseason.php?id=$sid'>" . _TM_DELETE . "</a>: <a href='bumpseason.php?id=$sid'>" . _TM_BUMP . '</a></td></tr>';

            foreach ($theaterman->shows as $shid => $shdata) {
                $instance = $shdata['instance'];

                foreach ($instance as $inid => $indata) {
                    if ($indata['season'] == $sid) {
                        $slist[$inid] = $indata['date'];
                    }
                }
            }

            arsort($slist);

            //$slist = array_reverse($slist,TRUE); //(un)comment to reverse sort order

            if (is_array($slist)) {
                foreach ($slist as $inid => $indate) {
                    $this->print_tr_show($inid);
                }
            }
        } else {// end of check to display
            echo "<tr class=bg3><td class=lightRow colspan=5><a href='?id=$sid'>" . $theaterman->seasons[$sid]['year'] . ' ' . $theaterman->seasons[$sid]['name'] . "</a>: <a href='editseason.php?id=$sid'>" . _TM_EDIT . "</a>: <a href='killseason.php?id=$sid'>" . _TM_DELETE . "</a>: <a href='bumpseason.php?id=$sid'>" . _TM_BUMP . '</a></td></tr>';
        }
          }

          echo '</table>';
      }

      public function list_bylocation()
      {
          global $theaterman;

          $location_order = $theaterman->location_order;

          $request = var_retrieve('id');

          echo '<table width=100%>';

          foreach ($location_order as $sid) {
              $slist = [];

              //begin check to display
        if (('' != $request && $sid == $request)) {// or ($request == "")) {
          echo '<tr class=bg3><td class=lightRow colspan=5><b>' . $theaterman->locations[$sid]['name'] . "</b>: <a href='editlocation.php?id=$sid'>" . _TM_EDIT . "</a>: <a href='killlocation.php?id=$sid'>" . _TM_DELETE . "</a>: <a href='bumpvenue.php?id=$sid'>" . _TM_BUMP . '</a></td></tr>';

            foreach ($theaterman->shows as $shid => $shdata) {
                $instance = $shdata['instance'];

                foreach ($instance as $inid => $indata) {
                    if ($indata['location'] == $sid) {
                        $slist[$inid] = $indata['date'];
                    }
                }
            }

            arsort($slist);

            //$slist = array_reverse($slist,TRUE); //(un)comment to reverse sort order

            if (is_array($slist)) {
                foreach ($slist as $inid => $indate) {
                    $this->print_tr_show($inid);
                }
            }
        } else {// end of check to display
            echo "<tr class=bg3><td class=lightRow colspan=5><a href='?id=$sid'>" . $theaterman->locations[$sid]['name'] . "</a>: <a href='editlocation.php?id=$sid'>" . _TM_EDIT . "</a>: <a href='killlocation.php?id=$sid'>" . _TM_DELETE . "</a>: <a href='bumpvenue.php?id=$sid'>" . _TM_BUMP . '</a></td></tr>';
        }
          }

          echo '</table>';
      }

      public function list_instances($sid, $ref)
      {
          global $theaterman;

          if (isset($theaterman->shows[$sid])) {
              $slist = [];

              $instances = $theaterman->shows[$sid]['instance'];

              if (isset($instances[$ref])) {
                  $this->print_tr_show($ref);

                  echo "\n<tr><td class=lightRow colspan=5><b>" . _TM_OTHERSHOWINGS . ':</b></td></tr>';
              }

              foreach ($instances as $iid => $idata) {
                  if ($iid != $ref) {
                      $slist[$iid] = $idata['date'];
                  }
              }

              arsort($slist);

              //$slist = array_reverse($slist,TRUE); //(un)comment to reverse sort order

              if (is_array($slist)) {
                  foreach ($slist as $inid => $indate) {
                      $this->print_tr_show($inid);
                  }
              }
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

          echo '<table width=100%>';

          foreach ($shows as $sid => $sdata) {
              echo '<tr class=bg3><td class=lightRow colspan=5>' . $sdata['title'] . ": <a href='editshow.php?id=$sid' name=\"s$sid\">" . _TM_EDIT . "</a>: <a href='killshow.php?id=$sid'>" . _TM_DELETE . "</a>: <a href='addinstance.php?show=$sid'>" . _TM_ADDINSTANCE . "</a>: <a href='showimages.php?id=$sid'>" . _TM_IMAGE . "</a>: <a href='ppack.php?id=$sid'>" . _TM_PPACK . '</a></td></td></tr>';

              $this->list_instances($sid, 0);
          }

          echo '</table>';
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
                  }

                  $treps['body'] = $sdata['description'];

                  $treps['title'] = $sdata['title'];

                  $treps['sponsors'] = $this->sponsorbox($sdata['sponsors']);

                  $treps['date'] = date('l, F j, Y', $sdata['instance'][$id]['date']);

                  $treps['time'] = date('g:i a', $sdata['instance'][$id]['date']);

                  $treps['extra'] = $sdata['instance'][$id]['extra'];

                  $treps['link'] = "<a href='" . $sdata['url'] . "'>" . str_replace('http://', '', $sdata['url']) . '</a>';

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
              $output = '<div><b>' . _TM_SPONSOREDBY . ':</b></div>';

              foreach ($sponsors as $sid) {
                  if (isset($theaterman->sponsors[$sid])) {
                      if (1 == $theaterman->sponsors[$sid]['image']) {
                          $core = "<img src='cache/images/sponsor_$sid.jpg' border=0>";
                      } else {
                          $core = '<i>' . $theaterman->sponsors[$sid]['name'] . '</i>';
                      }

                      if ('' != $theaterman->sponsors[$sid]['link'] && 'http://' != $theaterman->sponsors[$sid]['link']) {
                          $core = "<a href='" . $theaterman->sponsors[$sid]['link'] . "' target=_blank>$core</a>";
                      }

                      $output .= "<div>$core</div>";
                  }
              }

              return($output);
          }
      }

      public function simages($id)
      {
      }

      public function print_tr_show($rid)
      {
          global $theaterman;

          if ($theaterman->config['next_id']['instance'] > $rid) {
              foreach ($theaterman->shows as $sid => $sdata) {
                  if (isset($sdata['instance'][$rid])) {
                      if ($sdata['instance'][$rid]['date'] >= time()) {
                          $rclass = 'bg1';
                      } else {
                          $rclass = 'bg1';

                          $expired = '' . _TM_ALREADYPLAYED . '';
                      }

                      $title = $sdata['title'];

                      $blurb = $sdata['description'];

                      $blurb = explode(' ', $blurb);

                      for ($i = 1; $i <= 50; $i++) {
                          $blurb2 .= ' ' . $blurb[$i];
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

                          $blurb2 .= "\n<br><i><a href='show.php?id=$sid&ref=$rid'>$also</a></i>";
                      }

                      $blurb = $blurb2;

                      $date = date('m/d/y', $sdata['instance'][$rid]['date']);

                      $location = "<a href='byvenue.php?id=" . $sdata['instance'][$rid]['location'] . "'>" . $theaterman->locations[$sdata['instance'][$rid]['location']]['name'] . '</a>';

                      echo "\n<tr class=$rclass><td class=$rclass width=1 nowrap>$expired</td><td></td><td class=$rclass><a href='../instance.php?id=$rid' name=\"i$rid\">$title</a>: <a href='editinstance.php?id=$rid'>" . _TM_EDIT . "</a>: <a href='editshow.php?id=$sid'>" . _TM_EDITPARENT . "</a>: <a href='killinstance.php?id=$rid'>" . _TM_DELETE . "</a></a></td><td class=$rclass>$date</td><td class=$rclass>$location</td></tr>";

                      //echo "\n<tr class=$rclass><td colspan=3 class=$rclass>$blurb</td></tr>";

                      break;
                  }
              }
          }
      }
  }
