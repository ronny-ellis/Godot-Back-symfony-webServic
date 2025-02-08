<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class IngredientApiController extends AbstractController{
    #[Route('/api/ingredients', methods:"POST")]
    public function create(EntityManagerInterface $em,#[MapRequestPayload(serializationContext:[
        'groups'=>['ingredients.create']
    ])] Ingredient $ingredient){

        $em->persist($ingredient);
        $em->flush();

        return $this->json($ingredient,200,[],[
            'groups'=>['ingredients.show']
        ]);
    }

    #[Route('/api/ingredients', methods:"GET")]
    public function findAll(IngredientRepository $repository){
        $ingredient=$repository->findAll();
        
        return $this->json($ingredient,200,[],[
            'groups'=>['ingredients.show']
        ]);
    }
    
    #[Route('/api/ingredients/{id}',requirements:['id'=>Requirement::DIGITS], methods:"GET")]
    public function finById(Ingredient $ingredient)
    {
        return $this->json($ingredient,200,[],[
            'groups'=>['ingredients.show']
        ]);
    }
}
