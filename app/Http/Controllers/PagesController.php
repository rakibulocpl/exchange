<?php


namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PressAndMedia;


class PagesController extends Controller
{
    public function privacy()
    {
        $page = Page::where('key','privacy')->first();
        return view('pages.privacy',compact('page'));
    }
    public function pagePublicView($key)
    {
        $page = Page::where('key',$key)->orderBy('id','desc')->first();
        return view('pages.pagePublicView',compact('page'));
    }

    public function pressAndMedia()
    {
        $allMedia = PressAndMedia::all();
        return view('pages.press-and-media',compact('allMedia'));
    }

    public function aboutUs()
    {
        $page = Page::where('key','about-us')->first();
        return view('pages.about-us',compact('page'));
    }
    public function termsConditions()
    {
        $page = Page::where('key','terms-conditions')->first();
        return view('pages.terms-conditions',compact('page'));
    }

    public function team()
    {
        $page = Page::where('key','team')->first();
        return view('pages.terms-conditions',compact('page'));
    }
    public function clients()
    {
        $page = Page::where('key','clients')->first();
        return view('pages.clients',compact('page'));
    }

    public function exchangePolicy()
    {
        $page = Page::where('key','exchange-policy')->first();
        return view('pages.exchange-policy',compact('page'));
    }

    public function career ()
    {
        $page = Page::where('key','career')->first();
        return view('pages.career',compact('page'));
    }
}
