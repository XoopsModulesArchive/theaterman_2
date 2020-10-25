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
  //MENU
  define('_TM_MKILLMAIDS', 'Remove childless posts');
  define('_TM_MKILLORPHANS', 'Remove orphaned instances');
  define('_TM_CONFIG', 'Configuration');
  //ALERTS
  define('_TM_SEASONADDED', 'New season #%s added, do not refresh this page');
  define('_TM_VENUEADDED', 'New venue #%s added, do not refresh this page');
  define('_TM_SHOWADDED', 'New show #%s added, do not refresh this page<br><a href=addinstance.php?show=%s>Add Instance Now</a>');
  define('_TM_SEASONBUMPED', 'Season #%s has been bumped');
  define('_TM_VENUEBUMPED', 'Venue #%s has been bumped');
  define('_TM_OLDDETECTED', 'Older version of TheaterMan detected');
  define('_TM_PORTOLDDATA', 'Import old data files');
  define('_TM_NOOLD', 'Import error: previous version not found');
  define('_TM_SEASONCHANGED', 'Season #%s updated');
  define('_TM_LOCATIONCHANGED', 'Venue #%s updated');
  define('_TM_SPONSORCHANGED', 'Sponsor #%s updated');
  define('_TM_INSTANCECHANGED', 'Instance #%s updated');
  define('_TM_SHOWCHANGED', 'Show #%s updated');
  define('_TM_KILLINGORPHANS', 'Killing orphaned instances');
  define('_TM_ORPHANSKILLED', '%s orphans found and removed');
  define('_TM_KILLINGMAIDS', 'Killing childless shows');
  define('_TM_MAIDSKILLED', '%s childless shows found and removed');
  define('_TM_BUMP', 'Bump');
  define('_TM_BUMPED', 'Bump successful');
  define('_TM_BUMPING', 'Bumping');
  define('_TM_EDIT', 'Edit');
  define('_TM_BACK', 'Back');
  define('_TM_EDITPARENT', 'Edit Parent');
  define('_TM_DELETE', 'Delete');
  define('_TM_IMAGE', 'Image');
  define('_TM_PPACK', 'PressPack');
  define('_TM_SPAGE', 'Start Page');
  define('_TM_ID', 'ID');
  define('_TM_ADDINSTANCE', 'Add Instance');
  define('_TM_ADKILLLOCATIONC', 'Really delete venue #%s?');
  define('_TM_ADKILLSEASONC', 'Really delete season #%s?');
  define('_TM_ADKILLSPONSORC', 'Really delete sponsor #%s?');
  define('_TM_ADKILLINSTANCEC', 'Really delete instance #%s?');
  define('_TM_ADKILLSHOWC', 'Really delete show #%s?');
  define('_TM_SEASONKILLED', 'Season #%s has been removed');
  define('_TM_LOCATIONKILLED', 'Venue #%s has been removed');
  define('_TM_SPONSORKILLED', 'Sponsor #%s has been removed');
  define('_TM_SHOWKILLED', 'Show #%s has been removed');
  define('_TM_INSTANCEKILLED', 'Instance #%s has been removed');
  define('_TM_CONFIGCHANGED', 'Configuration updated');
  define('_TM_ONLYINSTANCE', 'You are editing an instance of <a href="allshows.php#s%s">show #%s</a>');
  //PAGE TITLES
  define('_TM_ADADDSEASON', 'Add Season');
  define('_TM_ADADDVENUE', 'Add Venue');
  define('_TM_ADADDSHOW', 'Add Show');
  define('_TM_ADADDINSTANCE', 'Add Instance');
  define('_TM_ADADDSPONSOR', 'Add Sponsor');
  define('_TM_ADBUMPSEASON', 'Bump Season');
  define('_TM_ADBUMPVENUE', 'Bump Venue');
  define('_TM_PORTING', 'Importing From Previous Installation');
  define('_TM_BYSEASON', 'Manage Seasons');
  define('_TM_BYVENUE', 'Manage Venues');
  define('_TM_ALLSHOWS', 'All Shows');
  define('_TM_ADSPONSORS', 'Manage Sponsors');
  define('_TM_ADKILLLOCATION', 'Removing Location');
  define('_TM_ADKILLSEASON', 'Removing Season');
  define('_TM_ADKILLSPONSOR', 'Removing Sponsor');
  define('_TM_ADKILLSHOW', 'Removing Show');
  define('_TM_ADKILLINSTANCE', 'Removing Instance');
  define('_TM_ADEDITLOCATION', 'Editing Venue');
  define('_TM_ADEDITSEASON', 'Editing Season');
  define('_TM_ADEDITSPONSOR', 'Editing Sponsor');
  define('_TM_ADEDITSHOW', 'Editing Show');
  define('_TM_ADEDITINSTANCE', 'Editing Instance');
  define('_TM_ADINSTANCENOTFOUND', 'Instance #%s could not be found');
  define('_TM_ADTOPSPONSORS', 'Top Sponsors');
  define('_TM_ADCONFIG', 'Configuration');
  define('_TM_EREMOVING', 'Error removing <i>%s</i>, please check your file permissions and try again');
  //IMAGE MANAGERS
  define('_TM_IMAGEMAN', 'Image Manager');
  define('_TM_IMSPONSOR', 'Sponsor image for <i>%s</i> should be 150 px wide, any height');
  define('_TM_IMSIMGIS', 'There is already an image uploaded');
  define('_TM_IMSIMGISNOT', 'No image currently uploaded');
  define('_TM_IMSENDTHIS', 'Send this file');
  define('_TM_IMEDITSLOT', 'Editing slot #%s');
  define('_TM_IMSHOW', 'Show images can be any size, except the icon which should be 24x36 px.');
  define('_TM_IMKILLSLOTC', 'Really remove the image in slot #%s?');
  // PRESS PACKAGE MANAGER
  define('_TM_PRESSMAN', 'Press Materials Manager');
  define('_TM_PPACKFTYPES', 'The following file extensions are supported');
  define('_TM_PPACKSENDTHIS', 'Send this file');
  define('_TM_PPACKEDITSLOT', 'Editing slot #%s');
  define('_TM_PPACKKILLC', 'Really remove the file <i>%s</i>?');
  define('_TM_PPACKBADEXT', '<i>.%s</i> is not an allowed file type');
  define('_TM_PPACKIS', 'deactivate press package');
  define('_TM_PPACKISNOT', 'activate press package');
  define('_TM_PPACKACTIVATED', 'press package activated');
  define('_TM_PPACKDEACTIVATED', 'press package deactivated');
  define('_TM_PPACKFOLDERDENIED', 'the folder <i>cache/presspack/%s/</i> could not be created, please check your file permissions and try again');
