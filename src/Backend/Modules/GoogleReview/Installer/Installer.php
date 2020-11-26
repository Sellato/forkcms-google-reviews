<?php

namespace Backend\Modules\GoogleReview\Installer;

use Backend\Core\Installer\ModuleInstaller;
use Common\ModuleExtraType;

/**
 * Installer for the content blocks module
 */
class Installer extends ModuleInstaller
{
    public function install(): void
    {
        $this->addModule('GoogleReview');
        $this->importLocale(__DIR__ . '/Data/locale.xml');
        $this->configureBackendNavigation();
        $this->configureBackendRights();
        $this->configureExtras();
    }

    private function configureBackendNavigation(): void
    {
        // Set navigation for "Modules"
        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $this->setNavigation(
            $navigationModulesId,
            $this->getModule(),
            'google_review/index'
        );
    }

    private function configureBackendRights(): void
    {
        $this->setModuleRights(1, $this->getModule());
        $this->setActionRights(1, $this->getModule(), 'Index');
        $this->setActionRights(1, $this->getModule(), 'UpdateScore');
    }

    private function configureExtras()
    {
        $this->insertExtra('GoogleReview', ModuleExtraType::widget(), 'ReviewsScore', 'ReviewsScore');
    }
}
