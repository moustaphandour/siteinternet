<?php

namespace AppBundle\Controller\Frontend;

use BlogBundle\Entity\Repository\EventRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SidebarController extends Controller
{
	private $eventRepository;

    /**
     * Renders latest events
     *
     * @return array
     * @Route("", name="events_public_index")
     * 
     */
    public function indexAction()
    {
        $nextEvent = $this->getEventRepository()->getNextEvent();
        $pastEvents = $this->getEventRepository()->findAll();
        $futureEvents = $this->getEventRepository()->getFutureEvents(5);
        return $this->render('AppBundle:Frontend/Blog:blog_sidebar.html.twig', array(
            'nextEvent' => $nextEvent,
            'pastEvents' => $pastEvents,
            'futureEvents' => $futureEvents,
            'current' => 'events',
        ));
    }
    /**
     * Shows event requested
     *
     * @param integer $id
     * @return array
     * @Route("/ver/{id}/{slug}", name="events_public_show", requirements={"id"="\d+", "slug" = "[\w\d\-]+"}, defaults={ "slug" = "undefined" })
     * 
     */
    public function showAction($id, $slug)
    {
        $event = $this->getEventRepository()->find($id);
        return array(
            'event' => $event,
            'current' => 'events',
        );
    }
    /**
     * @return BlogBundle\Entity\EventRepository
     */
    private function getEventRepository()
    {
        $this->eventRepository = $this->getDoctrine()->getEntityManager()->getRepository('BlogBundle:Event');

        return $this->eventRepository;
    }
}