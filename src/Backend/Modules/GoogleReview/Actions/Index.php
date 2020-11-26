<?php

namespace Backend\Modules\GoogleReview\Actions;

use Backend\Core\Engine\Base\ActionIndex as BackendBaseActionIndex;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\GoogleReview\Domain\GoogleReview\GoogleReviewDataTransferObject;
use Backend\Modules\GoogleReview\Domain\GoogleReview\GoogleReviewType;
use Symfony\Component\Form\Form;

/**
 * This is the index-action (default), it will display the overview
 */
class Index extends BackendBaseActionIndex
{
    public function execute(): void
    {
        parent::execute();

        $form = $this->getForm();

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->template->assign('form', $form->createView());

            $this->parse();
            $this->display();

            return;
        }

        $data = $form->getData();

        $this->setSetting('place_id', $data->place_id);
        $this->setSetting('api_key', $data->api_key);

        $this->redirect($this->getBackLink());
    }

    private function getBackLink(array $parameters = []): string
    {
        return BackendModel::createUrlForAction(
            'Index',
            null,
            null,
            $parameters
        );
    }

    private function getForm(): Form
    {
        $data = new GoogleReviewDataTransferObject();
        $data->place_id = $this->getSetting('place_id');
        $data->api_key = $this->getSetting('api_key');

        $form = $this->createForm(
            GoogleReviewType::class,
            $data
        );

        $form->handleRequest($this->getRequest());

        return $form;
    }

    public function getSetting($key, $defaultValue = null)
    {
        return $this->get('fork.settings')->get($this->getModule(), $key, $defaultValue);
    }

    public function setSetting($key, $value)
    {
        return $this->get('fork.settings')->set($this->getModule(), $key, $value);
    }
}
