<?php

declare(strict_types=1);

namespace whatwedo\CrudHistoryBundle\Controller;

use Araise\AraiseBundle\Controller\CrudController;
use Araise\AraiseBundle\Enums\Page;
use Araise\AraiseBundle\Manager\DefinitionManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use whatwedo\CrudHistoryBundle\Manager\HistoryManager;
use whatwedo\CrudHistoryBundle\Page\HistoryPage;

class HistoryCrudController extends CrudController
{
    public function history(Request $request, HistoryManager $historyManager, DefinitionManager $definitionManager): Response
    {
        $entity = $this->getEntityOr404($request);
        $this->denyAccessUnlessGrantedCrud(Page::SHOW, $entity);

        $transactionList = $historyManager->getHistory($entity, 1);

        $this->definition->buildBreadcrumbs($entity, Page::SHOW);

        $this->definition->getBreadcrumbs()->addRouteItem('whatwedo_crud_history.breadcrumb', $this->definition::getRoute(HistoryPage::HISTORY), [
            'id' => $entity->getId(),
        ]);

        $view = $this->definition->createView(Page::SHOW, $entity);

        return $this->render(
            '@whatwedoCrudHistory/history/history.html.twig',
            [
                'wwd_crud_enable_breadcrumbs' => true,
                'transactionList' => $transactionList,
                'entity' => $entity,
                'view' => $view,
                'entityTitle' => (new \ReflectionMethod($this->definition, 'getEntityTitle'))->isStatic() ? $this->definition::getEntityTitle() : $this->definition->getEntityTitle(),
            ]
        );
    }
}
