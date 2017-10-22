<?php

namespace Svi\Service;

use Svi\Application;
use Svi\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpService
{
    private $app;
    private $request;
    private $response;
    private $route;
    private $before = [];
    private $after = [];
    private $finish = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function run()
    {
        $this->request = Request::createFromGlobals();
        $this->route = $this->app->getRoutingService()->dispatchUrl(explode('?', $this->request->getRequestUri())[0]);

        foreach ($this->before as $before) {
            if ($this->response = $before($this->request, $this->route)) {
                break;
            }
        }

        if (!$this->response && $this->route) {
            $controller = new $this->route['controller']($this->app);
            $this->response = call_user_func_array([$controller, $this->route['method']], array_merge($this->route['args'], [$this->request]));
        }

        if (!$this->response) {
            throw new NotFoundHttpException();
        }

        if (!($this->response instanceof Response)) {
            $this->response = new Response($this->response);
        }

        $this->response->prepare($this->request);

        foreach ($this->after as $after) {
            if ($result = $after($this->request, $this->response)) {
                if (!($result instanceof Response)) {
                    $this->response = new Response($result);
                }
                $this->response = $result;
                $this->response->prepare($this->request);
            }
        }

        $this->response->send();

        foreach ($this->finish as $finish) {
            $finish($this->request, $this->response);
        }
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getRoute()
    {
        return $this->route;
    }

    public function before($callback)
    {
        $this->before[] = $callback;
    }

    public function after($callback)
    {
        $this->after[] = $callback;
    }

    public function finish($callback)
    {
        $this->finish[] = $callback;
    }

}