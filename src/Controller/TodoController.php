<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/todo", name="api_todo")
 */
class TodoController extends AbstractController
{
    private $entityManager;
    private $todoRepository;

    public function __construct(EntityManagerInterface $entityManager, TodoRepository $todoRepository)
    {

        $this->entityManager = $entityManager;
        $this->todoRepository = $todoRepository;
    }

    /**
     * @Route("/create", name="api_todo_create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
     public function create(Request $request)
     {
        $content = json_decode($request->getContent());

        $form = $this->createForm(TodoType::class);
        $form->submit((array)$content);

        if (!$form->isValid()) {
         $errors = [];
         foreach ($form->getErrors(true, true) as $error) {
             $propertyName = $error->getOrigin()->getName();
             $errors[$propertyName] = $error->getMessage();
         }
         return $this->json([
             'message' => ['text' => join("\n", $errors), 'level' => 'error'],
         ]);

        }

        $todo = new Todo();

        $todo->setTask($content->task);
        $todo->setDescription($content->description);

        try {
            $this->entityManager->persist($todo);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            return $this->json([
                'message' => ['text' => ['Could not submit Todo to the database!'], 'level' => 'error']
            ]);
        }

        return $this->json([
            'todo' => $todo->toArray(),
            'message' => ['text' => ['Todo has been created successfully!', 'Task: ' . $content->task], 'level' => 'success']
        ]);
     }

    /**
     * @Route("/read", name="api_todo_read", methods={"GET"})
     */
    public function index()
    {
        $todos = $this->todoRepository->findAll();

        $arrayOfTodos = [];

        foreach ($todos as $todo)
        {
            $arrayOfTodos[] = $todo->toArray();
        }
        return $this->json($arrayOfTodos);
    }

    /**
     * @Route("/update/{id}", name="api_todo_update", methods={"PUT"})
     * @param Request $request
     * @param Todo $todo
     * @return JsonResponse
     */
    public function update(Request $request, Todo $todo)
    {
        $content = json_decode($request->getContent());

        $form = $this->createForm(TodoType::class);
        $noneObject = (array)$content;
        unset($noneObject['id']);
        $form->submit($noneObject);

        if (!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true, true) as $error) {
                $propertyName = $error->getOrigin()->getName();
                $errors[$propertyName] = $error->getMessage();
            }
            return $this->json([
                'message' => ['text' => join("\n", $errors), 'level' => 'error'],
            ]);

        }

        if ($todo->getTask() === $content->task && $todo->getDescription() === $content->description) {
            return $this->json([
               'message' => ['text' => 'There was no change to the Todo!', 'level' => 'warning']
            ]);
        }

        $todo->setTask($content->task);
        $todo->setDescription($content->description);

        try {
            $this->entityManager->flush();
        } catch (Exception $exception) {
            return $this->json([
                'message' => ['text' => ['Could not update Todo!'], 'level' => 'error']
            ]);
        }

        return $this->json([
            'todo' => $todo->toArray(),
            'message' => ['text' => ['Todo has been updated successfully!', 'Task: ' . $content->task], 'level' => 'success']
        ]);

    }

    /**
     * @Route("/delete/{id}", name="api_todo_delete", methods={"DELETE"})
     * @param Todo $todo
     * @return JsonResponse
     */
    public function delete(Todo $todo)
    {
        try {
            $this->entityManager->remove($todo);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            return $this->json([
                'message' => ['text' => ['Could not delete Todo!'], 'level' => 'error']
            ]);
        }

        return $this->json([
            'message' => ['text' => ['Todo has been deleted successfully!'], 'level' => 'success']
        ]);
    }
}
