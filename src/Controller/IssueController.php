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

    	$open = $repo->openIssues();
    	$closed = $repo->closedIssues();

    	$limit = 4;
    	$offset = ($page - 1) * $limit;
    	
    	$issues = $repo->findBy([], ['date' => 'DESC'], $limit, $offset);

    	//$list = $this->getDoctrine()->getReposi
        return $this->render('issue/index.html.twig', [
            'issues' => $issues,
            'open' => $open,
            'closed' => $closed,
            'page' => $page
        ]);
    }

    /**
     * @Route("/issue/{id}/ ", name="issue")
     */
    public function view($id){
    	$issue = $this->getDoctrine()->getRepository(Issue::class)->find($id);

    	if(!$issue){
		    throw $this->createNotFoundException('No product found for id '.$id);
    	}

        return $this->render('issue/view.html.twig', [
            'issue' => $issue
        ]);

    }
}
