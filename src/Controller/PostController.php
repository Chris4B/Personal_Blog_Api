<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PostController extends AbstractController
{
    /**
     * Récupère et renvoie la liste des posts au format JSON 
     * 
     * Cette méthode récupère tous les posts depuis le repository,
     * les serilialise au format JSON en utilisant un groupe de sérialisation spécifique, 
     * et retourne une réponse JSON avec un code de statut HTTP 200 (OK)
     * 
     * @param PostRepository $postRepository -> Le repository des posts pour accéder aux données des posts.
     * @param SerializerInterface $serializer -> Le service de sérialisation pour convertir les objets en JSON.
     * 
     * @return JsonResponse -> La réponse JSON contenant la liste des posts réalisés.
     * 
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface -> si une erreur de sérialisation se produit.
     */
    #[Route('/api/posts/', name: 'post', methods: ['GET'])]
    public function index(PostRepository $postRepository, SerializerInterface $serializer): JsonResponse
    {
        $postList = $postRepository->findAll();

        // Sérialiser la liste de posts en JSON en utilisant un groupe de sérialisation spécifique.
        $jsonpostList = $serializer->serialize($postList, 'json', ['groups' => 'post:read']);

        // Retourner la réponse JSON avec un code de statut HTTP 200 (OK)
        return new JsonResponse($jsonpostList, Response::HTTP_OK, [], true);
    }

    /**
     * Récupère et renvoie une sélection partielle de l'entité Posts  au format JSON
     * 
     * Cette méthode permet de récupérer uniquement certains champs de posts.
     *  
     * 
     * @param PostRepository $postRepository Le repository des posts pour accéder aux données des posts.
     * @param SerializerInterface $serializer Le service de sérialisation pour convertir les objets en JSON.
     * @param Request $request L'objet de requête HTTP, utilisé pour obtenir les champs spécifiés.
     *
     * @return JsonResponse La réponse JSON contenant la sélection partielle des posts.
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface Si une erreur de sérialisation se produit.
     */
    #[Route('/api/posts/partial', name: 'post_partial', methods: ['GET'])]
    public function indexPartial(PostRepository $postRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {

        $postlist = $postRepository->findAll();

        // Serialiser la liste des Posts 
        // Le groupe utilisé n'est attribué qu'à certains champs de la classe Post 

        $jsonList = $serializer->serialize($postlist, 'json', ['groups' => 'post:partial']);

        return new JsonResponse($jsonList, Response::HTTP_OK, [], true);
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
}
