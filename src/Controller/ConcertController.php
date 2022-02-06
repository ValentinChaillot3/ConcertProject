<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Concert;
use App\Entity\Band;
use App\Repository\ConcertRepository;
use App\Form\ConcertType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ConcertController extends AbstractController
{

      /**
     * @var ConcertRepository
     */
    private $repository;

    public function __construct(ConcertRepository $repository, EntityManagerInterface $em)
    {
      $this->repository = $repository;
      $this->em = $em;
    }
    

    /**
     * @Route("/concert", name="concert")
     */
    public function index(): Response
    {
      $concert =$this->repository->findAll();
        return $this->render('concert/index.html.twig', [
            'list' => $concert
        ]);  
    }

   /**
     * @Route("/home", name="concert")
     */
    public function home(): Response
    {
      $concert =$this->repository->findAll();
        return $this->render('concert/index.html.twig', [
            'list' => $concert
        ]);  
    }

    /**
     * @Route("/concert/create" , name="concert_create")
     * @isGranted("ROLE_ADMIN")
     */
    public function createConcert(Request $request)
    {
      $concert = new Concert();
      $form = $this->createForm(ConcertType::class, $concert);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($concert);
        $this->em->flush();
        return $this->redirectToRoute('concert');
      }
      return $this->render('concert/new.html.twig', [
        'concert' => $concert,
        'form' => $form->createView()
    
    ]);
    }
    
    /**
     * @Route("/concert/edit/{concert_id}" , name="concert_edit")
     * @ParamConverter("concert", options={"id" = "concert_id"})
     * @isGranted("ROLE_ADMIN")
     */
    public function editConcert(Concert $concert, Request $request) {

      $band = $this->getDoctrine()
      ->getRepository(Band::class)
      ->findAll();
      $form = $this->createForm(ConcertType::class, $concert );
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $this->em->flush();
        return $this->redirectToRoute('concert');
      }
      return $this->render('concert/edit.html.twig', [
        'concert' => $concert,
        'form' => $form->createView()
    
    ]);

  }

      /**
     * @Route("/concert/delete/{concert_id}" , name="concert_delete")
     * @ParamConverter("concert", options={"id" = "concert_id"})
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteConcert(Concert $concert, Request $request) {

      $this->em->remove($concert);
      $this->em->flush();
        return $this->redirectToRoute('concert');
      }

    /**
     * @Route("/concert/{id}", name="concert_show")
     */
    public function concert($id): Response
    {
      $concert = $this->getDoctrine()
        ->getRepository(Concert::class)
        ->findAll();
        return $this->render('concert/index.html.twig', [
            'list' => $concert,
            'idBand' => $id
        ]);
    }



}

