<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sunra\PhpSimple\HtmlDomParser;

class ParserController extends Controller
{
    const BUDDYSCHOOL_HOST = 'https://buddyschool.com';

    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('parser/index.html.twig');
    }

    /**
     * @Route("/profile", name="profile")
     * @param Request $request
     * @return Response
     */
    public function searchProfile(Request $request)
    {
        $dom = HtmlDomParser::file_get_html(self::BUDDYSCHOOL_HOST . '/search?keyword=' .
            urlencode($request->query->get('keyword')), false, null, 0);
        $firstSearchResult = $dom->find('div[class=profileMainTitle]', 0);

        if ($firstSearchResult) {
            $profileUrl = $firstSearchResult->children(0)->href;

            $dom = HtmlDomParser::file_get_html(self::BUDDYSCHOOL_HOST . $profileUrl, false, null, 0);
            $dom->save('profile.txt');

            return new Response(
                'Profile has saved', Response::HTTP_OK
            );
        }

        return new Response(
            'Profile not found', Response::HTTP_NOT_FOUND
        );
    }
}
