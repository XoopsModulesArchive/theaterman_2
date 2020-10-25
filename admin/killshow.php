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

  echo "\n<h1>" . _TM_ADKILLSHOW . '</h1>';
  $id = var_retrieve('id');
  if (!isset($theaterman->shows[$id])) {
      printf('<p>' . _TM_ESHOWNOTFOUND . '</p>', $id);

      include 'admin_footer.php';

      exit();
  }
  if ('finish' != var_retrieve('step')) {
      printf('<p>' . _TM_ADKILLSHOWC . '</p>', $id);

      echo "<p><a href='?id=$id&step=finish'>" . _TM_YES . "</a> - <a href='allshows.php?id=$id'>" . _TM_NO . '</a></p>';
  } else {
      $theaterman->remove_show($id);

      if (is_dir("../cache/presspack/$id/")) {
          $dir = opendir("../cache/presspack/$id/");

          while (false !== ($file = readdir($dir))) {
              if ('.' != $file && '..' != $file) {
                  if (!unlink("../cache/presspack/$id/$file")) {
                      printf('<p>' . _TM_EREMOVING, "../cache/presspack/$id/$file");
                  }
              }
          }

          closedir($dir);

          if (!rmdir("../cache/presspack/$id/")) {
              printf('<p>' . _TM_EREMOVING, "../cache/presspack/$id");
          }
      }

      $theaterman->save_all();

      printf('<p>' . _TM_SHOWKILLED . '</p>', $id);

      echo '<a href="allshows.php">' . _TM_BACK . '</a>';
  }

  include 'admin_footer.php';
