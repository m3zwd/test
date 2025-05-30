<?php

/**
 * Task controller.
 */

namespace App\Controller;

use App\Entity\Task;
use App\Service\TaskService;
use App\Service\TaskServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class TaskController.
 */
#[Route('/task')]
class TaskController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param TaskService $taskService Task service
     */
    public function __construct(private readonly TaskServiceInterface $taskService)
    {
    }

    /**
     * Index action.
     *
     * @param int $page Page number
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'task_index',
        methods: 'GET'
    )]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->taskService->getPaginatedList($page);

        return $this->render('task/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * View action.
     *
     * @param Task $task Task entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'task_view',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function view(Task $task): Response
    {
        return $this->render(
            'task/view.html.twig',
            ['task' => $task]
        );
    }
}
