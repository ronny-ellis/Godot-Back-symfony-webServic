<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\Ingredient;
use App\Entity\Plat;
use App\Entity\Recette;
use App\Repository\IngredientRepository;
use App\Repository\PlatRepository;
use App\Repository\RecetteRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\Time;

final class PlatApiController extends AbstractController{
    #[Route('/api/plats',methods:"POST")]
    public function create(EntityManagerInterface $em,Request $request,IngredientRepository $repository){
        $plat = new Plat();
        $recette = new Recette();
        $historique=new Historique();
        $ingredientData = json_decode($request->getContent(), true);
        
        if (!isset($ingredientData['ingredients']) || !is_array($ingredientData['ingredients'])) {
            return new JsonResponse(["error" => "Invalid ingredient data"], JsonResponse::HTTP_BAD_REQUEST);
        }
        foreach ($ingredientData['ingredients'] as $data) {
            $ingredient = $repository->find($data["id"]); 
            
            if ($ingredient) {
                $recette->addIngredient($ingredient);
            } else {
                return new JsonResponse(["error" => "Ingredient with ID " . $data["id"] . " not found"], JsonResponse::HTTP_NOT_FOUND);
            }
        }
        $plat->setPrix($ingredientData['prix']);
        $plat->setTempsDeCuisson(new \DateTime($ingredientData['tempsDeCuisson']));
        $plat->setRecette($recette);
        $plat->setNom($ingredientData['nom']);

        $historique->setVariableType("Plat,recette");
        $historique->setDateAjout(new DateTimeImmutable());
        $historique->setDateUpdate(new DateTimeImmutable());

        $em->persist($plat);
        $em->persist($historique);
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
