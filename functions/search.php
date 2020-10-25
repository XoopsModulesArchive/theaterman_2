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
  function tm_search($queryarray, $andor, $limit, $offset, $userid)
  {
      // gt_alert-----------------------------------------------------------------

      include 'modules/theaterman_2/classes/gt_alert.class.php';

      // gt_data------------------------------------------------------------------

      include 'modules/theaterman_2/classes/gt_data.class.php';

      $gt_data = new gt_data();

      $gt_data->set_prefix('gt_data_');

      $gt_data->set_path('modules/theaterman_2/cache/');

      $shows = $gt_data->read('tm2_0_shows');

      $found = 0;

      $return = [];

      if ('OR' == $andor) {
          foreach ($shows as $sid => $sdata) {
              $qfound = 0;

              foreach ($queryarray as $quid => $query) {
                  if (eregi(mb_strtolower($query), mb_strtolower($sdata['title']))) {
                      //$return[$found]["image"] = "";

                      $qfound = 1;
                  }
              }

              if (1 == $qfound) {
                  $return[$found]['title'] = '' . $sdata['title'] . '';

                  $return[$found]['link'] = "show.php?id=$sid";

                  $return[$found]['time'] = '';

                  $return[$found]['uid'] = '';

                  $found++;
              }
          }
      } elseif ('AND' == $andor) {
          $needed = count($queryarray);

          foreach ($shows as $sid => $sdata) {
              $qfound = 0;

              foreach ($queryarray as $quid => $query) {
                  if (eregi(mb_strtolower($query), mb_strtolower($sdata['title']))) {
                      $qfound++;
                  }
              }

              if ($qfound >= $needed) {
                  $return[$found]['title'] = '' . $sdata['title'] . '';

                  $return[$found]['link'] = "show.php?id=$sid";

                  $return[$found]['time'] = '';

                  $return[$found]['uid'] = '';

                  $found++;
              }
          }
      } elseif ('exact' == $andor) {
          $query = implode(' ', $queryarray);

          foreach ($shows as $sid => $sdata) {
              if (eregi($query, mb_strtolower($sdata['title']))) {
                  $return[$found]['title'] = '' . $sdata['title'] . '';

                  $return[$found]['link'] = "show.php?id=$sid";

                  $return[$found]['time'] = '';

                  $return[$found]['uid'] = '';

                  $found++;
              }
          }
      }

      return($return);
  }
