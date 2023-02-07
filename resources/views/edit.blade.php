@extends('layouts.app')

@section('content')
<h4>商品詳細</h4>
<form action="{{ route('item.update', $item->id) }}" method="post">
    @method('patch')
    @csrf
    <div class="form-group">
        名前
        <input class="form-control" type="text" name="name" value="{{$item->name}}">
    </div>
    <div class="form-group">
        種別
        <input class="form-control" type="text" name="type" value="{{$item->type}}" placeholder="数字４桁以内">
    </div>
    <div class="form-group">
        詳細
        <input class="form-control" type="text" name="detail" value="{{$item->detail}}">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-secondary">編集</button>
    </div>

</form>
<form action="{{ route('item.destroy', $item->id )}}" method="post">
    @method('delete')
    @csrf
    <button type="submit" class="btn btn-secondary">削除</button>
</form>
@endsection