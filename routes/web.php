<?php

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/generate-sitemap', function () {
    $sitemap = Sitemap::create()
                        ->add(Url::create('/'))
                        ->add(Url::create('/home'))
                        ->add(Url::create('/about'));
    Post::all()->each(function (Post $post) use ($sitemap) {
        $sitemap->add(Url::create("/posts/{$post->slug}")
                ->setLastModificationDate($post->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8)
            );
    });
    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap generate successfully';
});
