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
    public function getPostById(Post $post, SerializerInterface $serializer): JsonResponse
    {

        if ($post) {
            $json = $serializer->serialize($post, 'json', ['groups' => 'post:read']);
            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND, [], true);
    }

    #[Route('api/posts/{id}/comments', name:'get_all_comment_by_post', methods: ['GET'])]
    public function getAllCommentsByPost(Post $post, SerializerInterface $serializer): JsonResponse
    {
        if(!$post){
            return new JsonResponse(['error' => "Post not found"], Response::HTTP_NOT_FOUND, [], true);
        }

        $comments = $post->getComments();

        $jsoncomments = $serializer->serialize($comments,"json", ['groups' => 'comment:read']);

        return new JsonResponse($jsoncomments, Response::HTTP_OK, [], true);
    }

    #[Route('api/posts/{id}/categories', name:'', methods: ['GET'])]
    public function getCategoryByPost(Post $post, SerializerInterface $serializer): JsonResponse
    {
        if(!$post){
            return new JsonResponse(['error'=> 'Post not Found'], Response::HTTP_NOT_FOUND, [], true);
        }

        $categories = $post->getCategories();
        $jsoncategories = $serializer->serialize($categories,'json', ['groups' => 'category:read'] );

        return new JsonResponse($jsoncategories, Response::HTTP_OK, [], true);
    }

    
}
