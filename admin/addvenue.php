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
  
  echo "\n<h1>"._TM_ADADDVENUE . '</h1>';
  if (var_retrieve('step') != 'finish') {
    ?>
    <form action=addvenue.php method=post>
      <input type=hidden name=step value=finish>
      <table summary="">
        <tr><td><?php echo _TM_NAME; ?>:</td><td><input type=text name=name>&nbsp;<i>i.e. &quot;Macey Center&quot;</i></td></tr>
        <tr><td><?php echo _TM_DIRECTIONS; ?>:</td><td><textarea rows=5 cols=40 name=directions></textarea></td></tr>
        <tr><td>&nbsp;</td><td><input type=submit value=<?php echo _TM_SUBMIT ?>></td></tr>
      </table>
    </form>
      <?php
  }else {
    $nid = $theaterman->insert_location(var_retrieve('name'),var_retrieve('directions'));
    printf('<p>' . _TM_VENUEADDED . '</p>', $nid);
  }
  echo "<a href=\"byvenue.php?id=$nid\">"._TM_BACK . '</a>';
  
  include 'admin_footer.php';
 ?>
