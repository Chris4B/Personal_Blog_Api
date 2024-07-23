<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CommentController extends AbstractController
{
    #[Route('api/comments', name: 'get_all_comments')]
    public function getAllComments(CommentRepository $commentRepository, SerializerInterface $serializer): JsonResponse
    {
        $comments = $commentRepository->findAll();

        $jsonComments = $serializer->serialize($comments,'json', ['groups'=>['comment:read']]);

        return new JsonResponse($jsonComments, Response::HTTP_OK,[], true);
    }

    #[Route('api/comments/{id}', name:'get_comment_by_id')]
    public function getCommentById(Comment $comment, SerializerInterface $serializer): JsonResponse
    {
        if($comment){
            $jsonComments = $serializer->serialize($comment,'json', ['groups'=>['comment:read']]);

            return new JsonResponse($jsonComments, Response::HTTP_OK,[], true);
        }

        return new JsonResponse(['error' => 'No Comment Found'], Response::HTTP_NOT_FOUND);
    }
}
