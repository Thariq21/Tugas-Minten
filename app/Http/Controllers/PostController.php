<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('administrator.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:posts,judul',
            'excerpt' => 'nullable|string',
            'body' => 'required',
            'kategori' => 'nullable|integer',
            'bigimage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'figcaption' => 'required|string|max:255'
        ]);

        // Generate slug
        $slug = Post::generateSlug($validated['judul']);

        // Handle Image Upload
        $bigImageName = null;
        $thumbImageName = null;

        if ($request->hasFile('bigimage')) {
            $image = $request->file('bigimage');
            $bigImageName = time() . '_big_' . Str::slug($validated['judul']) . '.' . $image->getClientOriginalExtension();
            $thumbImageName = time() . '_thumb_' . Str::slug($validated['judul']) . '.' . $image->getClientOriginalExtension();
            
            // Simpan gambar besar
            $image->move(public_path('storage/images'), $bigImageName);
            
            // Buat thumbnail (resize ke 300x300 misalnya)
            // Jika menggunakan Intervention Image:
            // Image::make(public_path('storage/images/' . $bigImageName))
            //     ->fit(300, 300)
            //     ->save(public_path('storage/images/' . $thumbImageName));
            
            // Atau copy saja untuk sementara jika tidak pakai Intervention Image
            copy(
                public_path('storage/images/' . $bigImageName),
                public_path('storage/images/' . $thumbImageName)
            );
        }

        // Create post
        Post::create([
            'user_id' => Auth::id(),
            'judul' => $validated['judul'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'body' => $request->body,
            'kategori' => $validated['kategori'],
            'bigimage' => $bigImageName,
            'thumbimage' => $thumbImageName,
            'figcaption' => $validated['figcaption']
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('administrator.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('administrator.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:posts,judul,' . $post->id,
            'excerpt' => 'nullable|string',
            'body' => 'required',
            'kategori' => 'nullable|integer',
            'bigimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'figcaption' => 'required|string|max:255'
        ]);

        // Generate slug jika judul berubah
        $slug = ($post->judul != $validated['judul']) 
            ? Post::generateSlug($validated['judul']) 
            : $post->slug;

        // Handle Image Upload jika ada gambar baru
        $bigImageName = $post->bigimage;
        $thumbImageName = $post->thumbimage;

        if ($request->hasFile('bigimage')) {
            // Hapus gambar lama
            if ($post->bigimage && file_exists(public_path('storage/images/' . $post->bigimage))) {
                unlink(public_path('storage/images/' . $post->bigimage));
            }
            if ($post->thumbimage && file_exists(public_path('storage/images/' . $post->thumbimage))) {
                unlink(public_path('storage/images/' . $post->thumbimage));
            }

            // Upload gambar baru
            $image = $request->file('bigimage');
            $bigImageName = time() . '_big_' . Str::slug($validated['judul']) . '.' . $image->getClientOriginalExtension();
            $thumbImageName = time() . '_thumb_' . Str::slug($validated['judul']) . '.' . $image->getClientOriginalExtension();
            
            $image->move(public_path('storage/images'), $bigImageName);
            
            copy(
                public_path('storage/images/' . $bigImageName),
                public_path('storage/images/' . $thumbImageName)
            );
        }

        // Update post
        $post->update([
            'judul' => $validated['judul'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'body' => $request->body,
            'kategori' => $validated['kategori'],
            'bigimage' => $bigImageName,
            'thumbimage' => $thumbImageName,
            'figcaption' => $validated['figcaption']
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Hapus gambar
        if ($post->bigimage && file_exists(public_path('storage/images/' . $post->bigimage))) {
            unlink(public_path('storage/images/' . $post->bigimage));
        }
        if ($post->thumbimage && file_exists(public_path('storage/images/' . $post->thumbimage))) {
            unlink(public_path('storage/images/' . $post->thumbimage));
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}