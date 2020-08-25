<?php

namespace App\System\Classes\Core;

use App\System\Classes\HTTP\Response;
use App\System\Interfaces\Core\ErrorHandlerInterface;

use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class ErrorHandler implements ErrorHandlerInterface
{


    public function __construct()
    {
    }

    /**
     * @param RequestInterface $request
     * @param \Exception $e
     *
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request, \Exception $e): ResponseInterface
    {
        $response = new Response();
        $response->setContent("<h1>エラーが発生!</h1><p>{$e->getMessage()}</p>");
        return $response;
    }

    public function render404Page($e)
    {
        $this->_response->setStatusCode(404, 'Not Found');
        $message = $this->isDebugMode() ? $e->getMessage() : 'Page not Found';
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $this->_response->setContent(<<<EOF
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>page not found</title>
</head>
<body>
<h1>404</h1>
{$message}
</body>
</html>
EOF
        );

    }

    public function render500Page($e)
    {
        $this->_response->setStatusCode(500, 'Internal Server Error');
        $message = $this->isDebugMode() ? $e->getMessage() : 'Internal Server Error';
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $this->_response->setContent(<<<EOF
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Internal Server Error</title>
</head>
<body>
<h1>500</h1>
{$message}
</body>
</html>
EOF
        );
    }

}