<?php

namespace PhotosBundle\Controller;

use PhotosBundle\Entity\Photo;
use PhotosBundle\Form\PhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Photo controller.
 *
 * @Route("photo")
 */
class PhotoController extends Controller
{
    /**
     * Lists all photo entities.
     *
     * @Route("/", name="photo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('PhotosBundle:Photo')->findAll();

        return $this->render('photo/index.html.twig', array(
            'photos' => $photos,
        ));
    }

    /**
     * Creates a new photo entity.
     *
     * @Route("/new", name="photo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->createForm('PhotosBundle\Form\PhotoType', $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $photoPath = $photo->getPhotoPath();

          $photoPathName = md5(uniqid()).'.'.$photoPath->guessExtension();

          $photoPath->move(
            $this->getParameter('photosPath_directory'),$photoPathName
          );

            $photo->setPhotoPath($photoPathName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush($photo);

            return $this->redirectToRoute('photo_show', array('id' => $photo->getId()));
        }

        return $this->render('photo/new.html.twig', array(
            'photo' => $photo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a photo entity.
     *
     * @Route("/{id}", name="photo_show")
     * @Method("GET")
     */
    public function showAction(Photo $photo)
    {
        $deleteForm = $this->createDeleteForm($photo);

        return $this->render('photo/show.html.twig', array(
            'photo' => $photo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing photo entity.
     *
     * @Route("/{id}/edit", name="photo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Photo $photo)
    {
        $deleteForm = $this->createDeleteForm($photo);
        $editForm = $this->createForm('PhotosBundle\Form\PhotoType', $photo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('photo_edit', array('id' => $photo->getId()));
        }

        return $this->render('photo/edit.html.twig', array(
            'photo' => $photo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a photo entity.
     *
     * @Route("/{id}", name="photo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Photo $photo)
    {
        $form = $this->createDeleteForm($photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($photo);
            $em->flush($photo);
        }

        return $this->redirectToRoute('photo_index');
    }

    /**
     * Creates a form to delete a photo entity.
     *
     * @param Photo $photo The photo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Photo $photo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('photo_delete', array('id' => $photo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
