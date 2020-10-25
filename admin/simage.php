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
  if (file_exists("../cache/images/s_$id.jpg")) {
      echo "<img src=\"../cache/images/sp_$id.jpg\" alt=\"\">";
  }
  if (!isset($theaterman->sponsors[$id])) {
      printf('<p>' . _TM_ESPONSORNOTFOUND . '</p>', $id);

      include 'admin_footer.php';

      exit();
  }
  if ('finish' != var_retrieve('step')) {
      printf('<p>' . _TM_IMSPONSOR . '', $theaterman->sponsors[$id]['name']);

      if (file_exists("../cache/images/sp_$id.jpg")) {
          echo '<br>' . _TM_IMSIMGIS;
      } else {
          echo '<br>' . _TM_IMSIMGISNOT;
      }

      echo "<form enctype=\"multipart/form-data\" action=\"?\" method=\"post\"><input type=hidden name=id value=\"$id\"><input type=hidden name=step value='finish'><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"102400\">" . _TM_IMSENDTHIS . ': <input name="userfile" type="file"><input type="submit" value="' . _TM_SUBMIT . '"></form>';
  } else {
      global $HTTP_POST_FILES;

      $lpath = "../cache/images/sp_$id.jpg";

      $upload = $lpath;

      if (is_file($lpath)) {
          unlink($lpath);
      }

      echo '<br>uploading ' . $HTTP_POST_FILES['userfile']['name'] . " as $lpath";

      move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], $upload);

      echo '<br>File uploaded';

      printf('<p>' . _TM_SPONSORCHANGED . '</p>', $id);
  }
  echo '<p><a href="sponsors.php">' . _TM_BACK . '</a>';

  include 'admin_footer.php';
