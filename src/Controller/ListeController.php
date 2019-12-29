<?php


namespace App\Controller;

use App\Entity\Liste;
use App\Form\Type\ListeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ListeController extends AbstractController
{
    /**
     * @Route("/new/liste", name="new_liste")
     */
    public function new_liste(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $liste = new liste();

        $form = $this->createForm(ListeType::class,$liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $liste = $form->getData();
            $entityManager->persist($liste);
            $entityManager->flush();
        }

        return $this->render('new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/liste", name="show_liste")
     */
    public function show_liste(){
        $repository_liste = $this->getDoctrine()->getRepository(Liste::class);
        $listes = $repository_liste->findAll();

        return $this->render('base.html.twig', [
            'results' => $listes
        ]);
    }


    /**
     * @Route("/liste/{liste_name}", name="show_unique_liste")
     */
    public function show_unique_liste(string $liste_name){
        $repository_liste = $this->getDoctrine()->getRepository(Liste::class);
        $listes = $repository_liste->findOneBy(['name'=>$liste_name]);
        $tasks = $listes->getTasks();

        return $this->render('specific.html.twig', [
            'results' => $tasks
        ]);
    }

}