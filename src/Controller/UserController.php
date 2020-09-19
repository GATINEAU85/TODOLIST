<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Task;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="user_list")
     */
    public function listAction()
    {
        return $this->render('user/list.html.twig', ['users' => $this->getDoctrine()->getRepository('App:User')->findAll()]);
    }

    /**
     * @Route("/users/create", name="user_create")
     */
    public function createAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/admin/users/{id}/edit", name="user_edit")
     */
    public function editAction(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
    
    /**
     * @Route("/admin/users/{id}/delete", name="user_delete")
     */
    public function deleteAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        if ($user == $this->getUser()){
            $tasks = $em->getRepository(Task::class)->findByUser($user);
            foreach ($tasks as $task){
                $em->remove($task);
            }
            $em->remove($user);     
            $session = $this->get('session');
            $session = new Session();
            $session->invalidate();        
            $em->flush();
        }
        
        $tasks = $em->getRepository(Task::class)->findByUser($user);
        foreach ($tasks as $task){
            $em->remove($task);
        }
        $em->remove($user);     
        $em->flush();
            
        $this->addFlash('success', 'This delete of this user is a success.');
        return $this->redirectToRoute('homepage');
    }
}
