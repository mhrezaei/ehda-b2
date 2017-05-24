<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use App\Models\Folder;
use App\Models\Post;
use App\Models\Receipt;
use App\Models\Test\Meta;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Test\Post as PostOld;


class TestController extends Controller
{
    public function postsConverter()
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            if ($post->meta('text') or $post->meta('abstract')) {
                $post->text = $post->meta('text');
                $post->abstract = $post->meta('abstract');
                $post->starts_at = $post->meta('start_time');
                $post->ends_at = $post->meta('end_time');
                $post->updateMeta([
                    'text'     => false,
                    'abstract' => false,
                ]);
                $post->save();
            }
        }

        return "DONE :D";
    }

    public function index()
    {
        $array = [687, 29, 42, 60, 1384, 1097, 88, 59, 724];
        Receipt::whereIn('user_id', $array)->delete();
        User::cacheRefreshAll();
        return ":)";
    }

    public function states()
    {
        $states = [
            'alborz',
            'ardabil',
            'azerbaijan-east',
            'azerbaijan-west',
            'bushehr',
            'chahar-mahaal-bakhtiari',
            'fars',
            'gilan',
            'golestan',
            'hamedan',
            'hormozgan',
            'ilam',
            'isfahan',
            'kerman',
            'kermanshah',
            'khorasan-north',
            'khorasan-razavi',
            'khorasan-south',
            'khuzestan',
            'kohgiluyeh-boyer-ahmad',
            'kurdistan',
            'lorestan',
            'markazi',
            'mazandaran',
            'qazvin',
            'qom',
            'semnan',
            'sistan-baluchestan',
            'tehran',
            'yazd',
            'zanjan',
        ];
        $enabledStates = [
            'alborz',
            'ardabil',
            'azerbaijan-east',
            'azerbaijan-west',
            'bushehr',
            'chahar-mahaal-bakhtiari',
            'fars',
            'gilan',
            'golestan',
            'hamedan',
            'ilam',
            'isfahan',
            'kerman',
            'kermanshah',
            'khorasan-north',
            'khorasan-razavi',
            'khorasan-south',
            'khuzestan',
            'kohgiluyeh-boyer-ahmad',
            'lorestan',
            'markazi',
            'mazandaran',
            'semnan',
            'sistan-baluchestan',
            'tehran',
            'yazd',
            'zanjan',
        ];
        foreach ($states as $key => $state) {
            $states[$key] = [
                'name'   => $state,
                'active' => (in_array($state, $enabledStates)) ? true : false,
                'link'   => 'https://' . $state . '.ehda.center',
            ];
        }

        return view('front.iranmap.main', compact('states'));
    }

    public function gallery_archive()
    {
        return view('front.gallery.archive.main');
    }
}
