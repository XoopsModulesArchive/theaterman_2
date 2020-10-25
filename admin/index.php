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

if (file_exists('../language/' . $xoopsConfig['language'] . '/modinfo.php')) {
    include '../language/' . $xoopsConfig['language'] . '/modinfo.php';
} else {
    include '../language/english/modinfo.php';
}

  echo "\n<ul>";
  include 'menu.php';
  foreach ($adminmenu as $key => $data) {
      echo "\n<li><a href='../" . $data['link'] . "'>" . $data['title'] . '</a></li>';
  }
  echo "\n</ul>";
  echo "\n<hr>";
  echo "\n<ul>";
    echo "\n<li><a href='config.php'>" . _TM_CONFIG . '</a></li>';
    echo "\n<li><a href='killmaids.php'>" . _TM_MKILLMAIDS . '</a></li>';
    echo "\n<li><a href='killorphans.php'>" . _TM_MKILLORPHANS . '</a></li>';
    if (is_dir('../../theaterman/')) {
        echo "\n<li>" . _TM_OLDDETECTED . "<br><a href='port.php'>" . _TM_PORTOLDDATA . '</a></li>';
    }
  echo "\n</ul>";

  include 'admin_footer.php';
