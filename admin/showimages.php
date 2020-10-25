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

  echo "\n<h1>" . _TM_IMAGEMAN . '</h1>';
  $id = var_retrieve('id');
  if (!isset($theaterman->shows[$id])) {
      printf('<p>' . _TM_ESHOWNOTFOUND . '</p>', $id);

      include 'admin_footer.php';

      exit();
  }
  $step = var_retrieve('step');
  if ('' == $step) {
      echo _TM_IMSHOW;

      echo '<table>';

      $slot = -1;

      $message[0] = 'icon';

      while ($slot < 10) {
          $slot++;

          $sid = $slot;

          if (file_exists("../cache/images/sh_$id" . '_' . "$sid.jpg") or 0 == $slot or 1 == $slot or file_exists("../cache/images/sh_$id" . '_' . ($slot - 1) . '.jpg')) {
              if (file_exists("../cache/images/sh_$id" . '_' . "$sid.jpg")) {
                  echo "<tr><td>$slot (" . $message[$slot] . ")<td><td><img src='../cache/images/sh_$id" . '_' . "$sid.jpg'></td>";
              } else {
                  echo "<tr><td>$slot (" . $message[$slot] . ')<td><td>-</td>';
              }

              echo "<td><a href='?id=$id&step=edit&edit=$slot'>" . _TM_EDIT . "</a><br><a href='?id=$id&step=delete&delete=$slot'>" . _TM_DELETE . '</a></td></tr>';
          }
      }

      echo '</table>';
  } else {
      if ('edit' == $step) {
          $sid = var_retrieve('edit');

          printf(_TM_IMEDITSLOT, $sid);

          echo "<form enctype=\"multipart/form-data\" action=\"?\" method=\"post\"><input type=hidden name=id value=\"$id\"><input type=hidden name=step value='edit2'><input type=hidden name=sid value=\"$sid\"><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"102400\">" . _TM_IMSENDTHIS . ': <input name="userfile" type="file"><input type="submit" value="' . _TM_SUBMIT . '"></form>';
      }

      if ('edit2' == $step) {
          $sid = var_retrieve('sid');

          global $HTTP_POST_FILES;

          $lpath = "../cache/images/sh_$id" . '_' . "$sid.jpg";

          $upload = $lpath;

          if (is_file($lpath)) {
              unlink($lpath);
          }

          echo '<br>uploading ' . $HTTP_POST_FILES['userfile']['name'] . " as $lpath";

          move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], $upload);

          echo '<br>File uploaded';

          printf('<p>' . _TM_SHOWCHANGED . '</p>', $id);
      }

      if ('delete' == $step) {
          $sid = var_retrieve('delete');

          printf('<p>' . _TM_IMKILLSLOTC . '</p>', $sid);

          echo "<p><a href='?id=$id&step=delete2&sid=$sid'>" . _TM_YES . "</a> - <a href='showimages.php?id=$id'>" . _TM_NO . '</a></p>';
      }

      if ('delete2' == $step) {
          $sid = var_retrieve('sid');

          $lpath = "../cache/images/sh_$id" . '_' . "$sid.jpg";

          if (is_file($lpath)) {
              unlink($lpath);
          }

          printf('<p>' . _TM_SHOWCHANGED . '</p>', $id);
      }

      echo "<p><a href=\"showimages.php?id=$id\">" . _TM_BACK . '</a>';
  }
  include 'admin_footer.php';
