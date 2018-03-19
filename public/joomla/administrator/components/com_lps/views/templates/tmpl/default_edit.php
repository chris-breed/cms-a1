<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// no direct access
defined('_JEXEC') or die; 

//require html formatter helper file
require_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/htmLawed.php'; ?>

<script type="text/javascript">window.lpsJuriRoot = '<?php echo JURI::root(); ?>';</script>

<script src="components/com_lps/assets/js/onecolumn_layout.js"></script>
<script src="components/com_lps/assets/js/leftsidebar_layout.js"></script>
<script src="components/com_lps/assets/js/rightsidebar_layout.js"></script>
<script src="components/com_lps/assets/js/twocolumn_layout.js"></script>
<script src="components/com_lps/assets/js/threecolumn_layout.js"></script>
<script src="components/com_lps/assets/js/threecolumnrepeat_layout.js"></script>

<!--load the editor via plugin-->
<?php
    JPluginHelper::importPlugin('joomlasales');
    $dispatcher = JEventDispatcher::getInstance();
    $dispatcher->trigger('JoomlaSales_LoadHtmlEditorResources',array());
?>


<!-- HTML editor CSS and JavaScript -->
<link rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_lps/assets/libraries/uikit/css/components/htmleditor.css">
<script src="<?php echo JURI::root(); ?>components/com_lps/assets/libraries/uikit/js/components/htmleditor.js"></script>

<script type="text/javascript">
    jQuery(function($){
        $( document ).ready(function() {
            UIkit.htmleditor($( "#lp-templates-selected-layout-editing" ), { mode:'split' });
        });
    });
    selectedLayout = '<?php echo $this->item->layout; ?>';
</script>

