<?php

/**
 * This software is intended for use with Oxwall Free Community Software http://www.oxwall.org/ and is a proprietary licensed product. 
 * For more information see License.txt in the plugin folder.

 * ---
 * Copyright (c) 2012, Purusothaman Ramanujam
 * All rights reserved.

 * Redistribution and use in source and binary forms, with or without modification, are not permitted provided.

 * This plugin should be bought from the developer by paying money to PayPal account (purushoth.r@gmail.com).

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

class SNOWFALL_CTRL_Admin extends ADMIN_CTRL_Abstract
{

    public function __construct()
    {
        parent::__construct();

        if ( OW::getRequest()->isAjax() )
        {
            return;
        }

        $lang = OW::getLanguage();

        $this->setPageHeading($lang->text('snowfall', 'admin_settings_title'));
        $this->setPageTitle($lang->text('snowfall', 'admin_settings_title'));
        $this->setPageHeadingIconClass('ow_ic_gear_wheel');
    }

    public function settings()
    {
        $adminForm = new Form('adminForm');      

        $language = OW::getLanguage();
        $config = OW::getConfig();

        $element = new TextField('minSize');
        $element->setRequired(true);
        $validator = new IntValidator(1);
        $validator->setErrorMessage($language->text('snowfall', 'admin_invalid_number_error'));
        $element->addValidator($validator);
        $element->setLabel($language->text('snowfall', 'admin_min_size')); 
        $element->setValue($config->getValue('snowfall', 'minSize'));
        $adminForm->addElement($element);

        $element = new TextField('maxSize');
        $element->setLabel($language->text('snowfall', 'admin_max_size'));
        $element->setValue($config->getValue('snowfall', 'maxSize'));
        $element->addValidator($validator);        
        $element->setRequired(true);        
        $adminForm->addElement($element);

        $element = new TextField('newOn');
        $element->setLabel($language->text('snowfall', 'admin_new_flake_time'));
        $element->setRequired(true);        
        $element->setValue($config->getValue('snowfall', 'newOn'));
        $element->addValidator($validator);         
        $adminForm->addElement($element);
        
        $element = new TextField('flakeColor');
        $element->setLabel($language->text('snowfall', 'admin_new_flake_color'));
        $element->setRequired(true);          
        $element->setValue($config->getValue('snowfall', 'flakeColor'));
        $adminForm->addElement($element);

        $element = new Submit('saveSettings');
        $element->setValue($language->text('snowfall', 'admin_save_settings'));
        $adminForm->addElement($element);

        if ( OW::getRequest()->isPost() )
        {
           if ( $adminForm->isValid($_POST) )
           {
              $values = $adminForm->getValues(); 
              $config = OW::getConfig();
              $config->saveConfig('snowfall', 'minSize', $values['minSize']);
              $config->saveConfig('snowfall', 'maxSize', $values['maxSize']);
              $config->saveConfig('snowfall', 'newOn', $values['newOn']);
              $config->saveConfig('snowfall', 'flakeColor', $values['flakeColor']);

              OW::getFeedback()->info($language->text('snowfall', 'user_save_success')); 
           }
        }

       $this->addForm($adminForm);
   } 

}