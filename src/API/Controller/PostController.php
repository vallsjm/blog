<?php

declare(strict_types=1);

namespace API\Controller;

use API\Service\FormatRequestService;
use API\Service\FormatResponseService;
use Core\Application\Service\AuthorService;
use Core\Application\Service\PostService;
use Swagger\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class PostController
{
    private $postService;

    private $authorService;

    /**
     * @var FormatRequestService
     */
    private $formatRequestService;

    /**
     * @var FormatResponseService
     */
    private $formatResponseService;

    public function __construct(
        PostService $postService,
        AuthorService $authorService,
        FormatRequestService $formatRequestService,
        FormatResponseService $formatResponseService
    ) {
        $this->postService = $postService;
        $this->authorService = $authorService;
        $this->formatRequestService = $formatRequestService;
        $this->formatResponseService = $formatResponseService;
    }

    /**
     *   @OA\Get(tags={"post"}, summary="Get Post by Id",
     *      @OA\Parameter(
     *          name="info",
     *          in="query",
     *          required=false,
     *          enum={"extended","normal"},
     *          default="normal",
     *          type="string",
     *          description="Information extended for retrive the author"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Get post",
     *          @OA\Schema(
     *               type="object",
     *               example={"id": "64f5599c-09f4-44ae-82cc-1ebf6952599f", "author_id": "01772ec6-2831-4bbb-b33d-6d68cce73df0", "title": "Titulo del post", "description": "Descripcion del post", "content": "contenido"}
     *          )
     *      )
     *   )
     */
    public function getPostByIdAction(Request $request)
    {
        $post = $this->postService->findOneById($request->get('id'));

        if (!$post) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'post not found');
        }

        if ('extended' == $request->get('info')) {
            $author = $this->authorService->findOneById($post['author_id']);

            if (!$author) {
                throw new HttpException(Response::HTTP_NOT_FOUND, 'author of post not found');
            }

            unset($post['author_id']);
            $post['author'] = $author;
        }

        return $this->formatResponseService->response($post);
    }

    /**
     * @OA\Post(tags={"post"}, summary="Create a new Post",
     *      @OA\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          type="json",
     *          format="application/json",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(property="author_id", type="string", example="01772ec6-2831-4bbb-b33d-6d68cce73df0"),
     *              @OA\Property(property="title", type="string", example="Titulo del post"),
     *              @OA\Property(property="description", type="string", example="Descripcion del post"),
     *              @OA\Property(property="content", type="string", example="Contenido"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Get post created",
     *          @OA\Schema(
     *               type="object",
     *               example={"id": "64f5599c-09f4-44ae-82cc-1ebf6952599f", "author_id": "01772ec6-2831-4bbb-b33d-6d68cce73df0", "title": "Titulo del post", "description": "Descripcion del post", "content": "contenido"}
     *          )
     *      )
     * )
     */
    public function postPostAction(Request $request)
    {
        $payload = $this->formatRequestService->request($request);

        $author = $this->authorService->findOneById($payload['author_id']);
        if (!$author) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'author of post not found');
        }

        $payload = $this->postService->createFromPayload($payload);

        return $this->formatResponseService->response(
            $payload,
            Response::HTTP_CREATED
        );
    }
}
