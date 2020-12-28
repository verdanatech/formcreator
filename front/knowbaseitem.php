<?php

/**
 * ---------------------------------------------------------------------
 * Formcreator is a plugin which allows creation of custom forms of
 * easy access.
 * ---------------------------------------------------------------------
 * LICENSE
 *
 * This file is part of Formcreator.
 *
 * Formcreator is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Formcreator is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Formcreator. If not, see <http://www.gnu.org/licenses/>.
 * ---------------------------------------------------------------------
 * @author    Thierry Bugier
 * @author    Jérémy Moreau
 * @copyright Copyright © 2011 - 2019 Teclib'
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @link      https://github.com/pluginsGLPI/formcreator/
 * @link      https://pluginsglpi.github.io/formcreator/
 * @link      http://plugins.glpi-project.org/#/plugin/formcreator
 * ---------------------------------------------------------------------
 */

include("../../../inc/includes.php");
Html::requireJs('jstree');

// Check if plugin is activated...
$plugin = new Plugin();
if (!$plugin->isActivated('formcreator')) {
    Html::displayNotFoundError();
}

if (!plugin_formcreator_replaceHelpdesk()) {
    Html::redirect($CFG_GLPI["root_doc"] . "/front/helpdesk.public.php");
}

if (KnowbaseItem::canView()) {

    PluginFormcreatorWizard::header(__('Service catalog', 'formcreator'));



    // Clean for search
    $_GET = Toolbox::stripslashes_deep($_GET);

    // Search a solution
    if (
        !isset($_GET["contains"])
        && isset($_GET["item_itemtype"])
        && isset($_GET["item_items_id"])
    ) {

        if ($item = getItemForItemtype($_GET["item_itemtype"])) {
            if ($item->getFromDB($_GET["item_items_id"])) {
                $_GET["contains"] = $item->getField('name');
            }
        }
    }

    // Manage forcetab : non standard system (file name <> class name)
    if (isset($_GET['forcetab'])) {
        Session::setActiveTab('Knowbase', $_GET['forcetab']);
        unset($_GET['forcetab']);
    }

    $kb = new Knowbase();
    $kb->display($_GET);



    PluginFormcreatorWizard::footer();
}
