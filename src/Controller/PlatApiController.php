<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class PlatApiController extends AbstractController{
    #[Route('/api/plats',methods:"POST")]
    public function create(EntityManagerInterface $em,Request $request,RecetteRepository $repository){
        $plat = new Plat();
        $recetteData = json_decode($request->getContent(), true);
        if (!isset($recetteData['recette']['id'])) {
            return new JsonResponse(["error" => "Recette ID is missing"], JsonResponse::HTTP_BAD_REQUEST);
        }
        $recette = $repository->find($recetteData['recette']['id']);
        if (!$recette) {
            return new JsonResponse(["error" => "Recette with ID " . $recetteData['recette']['id'] . " not found"], JsonResponse::HTTP_NOT_FOUND);
        }
        $plat->setRecette($recette);
        $plat->setNom($recetteData['nom']);

        $em->persist($plat);
        $em->flush();
        
        return $this->json($plat,200,[],[
            'groups'=>['plats.show']
        ]);
    }
    #[Route('/api/plats',methods:"GET")]
    public function findAll(PlatRepository $repository){
        $plat=$repository->findAll();
        return $this->json($plat,200,[],[
            'groups'=>['plats.show']
        ]);
    }
    #[Route('/api/plats/{id}',requirements:['id'=>Requirement::DIGITS],methods:"GET")]
    public function findById(Plat $plat){
        return $this->json($plat,200,[],[
            'groups'=>['plats.show']
        ]);
    }
}
