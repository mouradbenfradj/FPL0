<?php

namespace ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('FrontendBundle:News')->findAll();
        $articles = $em->getRepository('ArticleBundle:Article')->findAll();
        $articles = array_reverse($articles);
        $news = array_reverse($news);
        $teams = $em->getRepository('FrontendBundle:Team')->findAll();
        $teams = array_reverse($teams);
        if ($request->get('categorie') and $request->get('categorie') == 6) {
            $injurys = $em->getRepository('FrontendBundle:InjuryUpdates')->findAll();
            $injurys = array_reverse($injurys);
            return $this->render('ArticleBundle:Default:articleByCategorie.html.twig', array('injurys' => $injurys, 'news' => $news, 'articles' => $articles));
        } elseif ($request->get('categorie') and $request->get('categorie') == 7) {
            $csOdds = $em->getRepository('FrontendBundle:CsOdds')->findAll();
            $csOdds = array_reverse($csOdds);
            return $this->render('ArticleBundle:Default:articleByCategorie.html.twig', array('csOdds' => $csOdds, 'news' => $news, 'articles' => $articles));
        } elseif ($request->get('categorie')) {
            return $this->render('ArticleBundle:Default:articleByCategorie.html.twig', array('news' => $news, 'articles' => $articles));
        }
        return $this->render('ArticleBundle:Default:index.html.twig', array('news' => $news, 'articles' => $articles, 'teams' => $teams,
        ));

    }
}
