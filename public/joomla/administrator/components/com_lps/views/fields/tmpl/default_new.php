<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// no direct access
defined('_JEXEC') or die; ?>

<form class="uk-form uk-form-stacked" method="post" action="index.php?option=com_lps&amp;view=fields&amp;task=Fields.createNewField" name="createNewField">

    <div class="uk-form-row">
        <label class="uk-form-label" for="">
            <?php echo JText::_('COM_LPS_SELECT_FIELD_TYPE_FIELD_NAME'); ?>
        </label>
        <div class="uk-form-controls">
            <select name="lps-fields-field-type" id="lps-fields-field-type" onchange="toggleNewFieldTypes(this.value)" class="uk-form-large uk-width-1-1">
                <option value=""><?php echo JText::_('COM_LPS_SELECT'); ?></option>
                <?php
                    if (count($this->field_types) > 0) {
                        foreach ($this->field_types as $type) {
                            echo '<option value="'.$type->id.'">'.LpsHelper::translateFormTypes($type->name).'</option>';
                        }
                    }
                ?>
            </select>
            <div id="lps-fields-field-type-validation-msg" style="display:none;color:#D85030;"></div>
        </div>
    </div>

    <div style="height:15px;"></div>

    <?php
        if (count($this->field_types) > 0) {
            foreach ($this->field_types as $type) {
                $cleanedName = str_replace('_','',$type->name);
                echo '<div id="lps-fields-new-field-'.$cleanedName.'-type-area" style="display:none;">'.$this->loadTemplate($cleanedName).'</div>';
            }
        }
    ?>

    <div style="height:15px;"></div>

    <input type="hidden" name="lps-fields-field-object" id="lps-fields-field-object" value="{}">
</form>




