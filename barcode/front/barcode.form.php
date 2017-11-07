<?php

/*
   ------------------------------------------------------------------------
   Barcode
   Copyright (C) 2009-2016 by the Barcode plugin Development Team.

   https://forge.indepnet.net/projects/barscode
   ------------------------------------------------------------------------

   LICENSE

   This file is part of barcode plugin project.

   Plugin Barcode is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   Plugin Barcode is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with Plugin Barcode. If not, see <http://www.gnu.org/licenses/>.

   ------------------------------------------------------------------------

   @package   Plugin Barcode
   @author    David Durieux
   @co-author
   @copyright Copyright (c) 2009-2016 Barcode plugin Development team
   @license   AGPL License 3.0 or (at your option) any later version
              http://www.gnu.org/licenses/agpl-3.0-standalone.html
   @link      https://forge.indepnet.net/projects/barscode
   @since     2009

   ------------------------------------------------------------------------
 */

include ('../../../inc/includes.php');

if (isset($_POST['type']) && isset($_POST['id']) && isset($_POST['count']))
{
   switch($_POST['type'])
   {
       case "Computer" :

           if (isset($_POST['sql']) && $_POST['sql'] == 0)
              $sql = "UPDATE `glpi_plugin_barcode_computers` SET `ean13`='".$_POST['ean13']."' WHERE `computer_id`='".$_POST['id']."' ";
           else {
               $sql = "INSERT INTO `glpi_plugin_barcode_computers` (`computer_id`, `ean13`) VALUES ('" . $_POST['id'] . "', '" . $_POST['ean13'] . "')";
               $sql1 = "UPDATE `glpi_plugin_barcode_configs` SET `value`='".$_POST['count']."' WHERE `name`='count_computers' ";
           }

           $DB->query($sql);

           if(isset($sql1)) $DB->query($sql1);

           if (!is_dir(GLPI_PLUGIN_DOC_DIR.'/barcode'))
           {
               mkdir(GLPI_PLUGIN_DOC_DIR.'/barcode');
           }

           if (!is_dir(GLPI_PLUGIN_DOC_DIR.'/barcode/pdf'))
           {
               mkdir(GLPI_PLUGIN_DOC_DIR.'/barcode/pdf');
           }
           else {
               $sql = "SELECT * FROM `glpi_computers` WHERE `id`='".$_POST['id']."' ";
               $res = $DB->query($sql);
               $str = $DB->result($res, 0, "name");
               $serial = $DB->result($res, 0, "serial");

               $pdf = new PluginBarcodePdf('L', 'mm', array('42','30'));
               $pdf->SetAutoPageBreak(false);
               $pdf->AddPage();
               $pdf->SetFont('Arial','',7);

               $pdf->Text(2,5, $str);
               $pdf->Text(2,10, "S/N: ");
               $pdf->Text(8,10, $serial);

               $pdf->EAN13(2,13, $_POST['ean13'], 10, '.26');
               $pdf->Output("I", GLPI_PLUGIN_DOC_DIR.'/barcode/pdf/'.$_POST['ean13'].'.pdf');
           }
           break;
   }
}

Html::back();
?>
