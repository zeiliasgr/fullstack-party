<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Issue;
use App\Entity\Label;
use App\Entity\Comment;
use \DateTime;

class IssueFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

    	$users = ['javierguiluz', 'bozerkins', 'bogdaniel', 'paolosore', 'edwardnorton', 'niklasvanhern'];
    	$titles = [
    		"[RFC] Deprecate the removal of 'Bundle' suffix in Twig paths",
    		"Application exit code not properly handled, when having fatal exceptions, Symfony 2.8, PHP7",
    		"Deprecate SYMFONY environment variables",
    		"Symfony Collection Type",
    		"Random fixture generation",
    		"Not leggaly binding DB insertion"
    	];
    	$comments = [
    		"This is a really lazy comment made by some lazy user.",
    		"This is a comment exactly to the point, really to it.",
    		"This is not a comment that you have gotten used to."
    	];


    	$labelTexts= ['RFC', 'Deprecation', 'Bug', 'Uncorfimed', 'Urgent', 'Fatal'];

    	$labels = [];

    	foreach ($labelTexts as $value) {
    		$label = new Label();
    		$label->setName($value);
    		$manager->persist($label);
    		$manager->flush();
    		$labels[] = $label;
    	}

    	$u = sizeof($users)-1; $t = sizeof($titles)-1;
    	$c = sizeof($comments)-1; $l = sizeof($labels)-1;

    	$maxIssues = 30; $commentDateOffset = 5;
    	$d = new DateTime();
    	$cd = (int)$d->format('d') -  $commentDateOffset; $cm = (int)$d->format('m');

    	foreach (range(0, $maxIssues) as $i ){
			$issue = new Issue();

	        $issue->setTitle($titles[rand(0, $t)]);
	        $issue->setStartedBy($users[rand(0, $u)]);
	        $d = '2018-'.rand(1, $cm).'-'.rand(1,$cd).' '.rand(0,23).':'.rand(0,59).':'.rand(0,59);
	        $issue->setDate(new DateTime($d));
	        $issue->setOpenStatus(rand(0, 1));

	        $label1 = rand(0, $l);
	        $issue->addLabels($labels[$label1]);

	        //Around 33% of issues will have two labels
	        if (rand(1, 3) <= 1){
	        	do{
	        		$label2 = rand(0, $l);
	        	}
	        	while($label2 == $label1); //But not the same

	        	$issue->addLabels($labels[$label2]);
	        }

	        $comment = new Comment();
	        $comment->setUser($issue->getStartedBy());
	        $comment->setDate($issue->getDate());
	        $comment->setBody($comments[rand(0, $c)]);

	        $issue->addComment($comment);

	        $moreComments = rand(0, 4);
	        $lastCommentDate = new DateTime($issue->getDate()->format('Y-m-d H:i:s')); //Now it is muttable

	        for($i=0; $i<$moreComments; $i++){
		        $newComment = new Comment();
		        $newComment->setUser($users[rand(0, $u)]);
		        $lastCommentDate = new DateTime($lastCommentDate->add(new \DateInterval('P'.rand(1, $commentDateOffset).'D'))->format('Y-m-d H:i:s'));
		        $newComment->setDate($lastCommentDate);
		        $newComment->setBody($comments[rand(0, $c)]);

		        $issue->addComment($newComment);
	        }

	        $manager->persist($issue);
	    }

        $manager->flush();
    }
}
