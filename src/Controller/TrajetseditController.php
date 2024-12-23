<?php

namespace App\Controller;

use App\Entity\Trajetsedit;
use App\Repository\TrajetseditRepository;
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


#[Route('/api/trajetsedit', name: 'app_api_trajetsedit')]
class TrajetseditController extends AbstractController

{
    public function __construct(
        private EntityManagerInterface $manager,
        private TrajetseditRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route(methods: 'POST')]
    /** @OA\Post(
     *     path="/api/trajetsedit",
     *     summary="Créer un trajetsedit",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données du trajetsedit créer",
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
     *         description="Trajetsedit créé avec succès",
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
        $trajetsedit = $this->serializer->deserialize($request->getContent(), Trajetsedit::class, 'json');
        $trajetsedit->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($trajetsedit);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($trajetsedit, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_trajetsedit_show',
            ['id' => $trajetsedit->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    /** @OA\Get(
     *     path="/api/trajetsedit/{id}",
     *     summary="Afficher un trajetsedit par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du trajetsedit à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trajetsedit trouvé avec succès",
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
     *         description="Trajetsedit non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $trajetsedit = $this->repository->findOneBy(['id' => $id]);
        if ($trajetsedit) {
            $responseData = $this->serializer->serialize($trajetsedit, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    
    /** @OA\Put(
     *     path="/api/trajetsedit/{id}",
     *     summary="Modifier un trajetsedit par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du trajetsedit à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Nouvelles données du trajetsedit à mettre à jour",
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
     *         description="Trajetsedit modifié avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trajetsedit non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $trajetsedit = $this->repository->findOneBy(['id' => $id]);
        if ($trajetsedit) {
            $trajetsedit = $this->serializer->deserialize(
                $request->getContent(),
                Trajetsedit::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $trajetsedit]
            );
            $trajetsedit->setUpdatedAt(new DateTimeImmutable());

            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    /** @OA\Delete(
     *     path="/api/trajetsedit/{id}",
     *     summary="Supprimer un trajetsedit par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du trajetsedit à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="trajetsedit supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="trajetsedit non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $trajetsedit = $this->repository->findOneBy(['id' => $id]);
        if ($trajetsedit) {
            $this->manager->remove($trajetsedit);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
