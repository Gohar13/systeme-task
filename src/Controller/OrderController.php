<?php

declare(strict_types=1);

namespace App\Controller;

use App\Bundle\ApiBundle\Request\Model\MakeOrderData;
use App\Component\Payment\Factory\PaymentProcessorFactory;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\CountryService;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations\RequestBody;
use App\Form\OrderFormType;
use Throwable;

/**
 * @Route("/api/v1/order")
 */
class OrderController extends ApiController
{

    private ProductRepository $productRepository;
    private CouponRepository $couponRepository;
    private ProductService $productService;
    private CountryService $countryService;
    private PaymentProcessorFactory $paymentProcessorFactory;

    /**
     * @param SerializerInterface $serializer
     * @param ProductRepository $productRepository
     * @param CouponRepository $couponRepository
     * @param ProductService $productService
     * @param CountryService $countryService
     */
    public function __construct(
        SerializerInterface $serializer,
        ProductRepository $productRepository,
        CouponRepository $couponRepository,
        ProductService $productService,
        CountryService $countryService,
        PaymentProcessorFactory $paymentProcessorFactory
    )
    {
        parent::__construct($serializer);

        $this->productRepository    = $productRepository;
        $this->couponRepository     = $couponRepository;
        $this->productService       = $productService;
        $this->countryService       = $countryService;
        $this->paymentProcessorFactory   = $paymentProcessorFactory;
    }

    /**
     * Order
     *
     * @param Request $request
     * @return Response
     *
     * @Route("/makeOrder", name="make_order", methods={"POST"})
     *
     * @OA\Post(
     *     tags={"Order"},
     *     @OA\RequestBody(@Model(type=OrderFormType::class, groups={"create"})),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function makeOrderAction(Request $request): Response
    {
        try {

            $form = $this->processForm($request, OrderFormType::class);

            $formData = $form->getData();

            $orderData = new MakeOrderData(
                $formData['product'],
                $formData['taxNumber'],
                $formData['couponCode'],
                $formData['paymentProcessor'],
            );

            return $this->successResponse(
                [
                    'ordered' => $this->getNormalizedData(
                        $this->productService->makeOrder(
                            $this->productRepository->getByIdOrThrowIfMissing($orderData->getProductId()),
                            $this->countryService->getCountryByTaxNumber($orderData->getTaxNumber()),
                            $this->paymentProcessorFactory->createProduct($orderData->getPaymentProcessor()),
                            $this->couponRepository->getByCodeOrThrowIfUsed($orderData->getCouponCode()),
                        )
                    )
                ]
            );

        } catch (Throwable $e) {
            return $this->errorResponse($e);
        }
    }

}