<?php

namespace App\Controller;

use App\Entity\Autor;
use App\Form\AutorType;
use App\Repository\AutorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AutorController extends AbstractController
{
    /** 
     * @Route("/autor", name="autor_index")
     */ 
    public function index(AutorRepository $autorRepository): Response
    {
        return $this->render('autor/index.html.twig', [
            'autors' => $autorRepository->findAll(),
        ]);
    }

    /** 
     * @Route("/autor/new", name="autor_new")
     */ 
    public function new(): Response
    {
        return $this->render('autor/new.html.twig');
    }

    /** 
     * @Route("/autor/insert", name="autor_insert")
     */ 
    public function insert(Request $request, EntityManagerInterface $em): Response
    {
        $nombre = $request->request->get('nombre');
        $tipo = $request->request->get('tipo');
        
        $autor = new Autor();
        $autor->setNombre($nombre);
        $autor->setTipo($tipo);
            
        $em->persist($autor);
        $em->flush();

        return $this->redirectToRoute('autor_index');
        
    }

    /** 
     * @Route("/autor/{id}", name="autor_show", methods={"GET"})
     */ 
    public function show(Autor $autor): Response
    {
        return $this->render('autor/show.html.twig', [
            'autor' => $autor,
        ]);
    }

    /** 
     * @Route("/autor/{id}/edit", name="autor_edit", methods={"GET", "POST"})
     */
    public function edit(
        $id,
        AutorRepository $autorRepository, ): Response
    {
        $autor = $autorRepository->find($id);

        return $this->render('autor/edit.html.twig', [
            'autor' => $autor
        ]);
    }

    /** 
     * @Route("/autor/{id}/update", name="autor_update")
     */ 
    public function update($id, Request $request, EntityManagerInterface $em, AutorRepository $autorRepository): Response
    {
        $nombre = $request->request->get('nombre');
        $tipo = $request->request->get('tipo');
        
        $autor = $autorRepository->find($id);
        $autor->setNombre($nombre);
        $autor->setTipo($tipo);
            
        $em->persist($autor);
        $em->flush();

        return $this->redirectToRoute('autor_index');
        
    }

    /** 
     * @Route("/autor/{id}/delete", name="autor_delete")
     */ 
    public function delete($id, EntityManagerInterface $em, AutorRepository $autorRepository): Response
    {
        $autor = $autorRepository->find($id);
        $em->remove($autor);
        $em->flush();
        
        return $this->redirectToRoute('autor_index');
    }
}
