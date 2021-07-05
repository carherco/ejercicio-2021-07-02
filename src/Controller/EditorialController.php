<?php

namespace App\Controller;

use App\Entity\Editorial;
use App\Repository\EditorialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/editorial")
 */ 
class EditorialController extends AbstractController
{
    /**
     * @Route("/", name="editorial_index")
     */ 
    public function index(EditorialRepository $editorialRepository): Response
    {
        return $this->render('editorial/index.html.twig', [
            'editoriales' => $editorialRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="editorial_new")
     */ 
    public function new(): Response
    {
        return $this->render('editorial/new.html.twig');
    }

    /**
     * @Route("/insert", name="editorial_insert")
     */ 
    public function insert(Request $request, EntityManagerInterface $em): Response
    {
        $nombre = $request->request->get('nombre');
            
        $editorial = new Editorial();
        $editorial->setNombre($nombre);
            
        $em->persist($editorial);
        $em->flush();

        return $this->redirectToRoute('editorial_index');
    }

    /**
     * @Route("/{id}", name="editorial_show")
     */ 
    public function show($id, EditorialRepository $editorialRepository): Response
    {
        $editorial = $editorialRepository->find($id);
        return $this->render('editorial/show.html.twig', [
            'editorial' => $editorial,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="editorial_edit")
     */ 
    public function edit($id, EditorialRepository $editorialRepository): Response
    {
        $editorial = $editorialRepository->find($id);
        return $this->render('editorial/edit.html.twig', [
            'editorial' => $editorial,
        ]);
    }

    /**
     * @Route("/editorial/{id}/update", name="editorial_update")
     */ 
    public function update($id, EditorialRepository $editorialRepository, Request $request, EntityManagerInterface $em): Response
    {
        $nombre = $request->request->get('nombre');
            
        $editorial = $editorialRepository->find($id);
        $editorial->setNombre($nombre);
            
        $em->persist($editorial);
        $em->flush();

        return $this->redirectToRoute('editorial_index');
    }

    /**
     * @Route("/editorial/{id}/delete", name="editorial_delete")
     */ 
    public function delete($id, EditorialRepository $editorialRepository, EntityManagerInterface $em): Response
    {
        $editorial = $editorialRepository->find($id);
        $em->remove($editorial);
        $em->flush();

        return $this->redirectToRoute('editorial_index');
    }
}
