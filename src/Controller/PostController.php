<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PostController extends AbstractController
{
    #[Route('api/posts', name: 'post', methods: ['GET'])]
    public function index(PostRepository $postRepository, SerializerInterface $serializer): JsonResponse
    {
        $postList = $postRepository->findAll();
        $jsonpostList = $serializer->serialize($postList, 'json', ['groups' => 'post:read','comment:read', 'user:read']);

        return new JsonResponse($jsonpostList, Response::HTTP_OK, [], true);
    }
}
