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

  echo "\n<h1>" . _TM_ADKILLSPONSOR . '</h1>';
  $id = var_retrieve('id');
  if (!isset($theaterman->sponsors[$id])) {
      printf('<p>' . _TM_ESPONSORNOTFOUND . '</p>', $id);

      include 'admin_footer.php';

      exit();
  }
  if ('finish' != var_retrieve('step')) {
      printf('<p>' . _TM_ADKILLSPONSORC . '</p>', $id);

      echo "<p><a href='?id=$id&step=finish'>" . _TM_YES . "</a> - <a href='sponsors.php'>" . _TM_NO . '</a></p>';
  } else {
      unset($theaterman->sponsors[$id]);

      unset($theaterman->sponsor_order[$id]);

      if (file_exists("../cache/images/sp_$id.jpg")) {
          unlink("../cache/images/sp_$id.jpg");
      }

      $theaterman->save_all();

      printf('<p>' . _TM_SPONSORKILLED . '</p>', $id);

      echo '<a href="sponsors.php">' . _TM_BACK . '</a>';
  }

  include 'admin_footer.php';
