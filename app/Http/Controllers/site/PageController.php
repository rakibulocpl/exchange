<?php

namespace App\Http\Controllers\site;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PageController
{
    // Define available page types as a class constant for reuse
    const PAGE_TYPES = [
        '' => 'Select one',
        'media' => 'Press And Media',
        'privacy' => 'Privacy',
        'about-us' => 'About Us',
        'team' => 'Team',
        'career' => 'Career',
        'clients' => 'Clients',
        'terms-conditions' => 'Terms Conditions',
        'exchange-policy' => 'Exchange Policy',
        'returnPolity' => 'Return Policy',
        'refundPolity' => 'Refund Policy',
        'afterSale' => 'After-Sale Support',
        'replacement' => 'Replacement Warranty',
        'shippingDelivery' => 'Shipping & Delivery',
    ];

    // Display the list of pages
    public function index()
    {
        $pages = Page::all();
        $pageTypes = self::PAGE_TYPES;
        return view('pageAdmin.list', compact('pages','pageTypes'));
    }

    // Show the form to add a new page
    public function add()
    {
        $pages = self::PAGE_TYPES;
        return view('pageAdmin.add', compact('pages'));
    }

    // Store a new or existing page
    public function store(Request $request)
    {
        $pageId = $request->get('page_id');
        $page = $pageId ? Page::find($pageId) : new Page();

        $page->key = $request->get('key');
        $page->page_details = $request->get('page_details');
        $page->meta_title = $request->get('meta_title');
        $page->meta_description = $request->get('meta_description');
        $page->status = 1;

        $page->save();

        Session::flash('success', $pageId ? "Page updated successfully" : "Page added successfully");
        return redirect()->route('page.list');
    }

    // Show the form to edit an existing page
    public function edit($id)
    {
        $page = Page::findOrFail($id); // Use findOrFail for better error handling
        $pages = self::PAGE_TYPES;

        return view('pageAdmin.edit', compact('page', 'pages'));
    }

    // Soft delete a page
    public function delete($id)
    {
        $page = Page::withTrashed()->find($id);

        if ($page) {
            $page->delete();
            Session::flash('success', "Page deleted successfully");
        } else {
            Session::flash('error', "Page not found");
        }

        return redirect()->route('page.list');
    }
}
