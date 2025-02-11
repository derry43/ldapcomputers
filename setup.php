<?php
/*
 -------------------------------------------------------------------------
 LDAP computers plugin for GLPI
 Copyright (C) 2019 by the ldapcomputers Development Team.

 https://github.com/pluginsGLPI/ldapcomputers
 -------------------------------------------------------------------------

 LICENSE

 This file is part of LDAP computers.

 LDAP computers is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 LDAP computers is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with LDAP computers. If not, see <http://www.gnu.org/licenses/>.

------------------------------------------------------------------------

   @package   Plugin LDAP Computers
   @author    Aleksey Kotryakhov
   @co-author
   @copyright Copyright (c) 2009-2016 Barcode plugin Development team
   @license   AGPL License 3.0 or (at your option) any later version
              http://www.gnu.org/licenses/agpl-3.0-standalone.html
   @link      https://github.com/akm77/ldapcomputers
   @since     2019


 --------------------------------------------------------------------------
 */

define('PLUGIN_LDAPCOMPUTERS_VERSION', '0.5.0');
// Minimal GLPI version, inclusive
define('PLUGIN_LDAPCOMPUTERS_MIN_GLPI', '10.0');
// Maximum GLPI version, exclusive
define('PLUGIN_LDAPCOMPUTERS_MAX_GLPI', '10.1');

/**
 * Init hooks of the plugin.
 * REQUIRED
 *
 * @return void
 */
function plugin_init_ldapcomputers() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['ldapcomputers'] = true;

   /* Setup tabs on objects */
   Plugin::registerClass('PluginLdapcomputersProfile', ['addtabon' => ['Profile']]);
   Plugin::registerClass('PluginLdapcomputersComputer', ['addtabon' => ['Computer']]);
   /* Enable massive action*/
   $PLUGIN_HOOKS['use_massive_action']['ldapcomputers'] = 1;

   if (Session::getLoginUserID()) {
      // Display a menu entry ?
      if (Session::haveRightsOr("plugin_ldapcomputers_config", [READ, UPDATE])) {
         // add link in plugin page
         $PLUGIN_HOOKS['config_page']['ldapcomputers'] = 'front/config.php';
         // add entry to configuration menu
         $PLUGIN_HOOKS["menu_toadd"]['ldapcomputers']['config'] = 'PluginLdapcomputersConfigmenu';
      }
      if (Session::haveRightsOr("plugin_ldapcomputers_view", [READ, UPDATE])) {
         // add entry to view computers menu
         $PLUGIN_HOOKS["menu_toadd"]['ldapcomputers']['admin']  = 'PluginLdapcomputersLdapcomputersmenu';
      }
   }
}


/**
 * Get the name and the version of the plugin
 * REQUIRED
 *
 * @return array
 */
function plugin_version_ldapcomputers() {
   return [
      'name'           => __('LDAP computers', 'ldapcomputers'),
      'version'        => PLUGIN_LDAPCOMPUTERS_VERSION,
      'author'         => '<a href="https://github.com/akm77/ldapcomputers">Aleksey Kotryakhov</a>',
      'license'        => 'AGPLv3+',
      'homepage'       => 'https://github.com/akm77/ldapcomputers',
      'requirements'   => [
         'glpi' => [
            'min' => PLUGIN_LDAPCOMPUTERS_MIN_GLPI,
            'max' => PLUGIN_LDAPCOMPUTERS_MAX_GLPI,
         ]
      ]
   ];
}

/**
 * Check pre-requisites before install
 * OPTIONNAL, but recommanded
 *
 * @return boolean
 */
function plugin_ldapcomputers_check_prerequisites() {

   //Version check is not done by core in GLPI < 9.2 but has to be delegated to core in GLPI >= 9.2.
   $version = preg_replace('/^((\d+\.?)+).*$/', '$1', GLPI_VERSION);
   echo $version;
   if (version_compare($version, '9.2', '<')) {
      $matchMinGlpiReq = version_compare($version, PLUGIN_LDAPCOMPUTERS_MIN_GLPI, '>=');
      $matchMaxGlpiReq = version_compare($version, PLUGIN_LDAPCOMPUTERS_MAX_GLPI, '<');

      if (!$matchMinGlpiReq || !$matchMaxGlpiReq) {
         echo vsprintf(
            'This plugin requires GLPI >= %1$s and < %2$s. Current version is %3$s.',
            [
               PLUGIN_LDAPCOMPUTERS_MIN_GLPI,
               PLUGIN_LDAPCOMPUTERS_MAX_GLPI,
               $version,
            ]
         );
         return false;
      }
   }
   return true;
}

/**
 * Check configuration process
 *
 * @param boolean $verbose Whether to display message on failure. Defaults to false
 *
 * @return boolean
 */
function plugin_ldapcomputers_check_config($verbose = false) {
   if (true) { // Your configuration check
      return true;
   }

   if ($verbose) {
      echo __('Installed / not configured', 'ldapcomputers');
   }
   return false;
}
