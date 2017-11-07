<?php
define("PLUGIN_BARCODE_VERSION", "1.0.0");

function plugin_init_barcode()
{
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['barcode'] = true;

    Plugin::registerClass('PluginBarcodeConfig', array('addtabon' => 'Config'));

    $types = array('Central', 'Computer', 'ComputerDisk', 'Notification', 'Phone', 'Preference', 'Profile', 'Supplier');
    Plugin::registerClass('PluginBarcodeBarcode', array('notificationtemplates_types' => true, 'addtabon' => $types, 'link_types' => true));

    if (version_compare(GLPI_VERSION,'9.1','ge'))
    {
        if (class_exists('PluginBarcodeBarcode'))
        {
            Link::registerTag(PluginBarcodeBarcode::$tags);
        }
    }

    $_SESSION["glpi_plugin_barcode_profile"]['barcode'] = 'w';

    if (isset($_SESSION["glpi_plugin_barcode_profile"]))
    {
        $PLUGIN_HOOKS['menu_toadd']['barcode'] = array('plugins' => 'PluginBarcodeBarcode', 'tools' => 'PluginBarcodeBarcode');
    }

    $PLUGIN_HOOKS['csrf_compliant']['barcode'] = true;
    $PLUGIN_HOOKS['use_massive_action']['barcode'] = 1;
    $PLUGIN_HOOKS['add_javascript']['barcode'] = array('js/barcode.min.js');
}

function plugin_version_barcode()
{
   return array(
      'name' => 'Barcode',
      'version' => PLUGIN_BARCODE_VERSION,
      'license' => 'GPLv2+',
      'author' => 'Magelan',
      'homepage' => 'http://inv.magelan.ru',
      'minGlpiVersion' => '0.85'
   ); // For compatibility / no install in version < 0.85
}

function plugin_barcode_check_prerequisites()
{
   if (version_compare(GLPI_VERSION, '0.85', '>=') && version_compare(GLPI_VERSION, '9.2', '<'))
   {
      return true;
   }
   else
   {
      _e('This plugin requires GLPI >= 0.85 && < 9.2', 'barcode');
      return false;
   }
}

function plugin_barcode_check_config()
{
   return true;
}
?>
