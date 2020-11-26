<?php

namespace Frontend\Modules\GoogleReview\Widgets;

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;

class ReviewsScore extends FrontendBaseWidget
{
    public function execute(): void
    {
        parent::execute();

        $this->loadTemplate();

        $score = $this->get('fork.settings')->get($this->getModule(), 'score');
        $reviewCount = $this->get('fork.settings')->get($this->getModule(), 'review_count');

        $this->template->assign('score', $score);
        $this->template->assign('reviewCount', $reviewCount);
    }
}
