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
$modversion['name'] = 'TheaterMan 2';
$modversion['version'] = '2.0';
$modversion['description'] = 'Another incarnation of TheaterMan, written to allow a single event description and other data to be listed at different times and locations';
$modversion['credits'] = '';
$modversion['author'] = '&lt;Joby Elliott&gt;';
$modversion['help'] = 'help.html';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 0;
$modversion['image'] = 'theaterman_smlogo.gif';
$modversion['dirname'] = 'theaterman_2';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'functions/search.php';
$modversion['search']['func'] = 'tm_search';

// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Menu
error_reporting(0);
$modversion['hasMain'] = 1;
  $modversion['sub'][1]['name'] = _TM_MVENUE;
  $modversion['sub'][1]['url'] = 'byvenue.php';
  $modversion['sub'][2]['name'] = _TM_MSEASON;
  $modversion['sub'][2]['url'] = 'byseason.php';
  $modversion['sub'][3]['name'] = _TM_MALL;
  $modversion['sub'][3]['url'] = 'all.php';
  $modversion['sub'][4]['name'] = _TM_MSPONSORS;
  $modversion['sub'][4]['url'] = 'sponsors.php';
