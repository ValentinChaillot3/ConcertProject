<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Band;
use App\Entity\Artist;
use App\Form\BandType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\BandRepository;
use Doctrine\ORM\EntityManagerInterface;

class BandController extends AbstractController
{
    /**
     * @var BandRepository
     */
    private $repository;

    public function __construct(BandRepository $repository, EntityManagerInterface $em)
    {
      $this->repository = $repository;
      $this->em = $em;
    }
    /**
     * @Route("/bands", name="bands_list")
     */
    public function index(): Response
    {
      $band = $this->getDoctrine()
        ->getRepository(Band::class)
        ->findAll();
        return $this->render('band/list.html.twig', [
            'controller_name' => 'BandController',
            'list' => $band,
        ]);
    }



    /**
     * @Route("/band/create" , name="band_create")
     * @isGranted("ROLE_ADMIN")
     */
    public function createBand(Request $request)
    {
      $band = new Band();
      $form = $this->createForm(BandType::class, $band);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($band);
        $this->em->flush();
        return $this->redirectToRoute('bands_list');
      }
      return $this->render('band/new.html.twig', [
        'band' => $band,
        'form' => $form->createView()
    
    ]);
    }
    
    /**
     * @Route("/band/edit/{band_id}" , name="band_edit")
     * @ParamConverter("band", options={"id" = "band_id"})
     * @isGranted("ROLE_ADMIN")
     */
    public function editBand(Band $band, Request $request) {

      $artist = $this->getDoctrine()
      ->getRepository(Artist::class)
      ->findAll();
      $form = $this->createForm(BandType::class, $band );
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $this->em->flush();
        return $this->redirectToRoute('bands_list');
      }
      return $this->render('band/edit.html.twig', [
        'band' => $band,
        'form' => $form->createView()
    
    ]);

  }

    /**
     * @Route("/band/delete/{band_id}" , name="band_delete")
     * @ParamConverter("band", options={"id" = "band_id"})
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteBand(Band $band, Request $request) {

      $this->em->remove($band);
      $this->em->flush();
        return $this->redirectToRoute('bands_list');
      }

     /**
     * @Route("/band/{id}", name="band_show")
     */
    public function band($id): Response
    {
      $band = $this->getDoctrine()
        ->getRepository(Band::class)
        ->find($id);
        return $this->render('band/band.html.twig', [
            'controller_name' => 'BandController',
            'band' => $band,
        ]);
    }



}
