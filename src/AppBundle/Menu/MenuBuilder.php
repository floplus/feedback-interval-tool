<?php
/**
 *
 *
 * @category
 * @package  Hmmh_
 * @author   Florian Beyerlein <florian.beyerlein@hmmh.de>
 */
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    private $factory;
    private $tokenStorage;

    /**
     * Adding main menu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem(
            'main.root',
            ['childrenAttributes' => ['class' => 'nav bs-docs-sidenav']]
        );

        $menu->addChild('Home', array('route' => 'homepage'));
        $menu->addChild('Employees', array('route' => 'employee_index'));

        return $menu;
    }

    /**
     * Adding user menu.
     *
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem(
            'user.root',

            ['childrenAttributes' => ['class' => 'nav bs-docs-sidenav']]
        );

        if ($this->container->get('security.token_storage')->getToken() instanceof AnonymousToken) {
            $menu->addChild('Login', ['route' => 'fos_user_security_login']);
        } else {
            $menu->addChild('Logout', ['route' => 'fos_user_security_logout']);
        }

        return $menu;
    }
}
