<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Tag;
use Spatie\Sitemap\Tags\Url;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }

    function generateSitemap()
    {
        $sitemap = Sitemap::create();
        // Add static URLs
        $date = Carbon::now();
        $sitemap->add(
            Url::create('/')
            ->setLastModificationDate($date)
            ->setPriority(1.0)
        );
    
        $sitemap->add(
            Url::create('/about')
                ->setPriority(0.8)
                ->setChangeFrequency($date)
        );
    
        // Add dynamic URLs for posts
        $posts = Post::all();
        foreach($posts as $post) {
            $sitemap->add(
                Url::create("/posts/{$post->slug}")
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.8)
            );
        }
    
        // Render the sitemap as a string
    $sitemapContent = $sitemap->render();

    // Load into DOMDocument for formatting
    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($sitemapContent);

    // Save the formatted sitemap
    $dom->save(public_path('sitemap.xml'));
    
        return 'Sitemap created successfully!';
    }
}
