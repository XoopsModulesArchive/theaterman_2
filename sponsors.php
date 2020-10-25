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
//  Author: Joby Elliott (AKA Hober)                                         //
//  URL: www.greentinted.net, pas.nmt.edu, greentinted.ods.org               //
//  Project: The XOOPS Project                                               //
//  ------------------------------------------------------------------------ //
  require __DIR__ . '/header.php';

  $tsponsors = explode(' ', $theaterman->config['top sponsors']);
  $rsponsors = [];
  foreach ($theaterman->sponsors as $sid => $spo) {
      $sponsor[$sid] = $spo['name'];
  }
  arsort($sponsor);
  $sponsor = array_reverse($sponsor, true);
  foreach ($sponsor as $sid => $name) {
      $rsponsors[$sid] = $theaterman->sponsors[$sid];
  }

  $rcount = 0;
  $tcount = 0;
  $rtarget = 3;
  echo "<table width='0%'>";
  foreach ($tsponsors as $sid) {
      if (0 == $rcount && 0 != $tcount) {
          echo '<tr>';
      }

      $rcount++;

      $tcount++;

      $sdis = '';

      if (file_exists("cache/images/sp_$sid.jpg")) {
          $sdis = "<img src='cache/images/sp_$sid.jpg' border=0>";
      } else {
          $sdis = $theaterman->sponsors[$sid]['name'];
      }

      if ('' != $theaterman->sponsors[$sid]['link'] && 'http://' != $theaterman->sponsors[$sid]['link']) {
          $sdis = "<a href='" . $theaterman->sponsors[$sid]['link'] . "' target=_blank>$sdis</a>";
      }

      if (1 == $tcount) {
          echo "\n<td width='0%' colspan=$rtarget class=even><center><h1>$sdis</h1></center></td>";

          $rcount = $rtarget;
      } else {
          echo "\n<td width='0%' class=even><center><h1>$sdis</h1></center></td>";
      }

      unset($rsponsors[$sid]);

      if ($rcount == $rtarget) {
          echo '</tr>';

          $rcount = 0;
      }
  }
  foreach ($rsponsors as $sid => $z) {
      if (0 == $rcount) {
          echo '<tr>';
      }

      $rcount++;

      $tcount++;

      $sdis = '';

      if (file_exists("cache/images/sp_$sid.jpg")) {
          $sdis = "<img src='cache/images/sp_$sid.jpg' border=0>";
      } else {
          $sdis = $theaterman->sponsors[$sid]['name'];
      }

      if ('' != $theaterman->sponsors[$sid]['link'] && 'http://' != $theaterman->sponsors[$sid]['link']) {
          $sdis = "<a href='" . $theaterman->sponsors[$sid]['link'] . "' target=_blank>$sdis</a>";
      }

      echo "\n<td width='0%' class=odd><center><h3>$sdis</h3></center></td>";

      if ($rcount == $rtarget) {
          echo '</tr>';

          $rcount = 0;
      }
  }
  echo '</table>';

  require __DIR__ . '/footer.php';
