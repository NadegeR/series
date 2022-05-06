<?php

namespace App\Controller;


use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/series", name="serie_")
 */

class SerieController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(SerieRepository $serieRepository): Response
    {
       // $series = $serieRepository->findBy([], ['popularity' => 'DESC', 'vote' => 'DESC'], 30);
        $series = $serieRepository->findBestSeries();

        return $this->render('serie/list.html.twig',["series" => $series]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        // declencher 1 erreur 404 si la serie n'existe plus ou pas
        if(!$serie){
            throw $this->createNotFoundException("oh no !");
        }

        return $this->render('serie/details.html.twig', ["serie" => $serie]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response{
        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);

        //gestion des dates en commentaires dans le form SerieType
        $serie-> setDateCreated(new \DateTime());

        //traitement du Form
        $serieForm->handleRequest($request); // recup les saisies

        if($serieForm->isSubmitted() && $serieForm->isValid()){

            $entityManager->persist($serie);
            $entityManager->flush();

            //message flash
            $this->addFlash('success', 'Serie added! Good job.');
            // Pr envoyer sur la page details de la serie ajoutee
            return $this->redirectToRoute('serie_details', ['id'=>$serie->getId()]);
        }

        return $this->render('serie/create.html.twig',['serieForm'=>$serieForm->createView()]);
    }

    /**
     * @Route ("/delete/{id}", name = "delete")
     */
    public function delete(serie $serie, EntityManagerInterface $entityManager){
        // je type en serie pour recup l'id
        // remplace (int $id, SerieRepository $serieRepository)
        // et permet de pas faire> $serie = $serieRepository->find($id);
        $entityManager-> remove($serie);
        $entityManager-> flush();

        return $this->redirectToRoute('main-home');
    }

    /**
     * @Route ("/demo", name="em-demo")
     */
    public function demo(EntityManagerInterface $entityManager): Response{

//        //creation de l'instance de mon entite
//        $serie = new Serie();

//        //hydrate toutes le ppte
//        $serie->setName('pif');
//        $serie->setBackdrop('dafsd');
//        $serie->setPoster('dafsd');
//        $serie->setDateCreated(new \DateTime());
//        $serie->setFirstAirDate(new \DateTime("-1 year"));
//        $serie->setLastAirDate(new \DateTime("-6 month"));
//        $serie->setGenres('drama');
//        $serie->setOverview('bla bla bla');
//        $serie->setPopularity(123.00);
//        $serie->setVote(8.2);
//        $serie->setStatus('Canceled');
//        $serie->setTmdbId(329432);
//        dump($serie);
//
//        $entityManager->persist($serie);
//        $entityManager->flush();
//
//        dump($serie);
//        $serie->setGenres('comedy');
//        $entityManager->remove($serie); pour supprimer
//        $entityManager->flush();

        return $this->render('serie/create.html.twig');
    }


}
