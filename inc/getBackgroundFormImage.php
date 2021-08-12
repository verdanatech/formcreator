<?php
require_once('../../../inc/includes.php');

function hasSkinsInstalled()
{
    $plugin = new Plugin();

    return $plugin->isInstalled('skins') && $plugin->isActivated('skins');
}

function getConfigImg($name)
{
    global $DB;

    $documents_id = array();
    $query = "SELECT * FROM `glpi_plugin_skins_configs_img` WHERE `name` = '{$name}'";
    $result = $DB->query($query);
    if ($result) {
        $row_result = $DB->fetchAssoc($result);
        $documents_id = $row_result['documents_id'];

        $Document = new Document();
        $find_document = current($Document->find(["id = {$documents_id}"]));

        return ($find_document['filepath']);
    } else {
        $documents_id = false;
    }
    return $documents_id;
}

//função para pegar a imgem do banco de dados
function getImageBase64Data($documents_id)
{
    $image = GLPI_DOC_DIR . "/$documents_id";

    // Read image path, convert to base64 encoding
    $imageData = base64_encode(file_get_contents($image));

    // Format the image SRC:  data:{mime};base64,{data};
    return 'data: ' . mime_content_type($image) . ';base64,' . $imageData;
}


if (hasSkinsInstalled()) {

    $documents_id = getConfigImg('background');
    if (empty($documents_id)) {
        $src_background = $CFG_GLPI["root_doc"] . "/plugins/skins/pics/background.png";
    } else {
        $src_background = getImageBase64Data($documents_id);
    }
}

?>
div#bloc::before {
background-image: url("<?php echo $src_background ?>");
}