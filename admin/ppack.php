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

  echo "\n<h1>" . _TM_PRESSMAN . '</h1>';
  $id = var_retrieve('id');
  if (!isset($theaterman->shows[$id])) {
      printf('<p>' . _TM_ESHOWNOTFOUND . '</p>', $id);

      include 'admin_footer.php';

      exit();
  }
  $step = var_retrieve('step');
  $files = '';
  if (!is_dir("../cache/presspack/$id/")) {
      if (!mkdir("../cache/presspack/$id/")) {
          printf(_TM_PPACKFOLDERDENIED, $id);

          include 'admin_footer.php';

          exit();
      }  

      if (!chmod("../cache/presspack/$id/", 0777)) {
          printf(_TM_PPACKFOLDERDENIED, $id);

          include 'admin_footer.php';

          exit();
      }
  } else {
      $dir = opendir("../cache/presspack/$id/");

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
  if ('' == $step) {
      if (1 == $theaterman->shows[$id]['presspack']) {
          printf("<a href=\"?id=$id&step=toggle\">%s</a><br>", _TM_PPACKIS);
      } else {
          printf("<a href=\"?id=$id&step=toggle\">%s</a><br>", _TM_PPACKISNOT);
      }

      echo "<form enctype=\"multipart/form-data\" action=\"?\" method=\"post\"><input type=hidden name=id value=\"$id\"><input type=hidden name=step value='edit2'><input type=hidden name=sid value=\"$sid\">" . _TM_IMSENDTHIS . ': <input name="userfile" type="file"><input type="submit" value="' . _TM_SUBMIT . '"></form>';

      echo "<p><a href=\"ppack.php?id=$id\">" . _TM_BACK . '</a>';

      OpenTable();

      if (is_array($files)) {
          $eo = 'odd';

          foreach ($files as $file => $info) {
              if ('odd' == $eo) {
                  $eo = 'even';
              } else {
                  $eo = 'odd';
              }

              if (is_file('../images/ftype_' . $info['extension'] . '.gif')) {
                  $icon = "<img src='../images/ftype_" . $info['extension'] . ".gif' alt=''>";
              } else {
                  $icon = "<img src='../images/ftype_default.gif' alt=''>";
              }

              echo "<tr class=$eo><td width=1%>$icon</td><td><a href='../cache/presspack/$id/$file' target=_blank>" . $info['name'] . "</a></td><td><a href='?id=$id&step=kill&file=$file'>" . _TM_DELETE . '</a></td></tr>';
          }
      } else {
          echo '<tr><td class=even>-</td></tr>';
      }

      CloseTable();
  } else {
      if ('edit2' == $step) {
          $sid = var_retrieve('sid');

          global $HTTP_POST_FILES;

          $lpath = "../cache/presspack/$id/" . $HTTP_POST_FILES['userfile']['name'];

          $upload = $lpath;

          if (is_file($lpath)) {
              unlink($lpath);
          }

          echo '<br>uploading ' . $HTTP_POST_FILES['userfile']['name'] . " as $lpath";

          move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], $upload);

          echo '<br>File uploaded';

          printf('<p>' . _TM_SHOWCHANGED . '</p>', $id);

          echo "<p><a href=\"ppack.php?id=$id\">" . _TM_BACK . '</a>';
      }

      if ('kill' == $step) {
          $file = var_retrieve('file');

          printf('<p>' . _TM_PPACKKILLC . '</p>', $file);

          echo "<p><a href='?id=$id&step=kill2&file=$file'>" . _TM_YES . "</a> - <a href='ppack.php?id=$id'>" . _TM_NO . '</a></p>';

          echo "<p><a href=\"ppack.php?id=$id\">" . _TM_BACK . '</a>';
      }

      if ('kill2' == $step) {
          $file = var_retrieve('file');

          if (file_exists("../cache/presspack/$id/$file")) {
              if (!unlink("../cache/presspack/$id/$file")) {
                  printf('<p>' . _TM_EREMOVING . '</p>', $file);
              } else {
                  printf('<p>' . _TM_SHOWCHANGED . '</p>', $id);
              }
          } else {
              printf('<p>' . _TM_EREMOVING . '</p>', $file);
          }

          echo "<p><a href=\"ppack.php?id=$id\">" . _TM_BACK . '</a>';
      }

      if ('toggle' == $step) {
          if (1 == $theaterman->shows[$id]['presspack']) {
              $theaterman->shows[$id]['presspack'] = 0;

              echo _TM_PPACKDEACTIVATED;
          } else {
              $theaterman->shows[$id]['presspack'] = 1;

              echo _TM_PPACKACTIVATED;
          }

          $theaterman->save_all();

          echo "<p><a href=\"ppack.php?id=$id\">" . _TM_BACK . '</a>';
      }
  }
  include 'admin_footer.php';
