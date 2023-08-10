<?php

declare(strict_types=1);

namespace App\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Throwable;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Bundle\ApiBundle\Exception\FormProcessingException;
use App\Bundle\ApiBundle\Response\ErrorResponse;
use App\Bundle\ApiBundle\Response\SuccessResponse;
use App\Bundle\ApiBundle\Response\Response as ResponseData;

abstract class ApiController extends AbstractController
{

    /**
     * @param  Request $request
     * @param  string  $type
     * @param  mixed   $entity
     * @param  bool    $clearMissing
     * @param  array   $options
     *
     * @return FormInterface
     *
     * @throws FormProcessingException
     */
    protected function processForm(
        Request $request,
        string  $type,
                $entity       = null,
        bool    $clearMissing = true,
        array   $options      = []
    ): FormInterface
    {
        $content = $this->getRequestContent($request);

        $form = $this->createForm($type, $entity, array_merge($options, ['csrf_protection' => false]));

        $form->submit($content, $clearMissing);

        if (!$form->isValid()) {
            throw new FormProcessingException($form);
        }

        return $form;
    }

    /**
     * @param  Request $request
     *
     * @return array
     */
    protected function getRequestContent(Request $request): array
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * @param  mixed $data
     *
     * @return Response
     */
    protected function  successResponse($data = null): Response
    {
        return $this->jsonResponse(new SuccessResponse($data));
    }

    /**
     * @param  Throwable                $e
     *
     * @return Response
     */
    protected function errorResponse(Throwable $e): Response
    {
        if ($e instanceof FormProcessingException) {
            return $this->invalidFormResponse($e->getForm());
        }
        return $this->internalErrorResponse($e);
    }

    /**
     * @param  FormInterface $form
     *
     * @return Response
     */
    private function invalidFormResponse(FormInterface $form): Response
    {
        $flatErrors =  $this->getErrorHierarchy($form);

        $response = [
            'errors' => $flatErrors
        ];

        return new JsonResponse($response, 422);
    }

    /**
     * @param  FormInterface $form
     *
     * @return array
     */
    private function getErrorHierarchy(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as  $error) {

            if ($form->isRoot()) {
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            } else {
                $errors['-'] = str_replace(['&', '='], ['and', 'equal to'], $error->getMessage());
            }
        }

        foreach ($form->all() as $child) {

            if (!$child->isValid()) {

                $childErrors = $this->getErrorHierarchy($child);

                if (count($childErrors) === 1 && array_key_exists('-', $childErrors)) {
                    $childErrors = $childErrors['-'];
                }

                $errors[$child->getName()] = $childErrors;
            }
        }

        return $errors;
    }

    /**
     * @param  Throwable $e
     *
     * @return Response
     */
    private function internalErrorResponse(Throwable $e): Response
    {
        return $this->jsonResponse(new ErrorResponse($e->getMessage()));
    }

    /**
     * @param  ResponseData $responseData
     *
     * @return Response
     */
    private function jsonResponse(ResponseData $responseData): Response
    {
        return new JsonResponse($responseData, $responseData->getHttpCode());
    }

}