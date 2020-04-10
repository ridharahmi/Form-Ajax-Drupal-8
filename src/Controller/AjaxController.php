<?php

namespace Drupal\form_api_ajax\Controller;

use Drupal\Core\Controller\ControllerBase;

class AjaxController extends ControllerBase {

    /**
     * Display MaPage.
     *
     * @return array
     */
    public function content() {
        $myForm =  \Drupal::formBuilder()->getForm('Drupal\form_api_ajax\Form\AjaxForm');
        return [
            '#theme' => 'ajax_page',
            '#my_form' => $myForm,
        ];
    }

}