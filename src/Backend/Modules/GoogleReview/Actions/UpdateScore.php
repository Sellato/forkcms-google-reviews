<?php

namespace Backend\Modules\GoogleReview\Actions;

use Backend\Core\Engine\Base\ActionIndex;
use Backend\Core\Engine\Model;
use Backend\Modules\GoogleReview\Command\UpdateScore as UpdateScoreCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Update the score manually
 */
final class UpdateScore extends ActionIndex
{
    public function execute(): void
    {
        parent::execute();

        $application = new Application($this->getKernel());
        $application->add(new UpdateScoreCommand($this->get('logger'), $this->get('fork.settings')));
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => UpdateScoreCommand::getDefaultName(),
        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);

        $this->redirect(Model::createUrlForAction('Index') . '&report=score-updated');
    }
}
