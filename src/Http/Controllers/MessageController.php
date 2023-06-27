<?php

namespace App\Http\Controllers;

use App\Clients\BotClient;
use App\Model\Repository\MessageRepository;
use App\Model\Validators\MessageValidator;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;
use Exception;

class MessageController
{
    private MessageRepository $messageRepo;
    private BotClient $botClient;
    private MessageValidator $messageValidator;

    public function __construct()
    {
        $this->messageRepo = new MessageRepository();
        $this->botClient = new BotClient();
        $this->messageValidator = new MessageValidator();
    }

    public function index(ServerRequest $request, Response $response)
    {
        $messages = $this->messageRepo->getAll();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'messages/index.twig', ['messages' => $messages]);
    }

    public function newMessage(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'messages/messages.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
        try {
            $data = $request->getParsedBodyParam('message', []);

            $errors = $this->messageValidator->validate($data);

            if (!empty($errors)) {
                $view = Twig::fromRequest($response);
                return $view->render($response, 'messages/messages.twig', [
                    'data' => $data,
                    'errors' => $errors,
                ]);
            }

            $sendMessage = $this->botClient->sendMessage($data['text']);

            $this->messageRepo->create($data);

            return $response->withRedirect('/messages');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function read(ServerRequest $request, Response $response, array $data)
    {
        $id = $data['id'];
        $message = $this->messageRepo->read($id);
        $view = Twig::fromRequest($request);

        return $view->render($response, 'messages/read.twig', ['message' => $message]);
    }
}
