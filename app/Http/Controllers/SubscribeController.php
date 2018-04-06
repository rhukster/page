<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SendGrid;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Class SubscribeController
 * @package App\Http\Controllers
 */
class SubscribeController extends Controller
{
    /** @var string $sendGridApiKey */
    private $sendGridApiKey;

    /** @var mixed $sendGridListId */
    private $sendGridListId;

    /** @var SendGrid $sendGrid */
    private $sendGrid;

    /** @var string $email */
    private $email;

    /**
     * SubscribeController constructor.
     */
    public function __construct()
    {
        $this->sendGridApiKey = env('SENDGRID_API_KEY');
        $this->sendGridListId = env('SENDGRID_LIST_ID');
    }

    /**
     * @return void
     */
    private function initSendGrid()
    {
        $this->sendGrid = new SendGrid($this->sendGridApiKey);
    }

    /**
     * @return bool
     */
    private function validateEmail(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribe(Request $request): JsonResponse
    {
        $this->email = $request['email'];

        if (!$this->validateEmail()) {
            return response()->json('failed', 200);
        }

        $this->initSendGrid();

        if ($this->insertEmail()) {
            return response()->json('success', 200);
        }

        return response()->json('exists', 200);
    }

    /**
     * @param $response
     * @return array
     */
    private function getResponseBody($response): array
    {
        return json_decode($response->body(), true);
    }

    /**
     * @param $response
     * @param $body
     * @return bool
     */
    private function insertEmailIsValid($response, $body): bool
    {
        return $response->statusCode() == 201 && $body['new_count'] == 1;
    }

    /**
     * @return bool
     */
    private function insertEmail(): bool
    {
        $response = $this->postEmail();

        $body = $this->getResponseBody($response);

        if (!$this->insertEmailIsValid($response, $body)) {
            return false;
        }

        if ($this->addToList($body['persisted_recipients'][0]) !== 201) {
            return false;
        }

        return true;
    }

    /**
     * @param string $id
     * @return int
     */
    private function addToList(string $id): int
    {
        return $this->sendGrid->client
            ->contactdb()
            ->lists()
            ->_($this->sendGridListId)
            ->recipients()
            ->_($id)
            ->post()
            ->statusCode();
    }

    /**
     * @return mixed
     */
    private function postEmail()
    {
        return $this->sendGrid
            ->client
            ->contactdb()
            ->recipients()
            ->post([(object)['email' => $this->email]]);
    }
}
