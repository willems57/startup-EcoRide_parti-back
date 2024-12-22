<?php

namespace App\Controller;

use App\Entity\Credits;
use App\Repository\CreditsRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
//use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/credits', name: 'app_api_credits')]
class CreditsController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private CreditsRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route(methods: 'POST')]
    /** @OA\Post(
     *     path="/api/credits",
     *     summary="Créer un credits",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données du credits créer",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="credits", type="integer", example="Vos credits")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contact créé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="credits", type="integer", example="Vos credits")
     *         )
     *     )
     * )
     */
    public function new(Request $request): JsonResponse
    {
        $credits = $this->serializer->deserialize($request->getContent(), credits::class, 'json');
        $credits->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($credits);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($credits, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_credits_show',
            ['id' => $credits->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    /** @OA\Get(
     *     path="/api/credits/{id}",
     *     summary="Afficher un credits par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du credits à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Credits trouvé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="credits", type="integer", example="Vos credits")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Credits non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $credits = $this->repository->findOneBy(['id' => $id]);
        if ($credits) {
            $responseData = $this->serializer->serialize($credits, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    
    /** @OA\Put(
     *     path="/api/credits/{id}",
     *     summary="Modifier un credits par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du credits à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Nouvelles données du credits à mettre à jour",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="credits", type="integer", example="Vos credits")
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Credits modifié avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Credits non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $credits = $this->repository->findOneBy(['id' => $id]);
        if ($credits) {
            $credits = $this->serializer->deserialize(
                $request->getContent(),
                Credits::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $credits]
            );
            $credits->setUpdatedAt(new DateTimeImmutable());

            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    /** @OA\Delete(
     *     path="/api/credits/{id}",
     *     summary="Supprimer un credits par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du credits à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="credits supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Credits non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $credits = $this->repository->findOneBy(['id' => $id]);
        if ($credits) {
            $this->manager->remove($credits);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}

