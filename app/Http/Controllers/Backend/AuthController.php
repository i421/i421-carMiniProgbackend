<?php

namespace App\Http\Controllers\backend;

use Psr\Http\Message\ServerRequestInterface;
use \Laravel\Passport\Http\Controllers\AccessTokenController;

class AuthController extends AccessTokenController
{
    public function auth(ServerRequestInterface $request)
    {
		$getBody = $request->getParsedBody();
		$newBody = array_merge($getBody, [
			'password' => aesDecrypt($getBody['password']),
			'client_id' => aesDecrypt($getBody['client_id']),
			'client_secret' => aesDecrypt($getBody['client_secret']),
		]);
		$newRequest = $request->withParsedBody($newBody);

		$tokenResponse = parent::issueToken($newRequest);
		$token = $tokenResponse->getContent();
		return $token;
    }
}
