<?php

namespace App\User\Http\Controller;

use App\User\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Exception;

/**
 * Class CreateAction
 * @package App\User\Http\Controller
 */
class CreateAction
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * CreateAction constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $this->userService->create(empty($request->getContent()) ? [] : json_decode($request->getContent(), true));
        } catch (Exception $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode() ? $exception->getCode() : Response::HTTP_BAD_REQUEST);
        } catch (Throwable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode() ? $exception->getCode() : Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'ok'], Response::HTTP_CREATED);
    }
}
