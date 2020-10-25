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
  
  echo "\n<h1>"._TM_ADEDITSEASON . '</h1>';
  $id = var_retrieve('id');
  if (!isset($theaterman->seasons[$id])) {
    printf('<p>'._TM_ESEASONNOTFOUND.'</p>',$id);
    include 'admin_footer.php';
    exit();
  }
  if (var_retrieve('step') != 'finish') {
    ?>
    <form action=? method=post>
      <input type=hidden name=step value=finish>
      <input type=hidden name=id value=<?php echo $id ?>>
      <table summary="">
        <tr><td><?php echo _TM_YEAR; ?>:</td><td><input type=text name=year value="<?php echo $theaterman->seasons[$id]['year'] ?>">&nbsp;<i>i.e. &quot;2003-2004&quot; or just &quot;2004&quot;</i></td></tr>
        <tr><td><?php echo _TM_TYPE; ?>:</td><td><input type=text name=type value="<?php echo $theaterman->seasons[$id]['name'] ?>">&nbsp;<i>i.e. &quot;Subscription&quot;</i></td></tr>
        <tr><td>&nbsp;</td><td><input type=submit value=<?php echo _TM_SUBMIT ?>></td></tr>
      </table>
    </form>
      <?php
  }else {
    echo "$id-".$theaterman->seasons[$id]['year'] . '-' . $theaterman->seasons[$id]['name'];
    $theaterman->seasons[$id]['year'] = var_retrieve('year');
    $theaterman->seasons[$id]['name'] = var_retrieve('type');
    $theaterman->save_all();
    echo "<br>$id-".$theaterman->seasons[$id]['year'] . '-' . $theaterman->seasons[$id]['name'];
    printf('<p>' . _TM_SEASONCHANGED . '</p>', $id);
    echo "<a href=\"byseason.php?id=$id\">"._TM_BACK . '</a>';
  }
  
  include 'admin_footer.php';
 ?>
