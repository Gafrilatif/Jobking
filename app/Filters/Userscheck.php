<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Userscheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = service('uri');
        if($uri->getSegment(1) == 'users'){
            if($uri->getSegment(2) == '')
                $segment = '/login';
            else
                $segment = '/'.$uri->getSegment(2);

            return redirect()->to(base_url($segment));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}