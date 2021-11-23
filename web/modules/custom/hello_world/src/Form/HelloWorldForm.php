<?php

namespace Drupal\hello_world\Form;

use \Drupal\Core\Form\ConfigFormBase;
use \Drupal\Core\Form\FormStateInterface;

class HelloWorldForm extends ConfigFormBase {


  protected function getEditableConfigNames() {
    return ['hello_world.settings'];
    // TODO: Implement getEditableConfigNames() method.
  }

  public function getFormId() {
    return 'hello_world_id';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Example phone'),
    ];
    $form['some_text'] =[
      '#type' => 'textfield',
      '#title' => $this->t('some random text'),
    ];
    $form['some_number'] = [
      '#type' => 'number',
      '#title' => $this->t('some number'),
    ];


//    $form['submit'] = [
//      '#type' => 'submit',
//      '#value' => $this->t('Submit'),
//    ];
    $form = parent::buildForm($form, $form_state);

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('hello_world.settings')
      ->set('phone', $form_state->getValue('phone_number'))
      ->set('next', $form_state->getValue('some_text'))
      ->set('numero', $form_state->getValue('some_number'))
      ->save();

    parent::submitForm($form, $form_state);
  }
//    $this->messenger()->addStatus($this->t('Your phone number is @number', ['@number' => $form_state->getValue('phone_number')]));



}
