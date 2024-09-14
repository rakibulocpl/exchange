<?php

namespace App\Http\Controllers\site;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PageController
{

    public  function index(){
        $pages =  Page::all();
        return view('pageAdmin.list',compact('pages'));
    }

    public function add(){
        $pages = [
            ''=>'Select one',
            'media'=>'Press And Media',
            'privacy'=>'Privacy',
            'about-us'=>'About Us',
            'team'=>'Team',
            'clients'=>'Clients',
            'terms-conditions'=>'Terms Conditions',
            'exchange-policy'=>'Exchange Policy',
        ];
        return view('pageAdmin.add',compact('pages','pages'));
    }

    public function store(Request $request){
        $pageId= $request->get('page_id');
        if(!empty($pageId)){
            $page =  Page::find($pageId);
        }else{
            $page =  new Page();
        }
//dd($request->all());
        $page->key = $request->get('key');
        $page->page_details = $request->get('page_details');
        $page->meta_title = $request->get('meta_title');
        $page->meta_description = $request->get('meta_description');
        $page->status = 1;
//        dd($page);
        $page->save();
        Session::flash('success', "Page addend Successfully");
        return redirect()->route('page.list');
    }

    public function edit($id){
        $page =  Page::find($id);

        $pages = [
            ''=>'Select one',
            'media'=>'Press And Media',
            'privacy'=>'Privacy',
            'about-us'=>'About Us',
            'team'=>'Team',
            'clients'=>'Clients',
            'terms-conditions'=>'Terms Conditions',
            'exchange-policy'=>'Exchange Policy',
        ];
        return view('pageAdmin.edit',compact('page','pages'));
    }

    public function delete($id){
        $page =  Page::withTrashed()->find($id);
        if($page){
            $page->delete();
            Session::flash('success', "Page deleted successfully");
        }else{
            Session::flash('error', "Page not found !!");
        }
        return redirect()->route('page.list');
    }

}