<div class="lps-body">

        <div id="j-sidebar-container" class="span2">
            <?php //echo $this->sidebar; ?>

            <div class="uk-panel uk-panel-box">

                <!--<h3 class="uk-panel-title">Nav side in panel</h3>-->

                <ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav="">
                    <li><a href="index.php?option=com_lps&amp;view=landingpages"><?php echo JText::_( 'COM_LPS_LANDING_PAGES_TITLE' ); ?></a></li>
                    <li class="uk-active"><a href="index.php?option=com_lps&amp;view=templates"><?php echo JText::_( 'COM_LPS_TEMPLATES_TITLE' ); ?></a></li>
                    <li><a href="index.php?option=com_lps&amp;view=forms"><?php echo JText::_( 'COM_LPS_FORMS_TITLE' ); ?></a></li>
                    <li><a href="index.php?option=com_lps&amp;view=fields"><?php echo JText::_( 'COM_LPS_FIELDS_TITLE' ); ?></a></li>
                    <li><a href="index.php?option=com_lps&amp;view=submissions"><?php echo JText::_( 'COM_LPS_SUBMISSIONS_TITLE' ); ?></a></li>
                    <li><a href="index.php?option=com_lps&amp;view=leads"><?php echo JText::_( 'COM_LPS_LEADS_TITLE' ); ?></a></li>
                </ul>

            </div>

        </div>

        <div id="j-main-container" class="span10">

            <form class="uk-form uk-form-stacked" method="post" action="index.php?option=com_lps&amp;view=templates&amp;task=Templates.editTemplate" name="editTemplateForm">

                <h2><?php echo JText::_('COM_LPS_BASIC_FORM_HEADING'); ?></h2>

                <div class="uk-form-row">
                    <label class="uk-form-label" for="">
                        <?php echo JText::_( 'COM_LPS_NAME_FIELD_NAME' ); ?>
                    </label>
                    <div class="uk-form-controls">
                        <input name="lps-templates-name" id="lps-templates-name" size="40" maxlength="255" value="<?php echo $this->item->name; ?>" type="text" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_NAME_FIELD_TOOLTIP' ); ?>">
                        <div id="lps-templates-name-validation-msg" style="display:none;color:#D85030;"></div>
                    </div>
                </div>

                <div style="height:15px;"></div>

                <div class="uk-form-controls">
                    <?php if ($this->item->published == 1) { ?>
                                <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?></span> <i id="lps-templates-published" onclick="toggleIcon(0,'published','lps-templates-published')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
                    <?php } else { ?>
                                <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_( 'COM_LPS_PUBLISHED_FIELD_NAME' ); ?></span> <i id="lps-templates-published" onclick="toggleIcon(1,'published','lps-templates-published')" class="uk-icon-toggle-off" style="cursor:pointer;font-size:30px;color:rgba(216, 80, 48, 1);'"></i>
                    <?php } ?>
                </div>  

                <div style="height:15px;"></div>

                <div class="uk-form-row">
                    <label class="uk-form-label" for="">
                        <?php echo JText::_( 'COM_LPS_DESCRIPTION_FIELD_NAME' ); ?>
                    </label>
                    <div class="uk-form-controls">
                        <textarea type="text" name="lps-templates-description" id="lps-templates-description" cols="28" rows="4" data-uk-tooltip title="<?php echo JText::_( 'COM_LPS_DESCRIPTION_FIELD_TOOLTIP' ); ?>"><?php echo $this->item->description; ?></textarea>
                    </div>
                </div>

                <div style="height:15px;"></div>

                <input type="hidden" name="lps-templates-published" id="lps-templates-published-value" value="1">

                <h2><?php echo JText::_('COM_LPS_LAYOUT_FORM_HEADING'); ?></h2>
                <div id="lp-templates-layout-selection-area" style="display:none;">
                    <ul class="uk-tab" data-uk-tab>
                        <li id="lp-templates-basic-tab" onclick="showBasicLayoutTab()" class="uk-active"><a href="javascript:void(0);"><?php echo JText::_('COM_LPS_TEMPLATES_BASIC_LAYOUTS'); ?></a></li>
                        <li id="lp-templates-grid-tab" onclick="showGridLayoutTab()"><a href="javascript:void(0);"><?php echo JText::_('COM_LPS_TEMPLATES_GRID_LAYOUTS'); ?></a></li>
                    </ul>
                    <div id="lps-templates-layout-basic">

                        <div class="uk-clearfix uk-margin-top">
                             <div class="uk-float-left uk-margin-right">
                                <div class="uk-panel">
                                    <div class="uk-text-center uk-margin-bottom"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_CODE_YOUR_OWN'); ?></div>

                                    <div class="uk-thumbnail uk-overlay-toggle uk-scrollspy-init-inview uk-scrollspy-inview uk-animation-fade" data-uk-scrollspy="{cls:'uk-animation-fade', delay:50}">
                                      <a class="uk-overlay" href="javascript:void(0);" onclick="selectLayout('codeyourown')">
                                        <img src="components/com_lps/assets/images/layouts/codeyourown_layout.png" style="max-height:200px;">
                                        <div class="uk-overlay-area">
                                          <div class="uk-overlay-area-content" style="color:#31373A;">
                                            <h2 class="uk-h5 tm-overlay-title"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_USE_LAYOUT'); ?></h2>
                                            <div><?php echo JText::_('COM_LPS_CLICK_HERE'); ?></div>
                                          </div>
                                        </div>
                                      </a>
                                    </div>

                                </div>
                            </div>                       
                            <div class="uk-float-left uk-margin-right">
                                <div class="uk-panel">
                                    <div class="uk-text-center uk-margin-bottom"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_ONE_COLUMN'); ?></div>

                                    <div class="uk-thumbnail uk-overlay-toggle uk-scrollspy-init-inview uk-scrollspy-inview uk-animation-fade" data-uk-scrollspy="{cls:'uk-animation-fade', delay:50}">
                                      <a class="uk-overlay" href="javascript:void(0);" onclick="selectLayout('onecolumn')">
                                        <img src="components/com_lps/assets/images/layouts/1column_layout.png" style="max-height:200px;">
                                        <div class="uk-overlay-area">
                                          <div class="uk-overlay-area-content" style="color:#31373A;">
                                            <h2 class="uk-h5 tm-overlay-title"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_USE_LAYOUT'); ?></h2>
                                            <div><?php echo JText::_('COM_LPS_CLICK_HERE'); ?></div>
                                          </div>
                                        </div>
                                      </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                            
                    </div>
                    <div id="lps-templates-layout-grid" style="display:none;">

                        <div class="uk-clearfix uk-margin-top">
                            <div class="uk-float-left uk-margin-right">
                                <div class="uk-panel">
                                    <div class="uk-text-center uk-margin-bottom"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_LEFT_SIDEBAR'); ?></div>
                                    
                                    <div class="uk-thumbnail uk-overlay-toggle uk-scrollspy-init-inview uk-scrollspy-inview uk-animation-fade" data-uk-scrollspy="{cls:'uk-animation-fade', delay:50}">
                                      <a class="uk-overlay" href="javascript:void(0);" onclick="selectLayout('leftsidebar')">
                                        <img src="components/com_lps/assets/images/layouts/leftsidebar_layout.png" style="max-height:200px;">
                                        <div class="uk-overlay-area">
                                          <div class="uk-overlay-area-content" style="color:#31373A;">
                                            <h2 class="uk-h5 tm-overlay-title"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_USE_LAYOUT'); ?></h2>
                                            <div><?php echo JText::_('COM_LPS_CLICK_HERE'); ?></div>
                                          </div>
                                        </div>
                                      </a>
                                    </div>

                                </div>
                            </div>
                            <div class="uk-float-left uk-margin-right">
                                <div class="uk-panel">
                                    <div class="uk-text-center uk-margin-bottom"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_RIGHT_SIDEBAR'); ?></div>
                                    
                                    <div class="uk-thumbnail uk-overlay-toggle uk-scrollspy-init-inview uk-scrollspy-inview uk-animation-fade" data-uk-scrollspy="{cls:'uk-animation-fade', delay:50}">
                                      <a class="uk-overlay" href="javascript:void(0);" onclick="selectLayout('rightsidebar')">
                                        <img src="components/com_lps/assets/images/layouts/rightsidebar_layout.png" style="max-height:200px;">
                                        <div class="uk-overlay-area">
                                          <div class="uk-overlay-area-content" style="color:#31373A;">
                                            <h2 class="uk-h5 tm-overlay-title"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_USE_LAYOUT'); ?></h2>
                                            <div><?php echo JText::_('COM_LPS_CLICK_HERE'); ?></div>
                                          </div>
                                        </div>
                                      </a>
                                    </div>

                                </div>
                            </div>
                            <div class="uk-float-left uk-margin-right">
                                <div class="uk-panel">
                                    <div class="uk-text-center uk-margin-bottom"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_TWO_COLUMN'); ?></div>
                                    
                                    <div class="uk-thumbnail uk-overlay-toggle uk-scrollspy-init-inview uk-scrollspy-inview uk-animation-fade" data-uk-scrollspy="{cls:'uk-animation-fade', delay:50}">
                                      <a class="uk-overlay" href="javascript:void(0);" onclick="selectLayout('twocolumn')">
                                        <img src="components/com_lps/assets/images/layouts/2column_layout.png" style="max-height:200px;">
                                        <div class="uk-overlay-area">
                                          <div class="uk-overlay-area-content" style="color:#31373A;">
                                            <h2 class="uk-h5 tm-overlay-title"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_USE_LAYOUT'); ?></h2>
                                            <div><?php echo JText::_('COM_LPS_CLICK_HERE'); ?></div>
                                          </div>
                                        </div>
                                      </a>
                                    </div>

                                </div>
                            </div>
                            <div class="uk-float-left uk-margin-right">
                                <div class="uk-panel">
                                    <div class="uk-text-center uk-margin-bottom"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_THREE_COLUMN'); ?></div>
                                    
                                    <div class="uk-thumbnail uk-overlay-toggle uk-scrollspy-init-inview uk-scrollspy-inview uk-animation-fade" data-uk-scrollspy="{cls:'uk-animation-fade', delay:50}">
                                      <a class="uk-overlay" href="javascript:void(0);" onclick="selectLayout('threecolumn')">
                                        <img src="components/com_lps/assets/images/layouts/3column_layout.png" style="max-height:200px;">
                                        <div class="uk-overlay-area">
                                          <div class="uk-overlay-area-content" style="color:#31373A;">
                                            <h2 class="uk-h5 tm-overlay-title"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_USE_LAYOUT'); ?></h2>
                                            <div><?php echo JText::_('COM_LPS_CLICK_HERE'); ?></div>
                                          </div>
                                        </div>
                                      </a>
                                    </div>

                                </div>
                            </div>
                            <div class="uk-float-left">
                                <div class="uk-panel">
                                    <div class="uk-text-center uk-margin-bottom"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_THREE_COLUMN_REPEAT'); ?></div>
                                    
                                    <div class="uk-thumbnail uk-overlay-toggle uk-scrollspy-init-inview uk-scrollspy-inview uk-animation-fade" data-uk-scrollspy="{cls:'uk-animation-fade', delay:50}">
                                      <a class="uk-overlay" href="javascript:void(0);" onclick="selectLayout('threecolumnrepeat')">
                                        <img src="components/com_lps/assets/images/layouts/3columnrepeat_layout.png" style="max-height:200px;">
                                        <div class="uk-overlay-area">
                                          <div class="uk-overlay-area-content" style="color:#31373A;">
                                            <h2 class="uk-h5 tm-overlay-title"><?php echo JText::_('COM_LPS_TEMPLATES_LAYOUTS_USE_LAYOUT'); ?></h2>
                                            <div><?php echo JText::_('COM_LPS_CLICK_HERE'); ?></div>
                                          </div>
                                        </div>
                                      </a>
                                    </div>

                                </div>
                            </div>                                            
                        </div>
                    </div>
                </div>
                <div id="lp-templates-selected-layout-area" style="display:none;">
                    <div class="uk-panel uk-panel-box uk-panel-box-primary uk-clearfix">
                        <h3 class="uk-panel-title"><?php echo JText::_('COM_LPS_TEMPLATES_SELECTED_LAYOUT'); ?></h3>
                        <div class="uk-float-left">
                            <img id="lp-templates-layout-selected-img" style="max-height:200px;">
                        </div>
                        <div class="uk-float-left uk-margin-left">
                            <h4 id="lp-templates-layout-selected-name"></h4>
                            <p id="lp-templates-layout-selected-desc"></p>
                            <a href="javascript:void(0);" class="uk-button uk-button-success uk-margin-large-top" onclick="initializeEditLayout()"><?php echo JText::_('COM_LPS_TEMPLATES_START_EDITING'); ?></a>
                            <a href="javascript:void(0);" class="uk-button uk-button-danger uk-margin-large-top" onclick="removeLayout()"><?php echo JText::_('COM_LPS_TEMPLATES_REMOVE'); ?></a>
                        </div>
                    </div>
                </div>
                <div id="lp-templates-mini-selected-layout-area">
                    <div class="uk-panel uk-panel-box uk-panel-box-primary uk-clearfix">
                        <div class="uk-float-right">
                            <a href="javascript:void(0);" onclick="editTemplate()" class="uk-button uk-button-success" style="position:relative;top:10px;"><?php echo JText::_('COM_LPS_TEMPLATES_SAVE_TEMPLATE'); ?></a>
                            <a href="javascript:void(0);" onclick="returnToSelectedLayout()" class="uk-button uk-button-danger" style="position:relative;top:10px;"><?php echo JText::_('COM_LPS_TEMPLATES_REMOVE'); ?></a>
                        </div>
                        <div class="uk-float-left">
                            <?php //echo $this->item->layout; ?>
                            <?php $layout = LpsHelper::getTemplateLayoutContent($this->item->layout); ?>
                            <div class="uk-float-left">
                                <img src="<?php echo $layout->src; ?>" id="lp-templates-layout-mini-selected-img" style="max-height:50px;">
                            </div>
                            <div class="uk-float-left uk-margin-left">
                                <h4 id="lp-templates-layout-mini-selected-name"><?php echo $layout->name; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="lp-templates-selected-layout-editing-area">
                    <textarea name="lp-templates-selected-layout-editing" id="lp-templates-selected-layout-editing"><?php echo htmlspecialchars(htmLawed($this->item->content, array('tidy'=>4)) ); ?></textarea></textarea>
                </div>

                <div style="height:25px;"></div>

                <h2><?php echo JText::_('COM_LPS_FORM_STYLING_FORM_HEADING'); ?></h2>

                <div class="uk-form-controls">
                    <?php if ($this->item->show_form_title == 1) { ?>
                                <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_('COM_LPS_SHOW_FORM_TITLE_FIELD_NAME'); ?></span> <i id="lps-landing-pages-show-form-title" onclick="toggleIcon(0,'showFormTitle','lps-landing-pages-show-form-title')" class="uk-icon-toggle-on" style="cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);"></i>
                    <?php } else { ?>
                                <span style="position:relative;bottom:5px;font-weight:bold;"><?php echo JText::_('COM_LPS_SHOW_FORM_TITLE_FIELD_NAME'); ?></span> <i id="lps-landing-pages-show-form-title" onclick="toggleIcon(1,'showFormTitle','lps-landing-pages-show-form-title')" class="uk-icon-toggle-off" style="cursor:pointer;font-size:30px;color:rgba(216, 80, 48, 1);'"></i>
                    <?php } ?>
                </div>

                <div style="height:15px;"></div>

                <div class="uk-form-row">
                    <label class="uk-form-label" for="">
                        <?php echo JText::_('COM_LPS_FORM_CONTAINER_FIELD_NAME'); ?>
                    </label>
                    <div class="uk-form-controls">
                        <?php $formContainerOptions = array('COM_LPS_TEMPLATES_DEFAULT_OPTION'=>'default',
                                                            'COM_LPS_TEMPLATES_BOX_OPTION'=>'box',
                                                            'COM_LPS_TEMPLATES_BOX_PRIMARY_OPTION'=>'box primary'); ?>

                        <select name="lps-templates-form-container" id="lps-templates-form-container">
                            <?php
                                foreach ($formContainerOptions as $key => $value) {
                                    if ($this->item->form_container == $value) {
                                        echo '<option selected="selected" value="'.$value.'">'.JText::_($key).'</option>';
                                    } else {
                                        echo '<option value="'.$value.'">'.JText::_($key).'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div style="height:15px;"></div>

                <div class="uk-form-row">
                    <label class="uk-form-label" for="">
                        <?php echo JText::_('COM_LPS_FIELD_WIDTH_FIELD_NAME'); ?>
                    </label>
                    <div class="uk-form-controls">
                        <?php $formFieldWidthOptions = array('COM_LPS_TEMPLATES_DEFAULT_OPTION'=>'default',
                                                             '25%'=>'25',
                                                             '33%'=>'33',
                                                             '50%'=>'50',
                                                             '100%'=>'100'); ?>
                        <select name="lps-templates-form-field-width" id="lps-templates-form-field-width">
                            <?php
                                foreach ($formFieldWidthOptions as $key => $value) {
                                    $textNode = ($value == 'default') ? JText::_($key) : $key ;
                                    if ($this->item->field_width == $value) {
                                        echo '<option selected="selected" value="'.$value.'">'.$textNode .'</option>';
                                    } else {
                                        echo '<option value="'.$value.'">'.$textNode .'</option>';
                                    }
                                }
                            ?>                            
                        </select>
                    </div>
                </div>

                <div style="height:15px;"></div>

                <div class="uk-form-row">
                    <label class="uk-form-label" for="">
                        <?php echo JText::_('COM_LPS_FIELD_SIZE_FIELD_NAME'); ?>
                    </label>
                    <div class="uk-form-controls">
                        <?php $formFieldSizeOptions = array('COM_LPS_TEMPLATES_DEFAULT_OPTION'=>'default',
                                                            'COM_LPS_TEMPLATES_SMALL_OPTION' => 'small',
                                                            'COM_LPS_TEMPLATES_LARGE_OPTION' => 'large'); ?>
                        <select name="lps-templates-form-field-size" id="lps-templates-form-field-size">
                            <?php
                                foreach ($formFieldSizeOptions as $key => $value) {
                                    if ($this->item->field_size == $value) {
                                        echo '<option selected="selected" value="'.$value.'">'.JText::_($key).'</option>';
                                    } else {
                                        echo '<option value="'.$value.'">'.JText::_($key).'</option>';
                                    }
                                }
                            ?>     
                        </select>
                    </div>
                </div>

                <div style="height:15px;"></div>

                <div class="uk-form-row">
                    <label class="uk-form-label" for="">
                        <?php echo JText::_('COM_LPS_FIELD_LABELING_FIELD_NAME'); ?>
                    </label>
                    <div class="uk-form-controls">
                        <?php $formFieldLabelingOptions = array('COM_LPS_TEMPLATES_LABEL_OPTION' => 'label',
                                                                'COM_LPS_TEMPLATES_PLACEHOLDER_OPTION' => 'placeholder'); ?>
                        <select name="lps-templates-form-field-labeling" id="lps-templates-form-field-labeling">
                            <?php
                                foreach ($formFieldLabelingOptions as $key => $value) {
                                    if ($this->item->field_labeling == $value) {
                                        echo '<option selected="selected" value="'.$value.'">'.JText::_($key).'</option>';
                                    } else {
                                        echo '<option value="'.$value.'">'.JText::_($key).'</option>';
                                    }
                                }
                            ?>     
                        </select>
                    </div>
                </div>

                <input type="hidden" name="lps-templates-form-show-title" id="lps-templates-form-show-title-value" value="1">
                <input type="hidden" name="lps-templates-published-value" id="lps-templates-published-value">
                <input type="hidden" name="lps-templates-edit-item-id" id="lps-templates-edit-item-id" value="<?php echo $this->item->id; ?>">
                <input type="hidden" name="lps-templates-layout" id="lps-templates-layout" value="<?php echo $this->item->layout; ?>">
            </form>            

        </div>
</div>


















