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
  
  echo "\n<h1>"._TM_ADEDITSHOW . '</h1>';
  $id = var_retrieve('id');
  if (!isset($theaterman->shows[$id])) {
    printf('<p>'._TM_ESHOWNOTFOUND.'</p>',$id);
    include 'admin_footer.php';
    exit();
  }
  if (var_retrieve('step') != 'finish') {
    ?>
        <form action=? method=post>
        <input type=hidden name=step value=finish>
        <input type=hidden name=id value=<?php echo $id; ?>
        <div><?php echo _TM_ADDINSHOW; ?></div>
        <table>
          <tr><td><b><?php echo _TM_TITLE; ?>:</b></td><td><input type=text name='title' value="<?php echo $theaterman->shows[$id]['title']; ?>"></td></tr>
          <tr><td><b><?php echo _TM_DESC; ?>:</b></td><td><textarea rows=5 cols=40 name='description'><?php echo $theaterman->shows[$id]['description']; ?></textarea></td></tr>
          <tr><td><b><?php echo _TM_PRICE; ?>:</b></td><td><input type=text name='price' value="<?php echo $theaterman->shows[$id]['price']; ?>"></td></tr>
          <tr><td><b><?php echo _TM_WEBSITE; ?>:</b></td><td><input type=text name='website' value="<?php echo $theaterman->shows[$id]['url']; ?>"></td></tr>
          <tr><td><b><?php echo _TM_SPONSORS; ?>:</b></td><td><?php $theaterman->listbox('sponsors', $id); ?></td></tr>
          <tr><td></td><td><input type=submit value="<?php echo _TM_SUBMIT; ?>"></td></tr>
        </table>
        </form>
      <?php
  }else {
    $theaterman->shows[$id]['title']       = var_retrieve('title');
    $theaterman->shows[$id]['description'] = var_retrieve('description');
    $theaterman->shows[$id]['price']       = var_retrieve('price');
    $theaterman->shows[$id]['url']         = var_retrieve('website');
    $theaterman->shows[$id]['sponsors']    = var_retrieve('sponsors');
    $theaterman->save_all();
    printf('<p>' . _TM_SHOWCHANGED . '</p>', $id);
    echo "<a href=\"allshows.php#s$id\">"._TM_BACK . '</a>';
  }
  include 'admin_footer.php';
 ?>
