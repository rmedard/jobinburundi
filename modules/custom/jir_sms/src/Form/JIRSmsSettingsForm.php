<?php

/**
 * Created by PhpStorm.
 * User: medard
 * Date: 13/03/2017
 * Time: 00:02
 */

namespace Drupal\jir_sms\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class JIRSmsSettingsForm extends ConfigFormBase{

    /**
     * Gets the configuration names that will be editable.
     *
     * @return array
     *   An array of configuration object names that are editable if called in
     *   conjunction with the trait's config() method.
     */
    protected function getEditableConfigNames()
    {
        return ['jir_sms.dailysms'];
    }

    /**
     * Returns a unique string identifying the form.
     *
     * @return string
     *   The unique string identifying the form.
     */
    public function getFormId()
    {
        return 'jir_sms_settings_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state){
        $form['number_of_jobs'] = array(
            '#type' => 'number',
            '#title' => $this->t('Number of jobs'),
            '#default_value' => $this->config('jir_sms.dailysms')->get('nbr')
        );
        return parent::buildForm($form, $form_state);
    }

    public function validateForm(array &$form, FormStateInterface $form_state){
        if($form_state->isValueEmpty('number_of_jobs')){
            $form_state->setErrorByName('number_of_jobs', t('Number of jobs cannot be empty nor 0'));
        }else{
            if($form_state->getValue('number_of_jobs') > 5){
                $form_state->setErrorByName('number_of_jobs', t('Number of jobs must be between 1 and 5'));
            }
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        parent::submitForm($form, $form_state);
        $this->config('jir_sms.dailysms')->set('nbr', $form_state->getValue('number_of_jobs'));
    }
}