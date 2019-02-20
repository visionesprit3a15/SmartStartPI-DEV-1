<?php
namespace MyBundle\Redirection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
/**
 * Created by PhpStorm.
 * User: Rusty
 * Date: 06/02/2018
 * Time: 20:41
 */
class LoginAfterRedirection implements AuthenticationSuccessHandlerInterface
{
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @return Response never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // Get list of roles for current user
        $roles = $token->getRoles();
        // Tranform this list in array
        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);
        // If is a Admin or super Admin we redirect to the backoffice area
        if (in_array('ROLE_ADMIN', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('admin'));
        // otherwise, if is a commercial user we redirect to the crm area
        elseif (in_array('ROLE_FREELANCER', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('home'));
        elseif (in_array('ROLE_ENTREPRISE', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('home'));
        // otherwise we redirect user to the member area
        else
            $redirection = new RedirectResponse($this->router->generate('fos_user_registration_register'));
        return $redirection;
    }
}