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

    /**
     * Show the form for editing the specified resource.
     *指定されたリソースを編集するためのフォームを表示します
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($item_id)
    {
        // 一覧から限定されたIDと同じIDのレコードを取得する。
        $item = Item::where('id' , '=' , $item_id)->first();
        return view('edit')->with([
                'item' => $item
            ]);
    }

    /**
     * Update the specified resource in storage.
     *ストレージ内の指定されたリソースを更新します。
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$item_id)
    {
        // 既存のレコードを習得して、編集してから保存する
        $items = Item::where('id' , '=' , $item_id)->first();
        $items->name = $request->name;
        $items->type = $request->type;
        $items->detail = $request->detail;
        $items->save();

        return redirect()->route('item.index');
    }

    /**
     * Remove the specified resource from storage.
     *指定されたリソースをストレージから削除します。
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($item_id)
    {
        // 既存のレコードを習得して、削除する
        $item = Item::where('id' , '=' , $item_id)->first();
        $item->delete();
        return redirect()->route('item.index');
    }
}
