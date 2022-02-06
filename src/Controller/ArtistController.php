<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Artist;
use App\Form\ArtistType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;

class ArtistController extends AbstractController
{
    /**
     * @var ArtistRepository
     */
    private $repository;

    public function __construct(ArtistRepository $repository, EntityManagerInterface $em)
    {
      $this->repository = $repository;
      $this->em = $em;
    }
    /**
     * @Route("/artist", name="artist")
     */
    public function index(): Response
    {
      $artist = $this->getDoctrine()
        ->getRepository(Artist::class)
        ->findAll();
        return $this->render('artist/index.html.twig', [
            'list' => $artist,
        ]);
    }

    /**
     * @Route("/artist/create" , name="artist_create")
     * @isGranted("ROLE_ADMIN")
     */
    public function createArtist(Request $request)
    {
      $artist = new Artist();
      $form = $this->createForm(ArtistType::class, $artist);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($artist);
        $this->em->flush();
        return $this->redirectToRoute('artist');
      }
      return $this->render('artist/new.html.twig', [
        'artist' => $artist,
        'form' => $form->createView()
    
    ]);
    }
    
    /**
     * @Route("/artist/edit/{artist_id}" , name="artist_edit")
     * @ParamConverter("artist", options={"id" = "artist_id"})
     * @isGranted("ROLE_ADMIN")
     */
    public function editArtist(Artist $artist, Request $request) {

      $form = $this->createForm(ArtistType::class, $artist );
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $this->em->flush();
        return $this->redirectToRoute('artist');
      }
      return $this->render('artist/edit.html.twig', [
        'artist' => $artist,
        'form' => $form->createView()
    
    ]);

  }

    /**
     * @Route("/artist/delete/{artist_id}" , name="artist_delete")
     * @ParamConverter("artist", options={"id" = "artist_id"})
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteArtist(Artist $artist, Request $request) {

      $this->em->remove($artist);
      $this->em->flush();
        return $this->redirectToRoute('artist');
      }



}
