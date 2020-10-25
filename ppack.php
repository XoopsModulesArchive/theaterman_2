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
  include 'header.php';

  $id = var_retrieve('id');
  echo "\n<h1>" . _TM_PRESSPACK . ': ' . $theaterman->shows[$id]['title'] . '</h1>';
  if (1 != $theaterman->shows[$id]['presspack']) {
      printf('<p>' . _TM_ESHOWNOPPACK . '</p>', $id);

      $theaterman_frontend->list_instances($id, 0);

      include 'footer.php';

      exit();
  }
  if (!is_dir("cache/presspack/$id/")) {
      $files = '';
  } else {
      $dir = opendir("cache/presspack/$id/");

      $count = 0;

      while (false !== ($file = readdir($dir))) {
          if ('.' != $file && '..' != $file) {
              $count++;

              //extension

              $fname = explode('.', $file);

              if (count($fname) > 1) {
                  $nfile['extension'] = $fname[count($fname) - 1];

                  unset($fname[count($fname) - 1]);
              } else {
                  $nfile['extension'] = '';
              }

              //name

              $nfile['name'] = implode('.', $fname);

              $files[$file] = $nfile;
          }
      }

      closedir();

      if ($count < 1) {
          $files = '';
      }
  }
  $eo = 'odd';
  OpenTable();
    if (is_array($files)) {
        $eo = 'odd';

        foreach ($files as $file => $info) {
            if ('odd' == $eo) {
                $eo = 'even';
            } else {
                $eo = 'odd';
            }

            if (is_file('images/ftype_' . $info['extension'] . '.gif')) {
                $icon = "<img src='images/ftype_" . $info['extension'] . ".gif' alt='' border=0>";
            } else {
                $icon = "<img src='images/ftype_default.gif' alt='' border=0>";
            }

            echo "<tr class=$eo><td width=1%><a href='cache/presspack/$id/$file' target=_blank>$icon</a></td><td><a href='cache/presspack/$id/$file' target=_blank>" . $info['name'] . '</a></td></tr>';
        }
    } else {
        echo '<tr><td class=even>-</td></tr>';
    }
  CloseTable();
  OpenTable();
  echo '<tr>' . _TM_SHOWINGS . '</tr>';
  $theaterman_frontend->list_instances($id, 0);
  CloseTable();

  include 'footer.php';
