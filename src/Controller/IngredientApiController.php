<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Requirement\Requirement;

final class IngredientApiController extends AbstractController{
    #[Route('/ingredients/api', methods:"POST")]
    public function create(EntityManagerInterface $em,#[MapRequestPayload(serializationContext:[
        'groups'=>['ingredients.create']
    ])]Ingredient $ingredient)
    {
        $em->persist($ingredient);
        $em->flush();

        return $this->json($ingredient,200,[],[
            'groups'=>['ingredients.show']
        ]);
    }
    #[Route('/ingredients/api', methods:"POST")]
    public function findAll(IngredientRepository $repository)
    {
        $ingredient=$repository->findAll();

        return $this->json($ingredient,200,[],[
            'groups'=>['ingredients.show']
        ]);
    }
    #[Route('/ingredients/api/{id}', methods:"POST",requirements:['id'=>Requirement::DIGITS])]
    public function findById(Ingredient $ingredient)
    {
        return $this->json($ingredient,200,[],[
            'groups'=>['ingredients.show']
        ]);
    }
}
