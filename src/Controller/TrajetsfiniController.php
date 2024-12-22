<?php

namespace App\Controller;

use App\Entity\Trajetsfini;
use App\Repository\TrajetsfiniRepository;
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


#[Route('/api/trajetsfini', name: 'app_api_trajetsfini')]
class TrajetsfiniController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TrajetsfiniRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route(methods: 'POST')]
    /** @OA\Post(
     *     path="/api/trajetsfini",
     *     summary="Créer un trajetsfini",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données du trajetsfini créer",
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
     *         description="Trajetsfini créé avec succès",
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
        $trajetsfini = $this->serializer->deserialize($request->getContent(), Trajetsfini::class, 'json');
        $trajetsfini->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($trajetsfini);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($trajetsfini, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_trajetsfini_show',
            ['id' => $trajetsfini->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    /** @OA\Get(
     *     path="/api/trajetsfini/{id}",
     *     summary="Afficher un trajetsfini par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du trajetsfini à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trajetsfini trouvé avec succès",
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
     *         description="Trajetsfini non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $trajetsfini = $this->repository->findOneBy(['id' => $id]);
        if ($trajetsfini) {
            $responseData = $this->serializer->serialize($trajetsfini, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    
    /** @OA\Put(
     *     path="/api/trajetsfini/{id}",
     *     summary="Modifier un trajetsfini par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du trajetsfini à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Nouvelles données du trajetsfini à mettre à jour",
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
     *         description="Trajetsfini modifié avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trajetsfini non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $trajetsfini = $this->repository->findOneBy(['id' => $id]);
        if ($trajetsfini) {
            $trajetsfini = $this->serializer->deserialize(
                $request->getContent(),
                Trajetsfini::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $trajetsfini]
            );
            $trajetsfini->setUpdatedAt(new DateTimeImmutable());

            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    /** @OA\Delete(
     *     path="/api/trajets/{id}",
     *     summary="Supprimer un trajetsfini par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du trajetsfini à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="trajetsfini supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="trajetsfini non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $trajetsfini = $this->repository->findOneBy(['id' => $id]);
        if ($trajetsfini) {
            $this->manager->remove($trajetsfini);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}


