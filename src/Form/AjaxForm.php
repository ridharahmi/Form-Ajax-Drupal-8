<?php

namespace Drupal\form_api_ajax\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\node\Entity\Node;

/**
 * Class MonFormulaire.
 */
class AjaxForm extends FormBase
{


    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'form_ajax';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = [];
        $form['node_id'] = [
            '#type' => 'number',
            '#title' => $this->t('Node Id'),
            '#id' => 'my-imput'
        ];

        $form['submit'] = [
            '#type' => 'button',
            '#value' => $this->t('Search'),
            '#ajax' => [
                'callback' => '::loadNode',
            ],
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

    }

    /**
     * Notre callback.
     */
    public function loadNode(array &$form, FormStateInterface $form_state)
    {

        $node_id = $form_state->getValue('node_id');
        $node = Node::load($node_id);

        $view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');
        $render_array = $view_builder->view($node, 'full');

        $render_array['#prefix'] = '<div id="div-node">';
        $render_array['#suffix'] = '</div>';

        $response = new AjaxResponse();
        $response->addCommand(new ReplaceCommand('#div-node', $render_array));

        $response->addCommand(new ChangedCommand('#div-node'));

        return $response;
    }


}