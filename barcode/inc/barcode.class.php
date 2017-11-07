<?php
class PluginBarcodeBarcode extends CommonDBTM
{
    static $tags = '[BARCODE_ID]';

    static function getTypeName($nb = 0)
    {
        return 'Barcode Type';
    }

    static function canCreate()
    {
        if (isset($_SESSION["glpi_plugin_barcode_profile"]))
        {
            return ($_SESSION["glpi_plugin_barcode_profile"]['barcode'] == 'w');
        }

        return false;
    }

    static function canView()
    {
        if (isset($_SESSION["glpi_plugin_barcode_profile"]))
        {
            return ($_SESSION["glpi_plugin_barcode_profile"]['example'] == 'w' || $_SESSION["glpi_plugin_barcode_profile"]['barcode'] == 'r');
        }

        return false;
    }

    static function getMenuName()
    {
        return __('Barcode plugin');
    }

    function getTabNameForItem(CommonGLPI $item, $withtemplate=0)
    {
        if (!$withtemplate)
        {
            switch ($item->getType())
            {
                case 'Profile' :
                    if ($item->getField('central'))
                    {
                        return __('BARCODE', 'barcode');
                    }
                    break;

                case 'Phone' :
                    if ($_SESSION['glpishow_count_on_tabs']) {
                        return self::createTabEntry(__('Example', 'example'),
                            countElementsInTable($this->getTable()));
                    }
                    return __('Example', 'example');

                case 'ComputerDisk' :
                case 'Supplier' :
                    return array(1 => __("Test Plugin", 'example'),
                        2 => __("Test Plugin 2", 'example'));

                case 'Computer' :
                case 'Central' :
                case 'Preference':
                case 'Notification':
                    return array(1 => __("BARCODE", 'barcode'));

            }
        }

        return '';
    }

    static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0)
    {
        switch ($item->getType())
        {
            case 'Phone' :
                _e("Plugin Example on Phone", 'example');
                break;

            case 'Central' :
                _e("Plugin central action", 'example');
                break;

            case 'Preference' :
                // Complete form display
                $data = plugin_version_example();

                echo "<form action='Where to post form'>";
                echo "<table class='tab_cadre_fixe'>";
                echo "<tr><th colspan='3'>".$data['name']." - ".$data['version'];
                echo "</th></tr>";

                echo "<tr class='tab_bg_1'><td>Name of the pref</td>";
                echo "<td>Input to set the pref</td>";

                echo "<td><input class='submit' type='submit' name='submit' value='submit'></td>";
                echo "</tr>";

                echo "</table>";
                echo "</form>";
                break;

            case 'Notification' :
                _e("Plugin mailing action", 'example');
                break;

            case 'ComputerDisk' :
            case 'Supplier' :
                if ($tabnum==1) {
                    _e('First tab of Plugin example', 'example');
                } else {
                    _e('Second tab of Plugin example', 'example');
                }
                break;
            case 'Computer' :
                $bc = new self();
                $bc->showForm($item->getType(), $item->getField('id'));
                break;

            default :
                //TRANS: %1$s is a class name, %2$d is an item ID
                printf(__('Plugin example CLASS=%1$s id=%2$d', 'example'), $item->getType(), $item->getField('id'));
                break;
        }

        return true;
    }

    static function generateLinkContents($link, CommonDBTM $item)
    {
        if (strstr($link,"[BARCODE_ID]"))
        {
            $link = str_replace("[BARCODE_ID]", $item->getID(),$link);
            return array($link);
        }


        return parent::generateLinkContents($link, $item);
    }

    function showForm($p_type, $p_ID)
    {
        global $CFG_GLPI, $DB;

        $sql = "";
        $sql_ins = 1;
        $val = 0;
        $bc_ean13 = '20000';
        $bc_pref = '00';

        switch ($p_type)
        {
            case 'Computer' :
                $bc_pref = '10';

                $sql = "SELECT * FROM `glpi_plugin_barcode_computers` WHERE `computer_id`='".$p_ID."' ";
                $res = $DB->query($sql);
                $n = $DB->numrows($res);

                if($n != 0)
                {
                    $sql_ins = 0;

                    $sql = "SELECT * FROM `glpi_plugin_barcode_configs` WHERE `name`='count_computers' ";
                    $tres = $DB->query($sql);

                    $ss = "".$DB->result($tres, 0, "value");
                    $bc_ean13 = $DB->result($res, 0, "ean13");
                }
                else
                {
                    $sql = "SELECT * FROM `glpi_plugin_barcode_configs` WHERE `name`='count_computers' ";
                    $tres = $DB->query($sql);

                    $val = $DB->result($tres, 0, "value");
                    $val++;

                    $ss = "".$val;
                    $bc_ean13 .= $bc_pref.str_pad($ss, 5, '0', STR_PAD_LEFT);
                }
                break;
        }

        echo "<form name='form' method='post' action='".$CFG_GLPI['root_doc']."/plugins/barcode/front/barcode.form.php'>";
        echo "<div align='center'>";
        echo "<table class='tab_cadre'>";
        echo "<tr><th colspan='4'>".__('Штрихкод - [EAN13]', 'barcode')."</th></tr>";
        echo "<tr class='tab_bg_1'>";
        echo "<td>".__('Код', 'barcode')."</td><td>";
        echo "<input id='ean13' type='text' name='ean13' value='".$bc_ean13."'>";
        echo "<input id='clear' type='button' value='X' class='submit'>";
        echo "<input type='hidden' name='count' value='".$val."'>";
        echo "<input type='hidden' name='type' value='".$p_type."'>";
        echo "<input type='hidden' name='id' value='".$p_ID."'>";
        echo "<input type='hidden' name='sql' value='".$sql_ins."'>";
        echo "</td>";
        echo "<td></td>";
        echo "</tr>";

        echo "<tr class='tab_bg_1'>";
        echo "<td colspan='2'>";
        echo "<div>
                <img id='barcode2'/>
                <script>
                    JsBarcode('#barcode2', '".$bc_ean13."', {
                      format: 'EAN13',
                      height: 60,
                      displayValue: true,
                      fontSize:14,
                      lineColor: '#000000'
                    });
                    
                    $('#clear').on('click', function() { $('#ean13').val(''); });
                </script>
            </div>";
        echo "</td>";
        echo "</tr>";


        echo "<tr><td class='tab_bg_1' colspan='4' align='center'><input type='submit' value='".__('Сохранить', 'barcode')."' class='submit'></td></tr>";
        echo "</table>";
        echo "</div>";
        Html::closeForm();
    }
}