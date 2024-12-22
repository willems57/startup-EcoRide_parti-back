<?php

namespace App\Controller;


use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
//use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/voiture', name: 'app_api_voiture')]
class VoitureController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private VoitureRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route(methods: 'POST')]
    /** @OA\Post(
     *     path="/api/voiture",
     *     summary="Créer un voiture",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données du voiture créer",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="voiture", type="string", example="Votre Imatriculation"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="fumeur", type="string", example="fumeur?"),
     *             @OA\Property(property="annimaux", type="string", example="annimaux?"),
     *             @OA\Property(property="marque", type="string", example="marque?"),
     *             @OA\Property(property="place", type="integer", example="place?"),
     *             @OA\Property(property="modele", type="string", example="modele?"),
     *             @OA\Property(property="couleur", type="string", example="couleur?"),
     *             @OA\Property(property="image", type="string", example="image?")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Voiture créé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="voiture", type="string", example="Votre Imatriculation"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="fumeur", type="string", example="fumeur?"),
     *             @OA\Property(property="annimaux", type="string", example="annimaux?"),
     *             @OA\Property(property="marque", type="string", example="marque?"),
     *             @OA\Property(property="place", type="integer", example="place?"),
     *             @OA\Property(property="modele", type="string", example="modele?"),
     *             @OA\Property(property="couleur", type="string", example="couleur?"),
     *             @OA\Property(property="image", type="string", example="image?")
     *         )
     *     )
     * )
     */
    public function new(Request $request): JsonResponse
    {
        $voiture = $this->serializer->deserialize($request->getContent(), Voiture::class, 'json');
        $voiture->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($voiture);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($voiture, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_trajets_show',
            ['id' => $voiture->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    /** @OA\Get(
     *     path="/api/voiture/{id}",
     *     summary="Afficher un voiture par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du voiture à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voiture trouvé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="voiture", type="string", example="Votre Imatriculation"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="fumeur", type="string", example="fumeur?"),
     *             @OA\Property(property="annimaux", type="string", example="annimaux?"),
     *             @OA\Property(property="marque", type="string", example="marque?"),
     *             @OA\Property(property="place", type="integer", example="place?"),
     *             @OA\Property(property="modele", type="string", example="modele?"),
     *             @OA\Property(property="couleur", type="string", example="couleur?"),
     *             @OA\Property(property="image", type="string", example="image?")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Voiture non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $voiture = $this->repository->findOneBy(['id' => $id]);
        if ($voiture) {
            $responseData = $this->serializer->serialize($voiture, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    
    /** @OA\Put(
     *     path="/api/voiture/{id}",
     *     summary="Modifier un voiture par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du voiture à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Nouvelles données du voiture à mettre à jour",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="voiture", type="string", example="Votre Imatriculation"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="fumeur", type="string", example="fumeur?"),
     *             @OA\Property(property="annimaux", type="string", example="annimaux?"),
     *             @OA\Property(property="marque", type="string", example="marque?"),
     *             @OA\Property(property="place", type="integer", example="place?"),
     *             @OA\Property(property="modele", type="string", example="modele?"),
     *             @OA\Property(property="couleur", type="string", example="couleur?"),
     *             @OA\Property(property="image", type="string", example="image?")
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Voiture modifié avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Voiture non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $voiture = $this->repository->findOneBy(['id' => $id]);
        if ($voiture) {
            $voiture = $this->serializer->deserialize(
                $request->getContent(),
                Voiture::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $voiture]
            );
            $voiture->setUpdatedAt(new DateTimeImmutable());

            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    /** @OA\Delete(
     *     path="/api/voiture/{id}",
     *     summary="Supprimer une voiture par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID d'une voiture à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="voiture supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="voiture non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $voiture = $this->repository->findOneBy(['id' => $id]);
        if ($voiture) {
            $this->manager->remove($voiture);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}


