<?php
namespace FruitsBundle\Controller;

use FruitsBundle\Form\UserType;
use FruitsBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends Controller
{
    public function registerAction(Request $request)
    {
        // Get data and decode JSON
        $data = json_decode(json_encode($request->request->all()), true);

        // Create new album entity
        $user = new User();

        $user->setUsername($data['username']);
        $user->setEmail($data['email']);

        // Encode the password
        $password = $this->get('security.password_encoder')
            ->encodePassword($user, $data['password']);
        $user->setPassword($password);

        // Send to database
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        // Return as JSON
        $serializer = $this->get('serializer');
        $response = $serializer->serialize($data, 'json');
        return new JsonResponse(json_decode($response));

    }

    public function loginAction(Request $request)
    {
        // Get data and decode JSON
        $data = json_decode(json_encode($request->request->all()), true);

        if ($data) {
            $username = ($data['username']);
            $plainPassword = ($data['password']);

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('FruitsBundle:User')->findOneBy(array('username' => $username));


            if (!$user) {
                $error = "User not found";
                $serializer = $this->get('serializer');
                $response = $serializer->serialize($error, 'json');
                return new JsonResponse(json_decode($response));

            } else {
                $encoder = $this->container->get('security.password_encoder');
                $validPassword = $encoder->isPasswordValid(
                    $user, // the user
                    $plainPassword // the submitted password
                );

                if ($validPassword) {
                    $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
                    $this->get('security.token_storage')->setToken($token);
                    $event = new InteractiveLoginEvent($request, $token);
                    $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

                    // Return as JSON
                    $serializer = $this->get('serializer');
                    $response = $serializer->serialize($user, 'json');
                    return new JsonResponse(json_decode($response));

                } else {
                    $error = "Bad Password";
                    $serializer = $this->get('serializer');
                    $response = $serializer->serialize($error, 'json');
                    return new JsonResponse(json_decode($response));
                }
            }

        } else {
            // No data
        }
    }
}
