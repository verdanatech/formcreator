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
 * @copyright Copyright © 2011 - 2021 Teclib'
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @link      https://github.com/pluginsGLPI/formcreator/
 * @link      https://pluginsglpi.github.io/formcreator/
 * @link      http://plugins.glpi-project.org/#/plugin/formcreator
 * ---------------------------------------------------------------------
 */

namespace GlpiPlugin\Formcreator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Change;
use Change_Item;
use PluginFormcreatorFormAnswer;
use Glpi\Toolbox\Sanitizer;

class CleanChangesCommand extends Command
{
   protected function configure() {
      $this
         ->setName('plugins:formcreator:clean_changes')
         ->setDescription("Clean Changes having visible HTML tags in their content");
   }

   protected function execute(InputInterface $input, OutputInterface $output) {
      $output->write("<info>-> Search changes to clean...</info>");
      $output->writeln("");

      $this->fixBadForm_1($input, $output);
      $this->fixBadForm_2($input, $output);
      $this->fixBadForm_3($input, $output);

      $output->writeln('<info>Done.</info>');
      return 0;
   }

   /**
    * fix HTML tags double encoded
    * <p> => &lt;p&gt; => &#38;lt;p&#38;gt;
    *
    * @param InputInterface $input
    * @param OutputInterface $output
    * @return void
    */
   protected function fixBadForm_1(InputInterface $input, OutputInterface $output) {
      global $DB;

      // Search changes having HTML tags in content in the following form
      // &#38;lt;p&#38;gt;Hello world&#38;lt;/p&#38;gt;
      // Hello world is between <p> and </p>, but with wrong escaping
      $itemChangeTable = Change_Item::getTable();
      $changeTable = Change::getTable();
      $pattern = '&#38;lt;';
      // $pattern = str_replace(';', '\\;', $pattern);
      $changes = $DB->request([
         'SELECT' => [$changeTable => [Change::getIndexName(), 'content']],
         'FROM' => $changeTable,
         'INNER JOIN' => [
            $itemChangeTable => [
               'FKEY' => [
                  $changeTable => Change::getIndexName(),
                  $itemChangeTable => Change::getForeignKeyField(),
               ],
               'AND' => [
                  "$itemChangeTable.itemtype" => PluginFormcreatorFormAnswer::getType(),
               ]
            ],
         ],
         'WHERE' => [
            "$changeTable.content" => ['LIKE', '%' . $pattern . '%'], // Matches bad encoding for '<'
         ],
      ]);

      $count = $changes->count();
     
      if ($count < 1) {
         $output->writeln('<info>-> No change to fix.</info>');
         $output->writeln("");
         return 0;
      }

      $output->write("<info>-> Found $count changes to clean (double encoded < and > signs)</info>");
      $output->writeln("");
      $output->write("<info>-> Cleaning changes...</info>");
      $output->writeln("");
      foreach ($changes as $row) {
         $pattern = [
            '/&#38;lt;([a-z0-9]+?)&#38;gt;/',
            '/&#38;lt;(\/[a-z0-9]+?)&#38;gt;/',
         ];
         $replace = [
            '&#60;$1&#62;',
            '&#60;$1&#62;',
         ];
         $row['content'] = preg_replace($pattern, $replace, $row['content']);
         // Direct write to the table to avoid alteration of other fields
         $DB->update(
            $changeTable,
            [
               'content' => $DB->escape($row['content'])
            ],
            [
               'id' => $row['id'],
            ]
         );
      }
   }

