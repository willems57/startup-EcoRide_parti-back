<?php

namespace App\Controller;


use App\Entity\Trajets;
use App\Repository\TrajetsRepository;
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


#[Route('/api/trajets', name: 'app_api_trajets')]
class TrajetsController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TrajetsRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route(methods: 'POST')]
    /** @OA\Post(
     *     path="/api/trajets",
     *     summary="Créer un trajets",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données du trajets créer",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="Nom", type="string", example="Votre nom"),
     *             @OA\Property(property="Prenom", type="string", example="Votre prenom"),
     *             @OA\Property(property="voiture", type="string", example="Votre Imatriculation"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="depart", type="string", example="depart?"),
     *             @OA\Property(property="arriver", type="string", example="arriver?"),
     *             @OA\Property(property="duree", type="string", example="duree?"),
     *             @OA\Property(property="fumeur", type="string", example="fumeur?"),
     *             @OA\Property(property="annimaux", type="string", example="annimaux?"),
     *             @OA\Property(property="marque", type="string", example="marque?"),
     *             @OA\Property(property="place", type="integer", example="place?"),
     *             @OA\Property(property="modele", type="string", example="modele?"),
     *             @OA\Property(property="couleur", type="string", example="couleur?"),
     *             @OA\Property(property="image", type="string", example="image?"),
     *             @OA\Property(property="passager1", type="string", example="passager1?"),
     *             @OA\Property(property="EmailInput1", type="string", example="EmailInput1?"),
     *             @OA\Property(property="passager2", type="string", example="passager2?"),
     *             @OA\Property(property="EmailInput2", type="string", example="EmailInput2?"),
     *             @OA\Property(property="passager3", type="string", example="passager3?"),
     *             @OA\Property(property="EmailInput3", type="string", example="EmailInput3?"),
     *             @OA\Property(property="passager4", type="string", example="passager4?"),
     *             @OA\Property(property="EmailInput4", type="string", example="EmailInput4?"),
     *             @OA\Property(property="passager5", type="string", example="passager5?"),
     *             @OA\Property(property="EmailInput5", type="string", example="EmailInput5?")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Trajets créé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="Nom", type="string", example="Votre nom"),
     *             @OA\Property(property="Prenom", type="string", example="Votre prenom"),
     *             @OA\Property(property="voiture", type="string", example="Votre Imatriculation"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="depart", type="string", example="depart?"),
     *             @OA\Property(property="arriver", type="string", example="arriver?"),
     *             @OA\Property(property="duree", type="string", example="duree?"),
     *             @OA\Property(property="fumeur", type="string", example="fumeur?"),
     *             @OA\Property(property="annimaux", type="string", example="annimaux?"),
     *             @OA\Property(property="marque", type="string", example="marque?"),
     *             @OA\Property(property="place", type="integer", example="place?"),
     *             @OA\Property(property="modele", type="string", example="modele?"),
     *             @OA\Property(property="couleur", type="string", example="couleur?"),
     *             @OA\Property(property="image", type="string", example="image?"),
     *             @OA\Property(property="passager1", type="string", example="passager1?"),
     *             @OA\Property(property="EmailInput1", type="string", example="EmailInput1?"),
     *             @OA\Property(property="passager2", type="string", example="passager2?"),
     *             @OA\Property(property="EmailInput2", type="string", example="EmailInput2?"),
     *             @OA\Property(property="passager3", type="string", example="passager3?"),
     *             @OA\Property(property="EmailInput3", type="string", example="EmailInput3?"),
     *             @OA\Property(property="passager4", type="string", example="passager4?"),
     *             @OA\Property(property="EmailInput4", type="string", example="EmailInput4?"),
     *             @OA\Property(property="passager5", type="string", example="passager5?"),
     *             @OA\Property(property="EmailInput5", type="string", example="EmailInput5?")
     *         )
     *     )
     * )
     */
    public function new(Request $request): JsonResponse
    {
        $trajets = $this->serializer->deserialize($request->getContent(), Trajets::class, 'json');
        $trajets->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($trajets);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($trajets, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_trajets_show',
            ['id' => $trajets->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    /** @OA\Get(
     *     path="/api/trajets/{id}",
     *     summary="Afficher un trajets par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du trajets à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trajets trouvé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="Nom", type="string", example="Votre nom"),
     *             @OA\Property(property="Prenom", type="string", example="Votre prenom"),
     *             @OA\Property(property="voiture", type="string", example="Votre Imatriculation"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="depart", type="string", example="depart?"),
     *             @OA\Property(property="arriver", type="string", example="arriver?"),
     *             @OA\Property(property="duree", type="string", example="duree?"),
     *             @OA\Property(property="fumeur", type="string", example="fumeur?"),
     *             @OA\Property(property="annimaux", type="string", example="annimaux?"),
     *             @OA\Property(property="marque", type="string", example="marque?"),
     *             @OA\Property(property="place", type="integer", example="place?"),
     *             @OA\Property(property="modele", type="string", example="modele?"),
     *             @OA\Property(property="couleur", type="string", example="couleur?"),
     *             @OA\Property(property="image", type="string", example="image?"),
     *             @OA\Property(property="passager1", type="string", example="passager1?"),
     *             @OA\Property(property="EmailInput1", type="string", example="EmailInput1?"),
     *             @OA\Property(property="passager2", type="string", example="passager2?"),
     *             @OA\Property(property="EmailInput2", type="string", example="EmailInput2?"),
     *             @OA\Property(property="passager3", type="string", example="passager3?"),
     *             @OA\Property(property="EmailInput3", type="string", example="EmailInput3?"),
     *             @OA\Property(property="passager4", type="string", example="passager4?"),
     *             @OA\Property(property="EmailInput4", type="string", example="EmailInput4?"),
     *             @OA\Property(property="passager5", type="string", example="passager5?"),
     *             @OA\Property(property="EmailInput5", type="string", example="EmailInput5?")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trajets non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $trajets = $this->repository->findOneBy(['id' => $id]);
        if ($trajets) {
            $responseData = $this->serializer->serialize($trajets, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    
    /** @OA\Put(
     *     path="/api/trajets/{id}",
     *     summary="Modifier un trajets par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du trajets à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Nouvelles données du trajets à mettre à jour",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="Nom", type="string", example="Votre nom"),
     *             @OA\Property(property="Prenom", type="string", example="Votre prenom"),
     *             @OA\Property(property="voiture", type="string", example="Votre Imatriculation"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="depart", type="string", example="depart?"),
     *             @OA\Property(property="arriver", type="string", example="arriver?"),
     *             @OA\Property(property="duree", type="string", example="duree?"),
     *             @OA\Property(property="fumeur", type="string", example="fumeur?"),
     *             @OA\Property(property="annimaux", type="string", example="annimaux?"),
     *             @OA\Property(property="marque", type="string", example="marque?"),
     *             @OA\Property(property="place", type="integer", example="place?"),
     *             @OA\Property(property="modele", type="string", example="modele?"),
     *             @OA\Property(property="couleur", type="string", example="couleur?"),
     *             @OA\Property(property="image", type="string", example="image?"),
     *             @OA\Property(property="passager1", type="string", example="passager1?"),
     *             @OA\Property(property="EmailInput1", type="string", example="EmailInput1?"),
     *             @OA\Property(property="passager2", type="string", example="passager2?"),
     *             @OA\Property(property="EmailInput2", type="string", example="EmailInput2?"),
     *             @OA\Property(property="passager3", type="string", example="passager3?"),
     *             @OA\Property(property="EmailInput3", type="string", example="EmailInput3?"),
     *             @OA\Property(property="passager4", type="string", example="passager4?"),
     *             @OA\Property(property="EmailInput4", type="string", example="EmailInput4?"),
     *             @OA\Property(property="passager5", type="string", example="passager5?"),
     *             @OA\Property(property="EmailInput5", type="string", example="EmailInput5?")
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Trajets modifié avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trajets non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $trajets = $this->repository->findOneBy(['id' => $id]);
        if ($trajets) {
            $trajets = $this->serializer->deserialize(
                $request->getContent(),
                Trajets::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $trajets]
            );
            $trajets->setUpdatedAt(new DateTimeImmutable());

            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    /** @OA\Delete(
     *     path="/api/trajets/{id}",
     *     summary="Supprimer un trajets par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du trajets à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="trajets supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="trajets non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $trajets = $this->repository->findOneBy(['id' => $id]);
        if ($trajets) {
            $this->manager->remove($trajets);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}


