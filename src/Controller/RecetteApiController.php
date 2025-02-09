<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\Ingredient;
use App\Entity\Recette;
use App\Repository\IngredientRepository;
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

final class RecetteApiController extends AbstractController{
    #[Route('/api/recettes', methods:"POST")]
    public function create(EntityManagerInterface $em,Request $request,IngredientRepository $repository){
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

        $historique->setVariableType("recette");
        $historique->setDateAjout(new DateTimeImmutable());
        $historique->setDateUpdate(new DateTimeImmutable());
        
        $em->persist($recette);
        $em->persist($historique);
        $em->flush();

        return $this->json($recette,200,[],[
            'groups'=>['recettes.show']
        ]);
    }

    #[Route('/api/recettes', methods:"GET")]
    public function findAll(RecetteRepository $repository)
    {
        $recette=$repository->findAll();

        return $this->json($recette,200,[],[
            'groups'=>['recettes.show']
        ]); 
    }
    
    #[Route('/api/recettes/{id}', requirements:['id'=>Requirement::DIGITS], methods:"GET")]
    public function findById(Recette $recette){
        return $this->json($recette,200,[],[
            'groups'=>['recettes.show']
        ]);
    }

    #[Route('/api/recettes/{id}', requirements:['id'=>Requirement::DIGITS], methods:"PUT")]
    public function update(){
               
    }
}
