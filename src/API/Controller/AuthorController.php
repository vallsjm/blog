<?php

declare(strict_types=1);

namespace API\Controller;

use API\Service\FormatRequestService;
use API\Service\FormatResponseService;
use Core\Application\Service\AuthorService;
use Swagger\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class AuthorController
{
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
        AuthorService $authorService,
        FormatRequestService $formatRequestService,
        FormatResponseService $formatResponseService
    ) {
        $this->authorService = $authorService;
        $this->formatRequestService = $formatRequestService;
        $this->formatResponseService = $formatResponseService;
    }

    /**
     *   @OA\Get(tags={"author"}, summary="Get Author by Id",
     *      @OA\Response(
     *          response=200,
     *          description="Get author",
     *          @OA\Schema(
     *               type="object",
     *               example={"id": "01772ec6-2831-4bbb-b33d-6d68cce73df0", "name": "Jose Maria", "surname": "Rodriguez"}
     *          )
     *      )
     *   )
     */
    public function getAuthorByIdAction(Request $request)
    {
        $author = $this->authorService->findOneById($request->get('id'));

        if (!$author) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'author not found');
        }

        return $this->formatResponseService->response($author);
    }

    /**
     * @OA\Post(tags={"author"}, summary="Create a new Author",
     *      @OA\Parameter(
     *          name="body",
     *          in="body",
     *          description="JSON Payload",
     *          required=true,
     *          type="json",
     *          format="application/json",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Jose Maria"),
     *              @OA\Property(property="surname", type="string", example="Rodriguez")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Get author created",
     *          @OA\Schema(
     *               type="object",
     *               example={"id": "01772ec6-2831-4bbb-b33d-6d68cce73df0", "name": "Jose Maria", "surname": "Rodriguez"}
     *          )
     *      )
     * )
     */
    public function postAuthorAction(Request $request)
    {
        $payload = $this->formatRequestService->request($request);
        $payload = $this->authorService->createFromPayload($payload);

        return $this->formatResponseService->response(
            $payload,
            Response::HTTP_CREATED
        );
    }
}
