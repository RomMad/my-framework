<?php

namespace App\Controller;

use App\Utils\Calendar;
use App\Utils\LeapYear;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController
{
    public function about()
    {
        ob_start();
        include __DIR__.'/../pages/cms/about.php';

        return new Response(ob_get_clean(), 200);
    }

    public function leapYear(Request $request)
    {
        $calendar = new Calendar();

        $msg = $calendar->isLeapYear($request->attributes->get('year')) ? 'Yep, this is a leap year!' : 'Nope, this is not a leap year.';

        $request->attributes->set('msg', $msg);

        return renderTemplate($request);
    }
}