   /**
    * replace litteral HTML tag <br /> with &lt;br /&gt;
    *
    * @param InputInterface $input
    * @param OutputInterface $output
    * @return void
    */
   protected function fixBadForm_2(InputInterface $input, OutputInterface $output) {
      global $DB;

      // Search changes having HTML tags <br />
      $itemChangeTable = Change_Item::getTable();
      $changeTable = Change::getTable();
      $pattern = '<br />';
      $changes = $DB->request([
         'SELECT' => [$changeTable => [Change::getIndexName(), 'content']],
         'FROM' => $changeTable,
         'INNER JOIN' => [
            $itemChangeTable => [
               'FKEY' => [
                  $changeTable => Change::getIndexName(),
                  $itemChangeTable => Change::getForeignKeyField(),
               ],
               'AND' => [
                  "$itemChangeTable.itemtype" => PluginFormcreatorFormAnswer::getType(),
               ]
            ],
         ],
         'WHERE' => [
            "$changeTable.content" => ['LIKE', '%' . $pattern . '%'], // Matches bad encoding for 'br /'
         ],
      ]);

      $count = $changes->count();
      if ($count < 1) {
         $output->writeln('<info>-> No change to fix.</info>');
         $output->writeln("");
         return 0;
      }

      $output->write("<info>-> Found $count changes to clean (literal BR tag)</info>");
      $output->writeln("");
      $output->write("<info>-> Cleaning changes...</info>");
      $output->writeln("");
      foreach ($changes as $row) {
         $pattern = [
            '<br />',
         ];
         // Determine if we must use legacy or new encoding
         // @see Sanitizer::sanitize()
         $replace = null;
         if (strpos($row['content'], '&lt;') !== false && strpos($row['content'], '#60;') === false) {
            $replace = [
               '&lt;br /&gt;',
            ];
         } else if (strpos($row['content'], '#60') !== false && strpos($row['content'], '&lt;') === false) {
            $replace = [
               '&#60;br /&#62;',
            ];
         }
         if ($replace === null) {
            $output->write("<error>-> Unable to determine the encoding type of change ID: " . $row['id']. "</error>");
            continue;
         }
         $row['content'] = str_replace($pattern, $replace, $row['content']);
         // Direct write to the table to avoid alteration of other fields
         $DB->update(
            $changeTable,
            [
               'content' => $DB->escape($row['content'])
            ],
            [
               'id' => $row['id'],
            ]
         );
      }
   }

   /**
    * replace litteral HTML tag > with #38;
    * This may happen when a question gives the path to an item of a CommonTreeObject
    * entities, locations, ...
    *
    * @param InputInterface $input
    * @param OutputInterface $output
    * @return void
    */
   protected function fixBadForm_3(InputInterface $input, OutputInterface $output) {
      global $DB;

      // Search changes having HTML tags <br />
      $itemChangeTable = Change_Item::getTable();
      $changeTable = Change::getTable();
      $pattern = ' > '; // greater than sign with a space before and after
      $changes = $DB->request([
         'SELECT' => [$changeTable => [Change::getIndexName(), 'content']],
         'FROM' => $changeTable,
         'INNER JOIN' => [
            $itemChangeTable => [
               'FKEY' => [
                  $changeTable => Change::getIndexName(),
                  $itemChangeTable => Change::getForeignKeyField(),
               ],
               'AND' => [
                  "$itemChangeTable.itemtype" => PluginFormcreatorFormAnswer::getType(),
               ]
            ],
         ],
         'WHERE' => [
            "$changeTable.content" => ['LIKE', '%' . $pattern . '%'],
         ],
      ]);

      $count = $changes->count();
      if ($count < 1) {
         $output->writeln('<info>-> No change to fix.</info>');
         $output->writeln("");
         return 0;
      }

      $output->write("<info>-> Found $count changes to clean (litteral > sign)</info>");
      $output->writeln("");
      $output->write("<info>-> Cleaning changes...</info>");
      $output->writeln("");
      foreach ($changes as $row) {
         $pattern = [
            ' > ',
         ];
         // Determine if we must use legacy or new encoding
         // @see Sanitizer::sanitize()
         $replace = null;
         if (strpos($row['content'], '&lt;') !== false && strpos($row['content'], '#60;') === false) {
            $replace = [
               ' &gt; ',
            ];
         } else if (strpos($row['content'], '#60') !== false && strpos($row['content'], '&lt;') === false) {
            $replace = [
               ' &#38; ',
            ];
         }
         if ($replace === null) {
            $output->write("<error>-> Unable to determine the encoding type of change ID: " . $row['id']. "</error>");
            continue;
         }
         $row['content'] = str_replace($pattern, $replace, $row['content']);
         // Direct write to the table to avoid alteration of other fields
         $DB->update(
            $changeTable,
            [
               'content' => $DB->escape($row['content'])
            ],
            [
               'id' => $row['id'],
            ]
         );
      }
   }
}
