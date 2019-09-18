<?php

namespace Drupal\social_json_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Class SocialJsonApiSettings.
 *
 * @package Drupal\social_json_api\Form
 */
class SocialJsonApiSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'social_json_api_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['consumers'] = [
      '#type' => 'details',
      '#title' => $this->t('Consumers'),
      '#description' => $this->t('Consumers can access the API. The main goal is that the developer of a consumer application will create the consumer. That consumer will provide the configuration necessary for that particular application.'),
      '#open' => TRUE,
      '#collapsable' => TRUE,
    ];
    $consumer_storage = \Drupal::entityTypeManager()->getStorage('consumer');
    $cids = \Drupal::entityQuery('consumer')->execute();
    $consumers = $consumer_storage->loadMultiple($cids);

    $items = [];
    $items[] = Link::fromTextAndUrl($this->t('Add new consumer'), Url::fromRoute('entity.consumer.add_form'));
    foreach ($consumers as $consumer) {
      $items[] = $consumer->toLink($consumer->label() . ' (' . $consumer->uuid() . ')', 'edit-form')->toRenderable();
    }

    $form['consumers']['list'] = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#items' => $items,
      '#wrapper_attributes' => ['class' => 'container'],
    ];

    $form['documentation'] = [
      '#type' => 'details',
      '#title' => $this->t('Documentation'),
      '#description' => $this->t('Documentation for the API is available for sitemanagers.'),
      '#open' => TRUE,
      '#collapsable' => FALSE,
    ];
    $documentation_items = [];
    $documentation_items[] = Link::fromTextAndUrl($this->t('Open Social JSON API Documentation'), Url::fromUri('internal:/admin/config/services/openapi/redoc/jsonapi'));
    $documentation_items[] = Link::fromTextAndUrl($this->t('OAuth 2.0 Grants'), Url::fromUri('http://oauth2.thephpleague.com/authorization-server/which-grant/'));
    $form['documentation']['list'] = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#items' => $documentation_items,
      '#wrapper_attributes' => ['class' => 'container'],
    ];
    return $form;
  }

}
