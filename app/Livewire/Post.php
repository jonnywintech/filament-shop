<?php

namespace App\Livewire;

use App\Models\Post as PostModel;
use Livewire\Component;

class Post extends Component
{

    public PostModel $post;

    public function mount(string $slug)
    {
        $post = PostModel::where('slug', $slug)->first();

        $this->post = $post;
    }
    public function render()
    {
        return view('livewire.post', ['post' => $this->post]);
    }
}
