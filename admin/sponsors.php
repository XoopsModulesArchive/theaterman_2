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

  echo "\n<h1>" . _TM_ADSPONSORS . '</h1><a href="topsponsors.php">' . _TM_ADTOPSPONSORS . '</a><hr>';
  foreach ($theaterman->sponsors as $sid => $sdata) {
      $sorder[$sid] = $sdata['name'];
  }
  arsort($sorder);
  $sorder = array_reverse($sorder, true);
  echo "\n<table>";
  foreach ($sorder as $sid => $sname) {
      echo "\n  <tr>";

      echo "\n    <td><b>$sname</b></td>";

      echo "\n    <td><a href=editsponsor.php?id=$sid>" . _TM_EDIT . "</a> - <a href=simage.php?id=$sid>" . _TM_IMAGE . "</a> - <a href=killsponsor.php?id=$sid>" . _TM_DELETE . '</a></td>';

      echo "\n  </tr>";
  }
  echo "\n</table>";

  include 'admin_footer.php';
