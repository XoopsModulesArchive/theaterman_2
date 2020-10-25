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
  
  echo "\n<h1>"._TM_ADEDITSPONSOR . '</h1>';
  $id = var_retrieve('id');
  if (!isset($theaterman->sponsors[$id])) {
    printf('<p>'._TM_ESPONSORNOTFOUND.'</p>',$id);
    include 'admin_footer.php';
    exit();
  }
  if (var_retrieve('step') != 'finish') {
    ?>
    <form action=? method=post>
      <input type=hidden name=step value=finish>
      <input type=hidden name=id value=<?php echo $id ?>>
      <table summary="">
        <tr><td><?php echo _TM_NAME; ?>:</td><td><input type=text name=name value="<?php echo $theaterman->sponsors[$id]['name'] ?>"></td></tr>
        <tr><td><?php echo _TM_WEBSITE; ?>:</td><td><input type=text name=link value="<?php echo $theaterman->sponsors[$id]['link'] ?>"></td></tr>
        <tr><td>&nbsp;</td><td><input type=submit value=<?php echo _TM_SUBMIT ?>></td></tr>
      </table>
    </form>
      <?php
  }else {
    echo "$id-".$theaterman->sponsors[$id]['name'] . '-' . $theaterman->sponsors[$id]['link'];
    $theaterman->sponsors[$id]['name'] = var_retrieve('name');
    $theaterman->sponsors[$id]['link'] = var_retrieve('link');
    $theaterman->save_all();
    echo "<br>$id-".$theaterman->sponsors[$id]['name'] . '-' . $theaterman->sponsors[$id]['link'];
    printf('<p>' . _TM_SPONSORCHANGED . '</p>', $id);
    echo '<a href="sponsors.php">' . _TM_BACK . '</a>';
  }
  
  include 'admin_footer.php';
 ?>
