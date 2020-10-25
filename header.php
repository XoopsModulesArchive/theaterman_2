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
  require dirname(__DIR__, 2) . '/mainfile.php';
  error_reporting(E_ALL ^ E_NOTICE);
  // functions------------------------------------------------------------------
    include 'functions/data_clean.php';
    include 'functions/gt_date.php';
    include 'functions/var_retrieve.php';
  // classes--------------------------------------------------------------------
    // error--------------------------------------------------------------------
      include 'classes/gt_error.class.php';
      $gt_error = new gt_error();
    // alert--------------------------------------------------------------------
      include 'classes/gt_alert.class.php';
      $gt_alert = [];
    // text sanitizer-----------------------------------------------------------
      include 'classes/gt_textsan.class.php';
      $gt_textsan = new gt_textsan();
    // data---------------------------------------------------------------------
      include 'classes/gt_data.class.php';
      $gt_data = new gt_data();
      $gt_data->set_path('cache/');
    // cache--------------------------------------------------------------------
      include 'classes/gt_cache.class.php';
      $gt_cache = new gt_cache();
      $gt_cache->set_path('cache/syscache/');
      $gt_cache->set_prefix('tmcache_');
      $gt_cache->set_lifetime('60');
    // theaterman---------------------------------------------------------------
      include 'classes/theaterman_2.class.php';
      $theaterman = new theaterman('tm2_0');
    // theaterman frontend------------------------------------------------------
      include 'classes/theaterman_frontend.class.php';
      $theaterman_frontend = new tmfront();
    //--------------------------------------------------------------------------
    //global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger;
    require XOOPS_ROOT_PATH . '/header.php';
