<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Halaman Home - Menampilkan daftar artikel terbaru
     */
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(3);

        return view('website.index', compact('posts'));
    }

    /**
     * Halaman Detail Artikel berdasarkan slug
     */
    public function detailartikel($slug)
    {
        $post = Post::with('user')
            ->where('slug', $slug)
            ->firstOrFail();

        // Artikel terkait (opsional)
        $relatedPosts = Post::where('kategori', $post->kategori)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('website.detail', compact('post', 'relatedPosts'));
    }
}   