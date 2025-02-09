<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Repository\IngredientRepository;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class StockApiController extends AbstractController{
    #[Route('/api/stock', methods:"POST")]
    public function create(EntityManagerInterface $em,Request $request,IngredientRepository $ingredientRepository){
        $stock=new Stock();
        $ingredientData=json_decode($request->getContent(),true);
        $ingredient=$ingredientRepository->find($ingredientData['ingredient']['id']);
        $stock->setQuantite($ingredientData['quantite']);
        $stock->setIngredient($ingredient);

        $em->persist($stock);
        $em->flush();

        return $this->json($stock,200,[],[
            'groups'=>['stocks.show']
        ]);
    }
    #[Route('/api/stock', methods:"GET")]
    public function findAll(StockRepository $repository){
        $stock=$repository->findAll();
        
        return $this->json($stock,200,[],[
            'groups'=>['stocks.show']
        ]);
    }
    #[Route('/api/stock/{id}', requirements: ['id' => Requirement::DIGITS], methods: ["PUT"])]
    public function validation(Stock $stock, EntityManagerInterface $em) {
        if ($stock->getQuantite() > 0) {
            $stock->setQuantite($stock->getQuantite() - 1);
        } else {
            return $this->json(['error' => 'Stock insuffisant'], 400);
        }
        $em->persist($stock);
        $em->flush();

        return $this->json($stock, 200, [], [
            'groups' => ['stocks.show']
        ]);
    }

}
