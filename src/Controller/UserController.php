<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('api/users', name: 'get_all_users')]
    public function getAllUsers(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {

        $users = $userRepository->findAll();

        $json = $serializer->serialize($users,'json', ['groups' => 'user:read']);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('api/users/{id}', name:'get_user_by_id')]
    public function getUserById(User $user, SerializerInterface $serializer): JsonResponse
    {
        if($user){
            $json = $serializer->serialize($user,'json', ['groups'=> 'user:read']);

            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(['error' => 'No User Found'], Response::HTTP_NOT_FOUND, [], true);
    }

    #[Route('api/users/{id}/posts', name:'get_posts_from_users')]
    public function getPostsFromUser(User $user, SerializerInterface $serializer): JsonResponse
    {
       if(!$user){
        return new JsonResponse(['error'=> 'No User Found'], Response::HTTP_NOT_FOUND, [], true);
       }

       $posts = $user->getPosts();

       if($posts->isEmpty()){
        return new JsonResponse(["error" => "No Post Found"], Response::HTTP_NOT_FOUND, [], true);
       }

       $json = $serializer->serialize($posts,"json", ['groups' => 'post:read']);

       return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
