<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Plat;
use App\Entity\Recette;
use App\Repository\CommandeRepository;
use App\Repository\PlatRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class CommandeApiController extends AbstractController{
    #[Route('/api/commandes', methods:"POST")]
    public function create(EntityManagerInterface $em,PlatRepository $repository,Request $request){
        $commande=new Commande();
        $platData=json_decode($request->getContent(),true);
        if (!isset($platData['plat']) || !is_array($platData['plat'])) {
            return new JsonResponse(["error" => "Invalid plat data"], JsonResponse::HTTP_BAD_REQUEST);
        }
        foreach ($platData['plat'] as $data) {
            $plat = $repository->find($data["id"]); 

            if ($plat) {
                $commande->addplat($plat);
            } else {
                return new JsonResponse(["error" => "plat with ID " . $data["id"] . " not found"], JsonResponse::HTTP_NOT_FOUND);
            }
        }

        $commande->setIdUser($platData['idUser']);
        $commande->setEstRecu($platData['estRecu']);
        $commande->setQuantite($platData['quantite']);
        $commande->setEstTermine($platData['estTermine']);
        $commande->setDateUpdate(new DateTimeImmutable());

        //dd($commande);

        $em->persist($commande);
        $em->flush();

        return $this->json($commande,200,[],[
            'groups'=>['commandes.show']
        ]);
    }

    #[Route('/api/commandes', methods:"GET")]
    public function findAll(CommandeRepository $repository){
        $commande=$repository->findAll();
        return $this->json($commande,200,[],[
            'groups'=>['commandes.show']
        ]);
    }

    #[Route('/api/commandes/{id}',requirements:['id'=>Requirement::DIGITS], methods:"GET")]
    public function findById(Commande $commande){
        return $this->json($commande,200,[],[
            'groups'=>['commandes.show']
        ]);
    }

    #[Route('/api/commandes/validation/{id}',requirements:['id'=>Requirement::DIGITS], methods:"PUT")]
    public function validation(Commande $commande,EntityManagerInterface $em){
        $commande->setEstRecu(true);
        $commande->setDateUpdate(new DateTimeImmutable());

        $em->persist($commande);
        $em->flush();

        return $this->json($commande,200,[],[
            'groups'=>['commandes.show']
        ]);
    }
    #[Route('/api/commandes/estTerminer/{id}',requirements:['id'=>Requirement::DIGITS], methods:"PUT")]
    public function estTerminer(Commande $commande,EntityManagerInterface $em){
        $commande->setEstTermine(true);
        $commande->setDateUpdate(new DateTimeImmutable());

        $em->persist($commande);
        $em->flush();

        return $this->json($commande,200,[],[
            'groups'=>['commandes.show']
        ]);
    }
}
