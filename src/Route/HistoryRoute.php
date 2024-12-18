<?php

namespace whatwedo\CrudHistoryBundle\Route;

use Araise\AraiseBundle\Enums\Page;
use Araise\AraiseBundle\Enums\PageInterface;
use Araise\AraiseBundle\Crud\Route\RouteInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use whatwedo\CrudHistoryBundle\Controller\HistoryCrudController;
use whatwedo\CrudHistoryBundle\Page\HistoryPage;

#[Autoconfigure(tags: [RouteInterface::TAG])]
class HistoryRoute implements RouteInterface
{
    public function getPage(): PageInterface
    {
        return HistoryPage::HISTORY;
    }

    public function getRoute(): string
    {
        return '{id}/history';
    }

    public function getRequirements(): array
    {
        return [
            'id' => '\d+',
        ];
    }

    public function getMethods(): array
    {
        return ['GET'];
    }

    public function getControllerAction(): ?string
    {
        return HistoryCrudController::class .'::'. $this->getPage()->toRoute();
    }
}
