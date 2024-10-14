<?php
use GlpiPlugin\Formcreator\Exception\ImportFailureException;
use GlpiPlugin\Formcreator\Exception\ExportFailureException;

include_once(__DIR__ . "/../data/qrcode.php");

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

/**
 * @since 0.90-1.5
 */
class PluginFormcreatorForm_Qrcode extends CommonDBRelation
{
   use PluginFormcreatorExportableTrait;

   // From CommonDBRelation
   static public $itemtype_1 = PluginFormcreatorForm::class;
   static public $items_id_1 = 'plugin_formcreator_forms_id';

   static public $itemtype_2 = 'itemtype';
   static public $items_id_2 = 'items_id';
   static public $checkItem_2_Rights = self::HAVE_VIEW_RIGHT_ON_ITEM;

   public static function getTypeName($nb = 0)
   {
      return _n('Greencat', 'Greencat', $nb, 'formcreator');
   }

   public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0)
   {
      /** @var CommonDBTM $item */

      if ($item instanceof PluginFormcreatorForm) {
         return $this->getTypeName();
      }

      return '';
   }

   public static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0)
   {
      switch ($item->getType()) {
         case PluginFormcreatorForm::class:
            $itemformValitator = new self();
            $itemformValitator->showForForm($item);
      }
   }

   public function showForForm(PluginFormcreatorForm $item, $options = [])
   {
      global $DB, $CFG_GLPI;
      echo json_encode($item);

      $json_data = [
         "url" => "verdanadeskapp:///formcreator/{$item->fields['id']}/answer",
      ];

      $generator = new QRCode("verdanadeskapp:///formcreator/{$item->fields['id']}/answer", []);

      ob_start();
      $generator->output_image();
      $image_data = ob_get_clean();
      ob_end_clean();

      $b64_qrcode = base64_encode($image_data);

      $shown_content = "<img width=\"250px\" height=\"250px\" src=\"data:image/png;base64,{$b64_qrcode}\"/>";

      $html = <<<EOD
               <div class="container">
                   <div class="row justify-content-evenly">
                       <div class="col-12">
                           <form method="POST" action="#">
                               <div class="d-flex justify-content-center mt-4">
                                   <h3>QR Code com link do formulário</h3>
                               </div>
                               <div class="d-flex justify-content-center mt-4 mb-4">
                                   {$shown_content};
                              </div>
                               <div class="d-flex justify-content-center mt-4 ">
                                    <p><b>Link: </b><a href="{$json_data['url']}">{$json_data['url']}</a></p><br>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
            EOD;
      echo $html;
   }

}
