<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests\Front\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Folder;
use App\Models\Post;
use App\Providers\PostsServiceProvider;
use App\Traits\ManageControllerTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class ProductsController extends Controller
{
    use ManageControllerTrait;

    private $productPrefix = 'pd-';

    public function index()
    {
        $categories = Folder::where('posttype_id', 2)
            ->where([
                'locale' => getLocale(),
                ['slug', '<>', 'no']
            ])
            ->orderBy('title', 'asc')
            ->get();

        return view('front.products.folders.0', compact('categories'));
    }

    public function products($lang, $folderSlug, $categorySlug = null)
    {
        $folder = Folder::where(['slug' => $folderSlug, 'locale' => getLocale()])->first();
        if (!$folder) {
            $this->abort(410);
        }
        $folder->spreadMeta();

        $selectorData = [
            'type'         => 'products',
            'is_base_page' => true,
            'folder'       => $folder->slug,
        ];

        $ogData = [
            'description' => $folder->title,
        ];

        if ($folder->image) {
            $ogData['image'] = url($folder->image);
        }

        $breadCrumb = [
            [trans('front.home'), url_locale('')],
            [trans('front.products'), url_locale('products')],
            [$folder->title, url_locale('products/' . $folder->slug)],
        ];

        if ($categorySlug) {
            $category = Category::findBySlug($categorySlug);
            if (!$category->exists) {
                $this->abort(410);
            }
            if (!$folder->is($category->folder)) {
                $this->abort(410);
            }
            $breadCrumb[] = [$category->title, url_locale('products/' . $folder->slug . '/' . $category->slug)];
            $selectorData['category'] = $category->slug;
            $ogData['description'] .= ' - ' . $category->title;
        }

        $productsListHTML = PostsServiceProvider::showList($selectorData);

        return view('front.products.products.0', compact('productsListHTML', 'breadCrumb', 'ogData'));

    }

    public function showProduct($lang, $identifier)
    {
        $identifier = substr($identifier, strlen($this->productPrefix));

        $dehashed = hashid_decrypt($identifier, 'ids');
        if (is_array($dehashed) and is_numeric($identifier = $dehashed[0])) {
            $field = 'id';
        } else {
            $field = 'slug';
        }
        $product = Post::where([
            $field => $identifier,
            'type' => 'products'
        ])->first();

        if (!$product) {
            $this->abort(410);
        }
        $product->spreadMeta();

        $breadCrumb = [
            [trans('front.home'), url_locale('')],
            [trans('front.products'), url_locale('products')],
        ];

        $categories = $product->categories;
        if ($categories->count()) {
            $firstCat = $categories->first();
            $breadCrumb[] = [$firstCat->title, url_locale('products/' . $firstCat->folder->slug . '/' . $firstCat->slug)];
        }
        $breadCrumb[] = [$product->title, url_locale('products/' . $this->productPrefix . ($product->slug ? $product->slug : $product->id))];

        $ogData = [
            'title' => $product->title,
        ];

        if ($product->viewable_featured_image) {
            $ogData['image'] = url($product->viewable_featured_image);
        }
        if ($product->abstract) {
            $ogData['description'] = $product->abstract;
        }

        $postHTML = PostsServiceProvider::showPost($product);

        return view('front.products.single.0', compact('postHTML', 'breadCrumb', 'ogData'));
    }

    public function ajaxFilter(Request $request)
    {
        $hash = $request->hash;
        $hashArray = [];
        $selectorData = [
            'type'          => 'products',
            'show_filter'   => false,
            'ajax_request'  => true,
            'paginate_hash' => $hash,
            'paginate_url'  => URL::previous(),
            'max_per_page'  => 2,
        ];

        $referrer = URL::previous();
        $prefix = url_locale('products');
        $prefixLength = strlen($prefix);
        if ((substr($referrer, 0, $prefixLength) == $prefix)) {
            $importantUrl = substr($referrer, $prefixLength);
            $parametersParts = explodeNotEmpty('/', $importantUrl);
            $folderSlug = $parametersParts[0];
            $categorySlug = array_key_exists(1, $parametersParts) ? $parametersParts[1] : null;

            $folder = Folder::where(['slug' => $folderSlug, 'locale' => getLocale()])->first();
            if (!$folder) {
                return redirect($referrer);
            }
            $selectorData['folder'] = $folder->slug;

            if ($categorySlug) {
                $category = Category::findBySlug($categorySlug);
                if (!$category->exists or !$folder->is($category->folder)) {
                    return redirect($referrer);
                }
                $selectorData['category'] = $category->slug;
            } else {
                $selectorData['category'] = $folder->slug;
            }

            $hash = explodeNotEmpty('!', $hash);
            foreach ($hash as $field) {
                $field = explodeNotEmpty('?', $field);
                if (count($field) == 2) {
                    $hashArray[$field[1]] = explodeNotEmpty('/', $field[0]);
                    $currentGroup = &$hashArray[$field[1]];
                    $currentGroup = arrayPrefixToIndex('_', $currentGroup);
                }
            }


            if (isset($hashArray['text'])) {
                foreach ($hashArray['text'] as $field => $value) {
                    switch ($field) {
                        case 'title':
                            $selectorData['search'] = $value;
                            break;
                    }
                }
            }

            if (isset($hashArray['range'])) {
                foreach ($hashArray['range'] as $field => $value) {
                    switch ($field) {
                        case 'price':
                            if (isset($value['min']) and isset($value['max']) and $value['min'] and $value['max']) {
                                $selectorData['conditions'][] = ['sale_price', '>=', $value['min']];
                                $selectorData['conditions'][] = ['sale_price', '<=', $value['max']];
                            }
                            break;
                    }
                }
            }

            if (isset($hashArray['checkbox'])) {
                foreach ($hashArray['checkbox'] as $field => $value) {
                    switch ($field) {
                        case 'category':
                            if (is_array($value)) {
                                $noCatIndex = array_search('', $value);
                                if ($noCatIndex !== false) {
                                    $value[$noCatIndex] = 'no';
                                }
                                $selectorData['category'] = $value;
                            }
                            break;
                    }
                }
            }

            if (isset($hashArray['switchKey'])) {
                foreach ($hashArray['switchKey'] as $field => $value) {
                    if ($value) {
                        switch ($field) {
                            case 'available':
                                $selectorData['conditions'][] = ['is_available', true];
                                break;
                            case 'special-sale':
                                // @TODO: next line will work when "sale_price" is defined as a column in "posts" table
                                $selectorData['conditions'][] = ['sale_price', '!=', '0'];
                                $selectorData['conditions'][] = ['price', '!=', 'sale_price'];
                                break;
                        }
                    }
                }
            }

            if (isset($hashArray['pagination'])) {
                foreach ($hashArray['pagination'] as $field => $value) {
                    if ($value) {
                        switch ($field) {
                            case 'page':
                                $selectorData['paginate_current'] = $value;
                                break;
                        }
                    }
                }
            }

            if (isset($hashArray['sort'])) {
                foreach ($hashArray['sort'] as $field => $value) {
                    if ($value) {
                        switch ($field) {
                            case 'price': // accepted sort fields
                                $selectorData['sort'] = $value;
                                $selectorData['sort_by'] = $field;
                                break;
                        }
                    }
                }
            }

            return PostsServiceProvider::showList($selectorData);
        }
    }

}
