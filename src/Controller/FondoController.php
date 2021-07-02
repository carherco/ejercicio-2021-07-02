<?php

namespace App\Controller;

use App\Entity\Fondo;
use App\Repository\AutorRepository;
use App\Repository\EditorialRepository;
use App\Repository\FondoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** 
 * @Route("/fondo")
 */
class FondoController extends AbstractController
{
    /** 
     * @Route("/", name="fondo_index")
     */
    public function index(FondoRepository $fondoRepository): Response
    {
        return $this->render('fondo/index.html.twig', [
            'fondos' => $fondoRepository->findAll(),
        ]);
    }

    /** 
     * @Route("/new", name="fondo_new")
     */
    public function new( 
        EditorialRepository $editorialRepository,
        AutorRepository $autorRepository
        ): Response
    {
        return $this->render('fondo/new.html.twig', [
            'editoriales' => $editorialRepository->findAll(),
            'autores' => $autorRepository->findAll(),
        ]);
    }

    /** 
     * @Route("/insert", name="fondo_insert")
     */
    public function insert(
        Request $request, 
        EditorialRepository $editorialRepository,
        AutorRepository $autorRepository,
        EntityManagerInterface $em
        ): Response
    {
        $datosForm = $request->request->get('fondo');

        $fondo = new Fondo();
        $fondo->setTitulo($datosForm['titulo']);
        $fondo->setIsbn($datosForm['isbn']);
        $fondo->setEdicion($datosForm['edicion']);
        $fondo->setPublicacion($datosForm['publicacion']);
        $fondo->setCategoria($datosForm['categoria']);
        
        $editorial = $editorialRepository->find($datosForm['editorialId']);
        $fondo->setEditorial($editorial);

        foreach($datosForm['autoresIds'] as $autorId) {
            $autor = $autorRepository->find($autorId);
            $fondo->addAutor($autor);
        }

        $em->persist($fondo);
        $em->flush();

        return $this->redirectToRoute('fondo_index');
        
    }

    /** 
     * @Route("/{id}", name="fondo_show")
     */ 
    public function show(Fondo $fondo): Response
    {
        return $this->render('fondo/show.html.twig', [
            'fondo' => $fondo,
        ]);
    }

    /** 
     * @Route("/{id}/edit", name="fondo_edit")
     */ 
    public function edit(
        $id,
        FondoRepository $fondoRepository, 
        EditorialRepository $editorialRepository,
        AutorRepository $autorRepository
    ): Response
    { 
        $fondo = $fondoRepository->find($id);
        
        return $this->render('fondo/edit.html.twig', [
            'fondo' => $fondo,
            'editoriales' => $editorialRepository->findAll(),
            'autores' => $autorRepository->findAll(),
        ]);
    }

    /** 
     * @Route("/{id}/update", name="fondo_update")
     */ 
    public function update(
        $id,
        Request $request, 
        FondoRepository $fondoRepository, 
        EditorialRepository $editorialRepository,
        AutorRepository $autorRepository,
        EntityManagerInterface $em
    ): Response
    {
        $datosForm = $request->request->get('fondo');

        $fondo = $fondoRepository->find($id);
        $fondo->setTitulo($datosForm['titulo']);
        $fondo->setIsbn($datosForm['isbn']);
        $fondo->setEdicion($datosForm['edicion']);
        $fondo->setPublicacion($datosForm['publicacion']);
        $fondo->setCategoria($datosForm['categoria']);
        
        $editorial = $editorialRepository->find($datosForm['editorialId']);
        $fondo->setEditorial($editorial);

        foreach($datosForm['autoresIds'] as $autorId) {
            $autor = $autorRepository->find($autorId);
            $fondo->addAutor($autor);
        }

        $em->persist($fondo);
        $em->flush();

        return $this->render('fondo/edit.html.twig', [
            'fondo' => $fondo,
            'editoriales' => $editorialRepository->findAll(),
            'autores' => $autorRepository->findAll(),
        ]);
    }

    /** 
     * @Route("delete/{id}", name="fondo_delete")
     */ 
    public function delete(
        $id,
        FondoRepository $fondoRepository, 
        EntityManagerInterface $em
    ): Response
    {
        $fondo = $fondoRepository->find($id);
        $em->remove($fondo);
        $em->flush();

        return $this->redirectToRoute('fondo_index');
    }
}
