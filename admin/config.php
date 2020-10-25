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

  echo "\n<h1>" . _TM_ADCONFIG . '</h1>';
  if ('finish' != var_retrieve('step')) {
      ?>
    <form action=? method=post>
      <input type=hidden name=step value=finish>
      <table>
        <?php
          $lid = 0;

      $sid = 0;

      $spage['all'] = ' selected';

      if ('location' == $theaterman->config['start page']) {
          $lid = $theaterman->config['start id'];

          $spage['location'] = ' selected';

          $spage['all'] = '';
      }

      if ('season' == $theaterman->config['start page']) {
          $sid = $theaterman->config['start id'];

          $spage['season'] = ' selected';

          $spage['all'] = '';
      } ?>
        <tr><td><b><?php echo _TM_SPAGE ?>:</b></td><td><select name=spage>
          <option value=all<?php echo $spage['all']; ?>><?php echo _TM_MALL; ?></option>
          <option value=season<?php echo $spage['season']; ?>><?php echo _TM_MSEASON; ?></option>
          <option value=location<?php echo $spage['location']; ?>><?php echo _TM_MVENUE; ?></option>
        </select></td></tr>
        <tr><td><b><?php echo _TM_ID ?>:</b></td><td><?php $theaterman->listbox('locations', $lid) ?><?php $theaterman->listbox('seasons', $sid) ?></td></tr>
        
        <tr><td></td><td><input type=submit value="<?php echo _TM_SUBMIT; ?>"></td></tr>
      </table>
    </form>
    <?php
  } else {
      $theaterman->config['start page'] = var_retrieve('spage');

      if ('location' == var_retrieve('spage')) {
          $theaterman->config['start id'] = var_retrieve('location');
      } else {
          $theaterman->config['start id'] = var_retrieve('season');
      }

      $theaterman->save_all();

      printf('<p>' . _TM_CONFIGCHANGED . '</p>', $id);
  }
  include 'admin_footer.php';
 ?>
