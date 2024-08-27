<?php

namespace App\Livewire;

use Livewire\Component;

class Post extends Component
{

    public Post $post;
    public function construct($slug)
    {
        $post = Post::where('slug', $slug)->get();

        $this->post = $post;
    }
    public function render()
    {
        return view('livewire.post', compact('post'));
    }
}
