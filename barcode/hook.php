<?php

function plugin_barcode_MassiveActions($type)
{
    switch ($type)
    {
        // New action for core and other plugin types : name = plugin_PLUGINNAME_actionname
        case 'Computer' :
        case 'Monitor' :
        case 'Networking' :
        case 'Printer' :
        case 'Device' :
        case 'Phone' :
            return array("PluginBarcodeBarcode".MassiveAction::CLASS_ACTION_SEPARATOR.'Generate' => __('Barcode', 'barcode')." - ".__('Print barcodes', 'barcode'));

//      case 'Profile' :
//         return array("plugin_barcode_allow" => __('Barcode', 'barcode'));
    }

    return array();
}

function plugin_barcode_install()
{
    global $DB;

    if (!TableExists("glpi_plugin_barcode_configs") && !TableExists("glpi_plugin_barcode_computers")
        && !TableExists("glpi_plugin_barcode_monitors") && !TableExists("glpi_plugin_barcode_printers")
        && !TableExists("glpi_plugin_barcode_phones") && !TableExists("glpi_plugin_barcode_networks")
        && !TableExists("glpi_plugin_barcode_devices"))
    {
        $DB->runFile(GLPI_ROOT . "/plugins/barcode/sql/barcode.sql");
    }

    return true;
}

function plugin_barcode_uninstall()
{
    global $DB;

    $tables = array("glpi_plugin_barcode_profiles",
        "glpi_plugin_barcode_configs",
        "glpi_plugin_barcode_computers",
        "glpi_plugin_barcode_monitors",
        "glpi_plugin_barcode_printers",
        "glpi_plugin_barcode_phones",
        "glpi_plugin_barcode_networks",
        "glpi_plugin_barcode_devices");

    foreach ($tables as $table)
        $DB->query("DROP TABLE IF EXISTS `$table`;");

    include_once (GLPI_ROOT . "/plugins/barcode/inc/profile.class.php");

    PluginBarcodeProfile::removeRightsFromSession();
    PluginBarcodeProfile::removeRightsFromDB();

    return true;
}