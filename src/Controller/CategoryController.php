<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CategoryController extends AbstractController
{
    #[Route('api/categories', name: 'get_categories')]
    public function getAllCategories(CategoryRepository $categoryRepository, SerializerInterface $serializer): JsonResponse
    {

        $categories = $categoryRepository->findAll();

        $json = $serializer->serialize($categories,'json', ['groups' => 'category:read']);

        return new JsonResponse($json, Response::HTTP_OK,[], true);
        
    }

    #[Route('api/categories/{id}', name:'get_category_by_id')]
    public function getCategoryById(Category $category, SerializerInterface $serializer): JsonResponse
    {
        if($category){
            $json = $serializer->serialize($category,'json', ['groups' => 'category:read']);
            
            return new JsonResponse($json, Response::HTTP_OK,[], true);
        }

        return new JsonResponse(['error' => 'Category not found'], Response::HTTP_NOT_FOUND, [],true);
    }
}
