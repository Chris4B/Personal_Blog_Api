<?php

namespace App\Controller;

use App\Entity\Post;
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
        $jsonpostList = $serializer->serialize($postList, 'json', ['groups' => 'post:read']);

        return new JsonResponse($jsonpostList, Response::HTTP_OK, [], true);
    }

    #[Route('api/posts/{id}', name: 'detailPost', methods: ['GET'])]
    public function getPostById(Post $post, SerializerInterface $serializer, PostRepository $postRepository): JsonResponse
    {
        // $post = $postRepository->find($id);

        if ($post) {
            $json = $serializer->serialize($post, 'json', ['groups' => 'post:read']);
            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND, [], true);
    }
}
