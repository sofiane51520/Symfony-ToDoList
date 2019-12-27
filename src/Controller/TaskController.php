<?php


namespace App\Controller;


use App\Entity\Liste;
use App\Entity\Task;
use App\Form\Type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class TaskController extends AbstractController
{
    /**
     * @Route("/new/task", name="new_task")
     */
    public function new_task(Request $request){
        $new_task = new Task();
        $entityManager = $this->getDoctrine()->getManager();

        $repository_task = $this->getDoctrine()->getRepository(Task::class);
        $repository_liste = $this->getDoctrine()->getRepository(Liste::class);

        $form = $this->createForm(TaskType::class,$new_task);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $task_data = $form->getData();
            // Check if the list is already created
            $liste = $form->get('liste')->getData()->getName();
            $existing = $repository_liste->findOneBy(['name'=>$liste]);
            // if the list is already existing
            if($existing){
                //Set the already existing list for the new task
                $new_liste = $existing;
                $new_task->setListe($new_liste);
                $new_liste->addTask($new_task);
            } else {
                $liste->addTask($new_task);
            }

            $entityManager->persist($new_task);
            $entityManager->flush();
        }

        return $this->render('new.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}