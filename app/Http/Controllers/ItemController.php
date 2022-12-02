<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index(Request $request)
    {
        //検索で入力された値を取得
        $keyword = $request->input('keyword');
        //ソート機能追加
        $sortBy = $request->input('sort');
        $direction = $request->input('direction');
        // 商品一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select()
            ->get();
        $query = Item::query();

        if(!empty($keyword)) {
            $query->where('name','Like','%'.$keyword.'%')
            ->orWhere('detail','Like','%'.$keyword.'%');
        }
        //もしソートのデータが送信されたら
        if(!empty($sortBy)){
            $orderBy = $direction ? $direction : 'asc';
            $query->orderBy($sortBy,$orderBy );
        }

        $items = $query->paginate(10);
        return view('item.index', compact('items','keyword'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }
}
