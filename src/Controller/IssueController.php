<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Issue;

class IssueController extends AbstractController
{
    /**
     * @Route("/issues", name="issues")
     */
    public function index(Request $req)
    {
    	$page = $req->query->get('page');

    	if($page == NULL)
    		$page = 1;

    	$repo = $this->getDoctrine()->getRepository(Issue::class);

    	$limit = ($page - 1) * 10;
    	$offset = 10;

    	$issues = $repo->findBy([], $limit);
    	//$list = $this->getDoctrine()->getReposi
        return $this->render('issue/index.html.twig', [
            'controller_name' => 'IssueController',
            'page' => $page
        ]);
    }
}
