<?php

namespace App\Http\ArgumentResolver\Error;

use App\Http\ArgumentResolver\AbstractArgumentResolver;
use App\Http\ArgumentResolver\Error\Error;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
class ErrorResolver extends AbstractArgumentResolver
{
    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $argument->getType() === Error::class;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return \Generator
     *
     * @throws \Exception
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $session = $request->getSession();
        $message = $session->has('custom_error.message') ? $session->get('custom_error.message') : '';
        $code = $session->has('custom_error.code') ? (int) $session->get('custom_error.code') : 0;

        $error = new Error();
        $error
            ->setMessage($message)
            ->setCode($code);

        yield $error;
    }
}
