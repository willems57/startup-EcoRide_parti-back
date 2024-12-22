<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
//use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/Contact', name: 'app_api_contact_')]
class ContactController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private ContactRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route(methods: 'POST')]
    /** @OA\Post(
     *     path="/api/contact",
     *     summary="Créer un contact",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données du contact créer",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Votre nom"),
     *             @OA\Property(property="mail", type="string", example="Email du l'avis"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="message", type="text", example="Votre message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contact créé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Votre nom"),
     *             @OA\Property(property="mail", type="string", example="Email du l'avis"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="message", type="text", example="Votre message")
     *         )
     *     )
     * )
     */
    public function new(Request $request): JsonResponse
    {
        $contact = $this->serializer->deserialize($request->getContent(), contact::class, 'json');
        $contact->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($contact);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($contact, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_contact_show',
            ['id' => $contact->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    /** @OA\Get(
     *     path="/api/contact/{id}",
     *     summary="Afficher un contact par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du contact à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact trouvé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Votre nom"),
     *             @OA\Property(property="mail", type="string", example="Email du l'avis"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="message", type="text", example="Votre message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $contact = $this->repository->findOneBy(['id' => $id]);
        if ($contact) {
            $responseData = $this->serializer->serialize($contact, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    
    /** @OA\Put(
     *     path="/api/contact/{id}",
     *     summary="Modifier un avis par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du contact à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Nouvelles données du contact à mettre à jour",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Votre nom"),
     *             @OA\Property(property="mail", type="string", example="Email du l'avis"),
     *             @OA\Property(property="date", type="DateTime", format="date-time"),
     *             @OA\Property(property="message", type="text", example="Votre message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Contact modifié avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $contact = $this->repository->findOneBy(['id' => $id]);
        if ($contact) {
            $contact = $this->serializer->deserialize(
                $request->getContent(),
                Contact::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $contact]
            );
            $contact->setUpdatedAt(new DateTimeImmutable());

            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    /** @OA\Delete(
     *     path="/api/contact/{id}",
     *     summary="Supprimer un contact par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du contact à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="contact supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact non trouvé"
     *     )
     * )
     */
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $contact = $this->repository->findOneBy(['id' => $id]);
        if ($contact) {
            $this->manager->remove($contact);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}

