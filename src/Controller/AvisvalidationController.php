<?php

namespace App\Controller;

use App\Entity\Avisvalidation;
use App\Repository\AvisvalidationRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/api/Avisvalidation', name: 'app_api_avisvalidation_')]
class AvisvalidationController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AvisvalidationRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route(methods: 'POST')]
    /** @OA\Post(
     *     path="/api/avisvalidation",
     *     summary="Créer un avisvalidation",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données de l'avisvalidation à créer",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Votre nom"),
     *             @OA\Property(property="commentaire", type="string", example="Description de l'avis"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="Conducteur", type="string", example="Nom du conducteur")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Avis créé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Votre nom"),
     *             @OA\Property(property="commentaire", type="string", example="Description de l'avis"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="Conducteur", type="string", example="Nom du conducteur")
     *         )
     *     )
     * )
     */
    public function new(Request $request): JsonResponse
    {
        $avisvalidation = $this->serializer->deserialize($request->getContent(), Avisvalidation::class, 'json');
        $avisvalidation->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($avisvalidation);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($avisvalidation, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_avis_show',
            ['id' => $avisvalidation->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    /** @OA\Get(
     *     path="/api/avis/{id}",
     *     summary="Afficher un avis par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'avis à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Avis trouvé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Votre nom"),
     *             @OA\Property(property="commentaire", type="string", example="Description de l'avis"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="Conducteur", type="string", example="Nom du conducteur")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Avis non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $avisvalidation = $this->repository->findOneBy(['id' => $id]);
        if ($avisvalidation) {
            $responseData = $this->serializer->serialize($avisvalidation, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    
    /** @OA\Put(
     *     path="/api/avis/{id}",
     *     summary="Modifier un avis par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'avis à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Nouvelles données de l'avis à mettre à jour",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Nouveau no de l'avis"),
     *             @OA\Property(property="commentaire", type="string", example="Nouveaux commentaire de l'avis"),
     *             @OA\Property(property="Conducteur", type="string", example="nouveau nom du conducteur")
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Avis modifié avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Avis non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $avisvalidation = $this->repository->findOneBy(['id' => $id]);
        if ($avisvalidation) {
            $avisvalidation = $this->serializer->deserialize(
                $request->getContent(),
                Avisvalidation::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $avisvalidation]
            );
            $avisvalidation->setUpdatedAt(new DateTimeImmutable());

            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    /** @OA\Delete(
     *     path="/api/avis/{id}",
     *     summary="Supprimer un avis par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du avis à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Avis supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Avis non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $avisvalidation = $this->repository->findOneBy(['id' => $id]);
        if ($avisvalidation) {
            $this->manager->remove($avisvalidation);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}

