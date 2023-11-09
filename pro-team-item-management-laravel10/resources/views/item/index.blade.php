@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

<!-- CSSファイルを追加 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <!-- 検索機能 -->
                <div class="card-body" style="width: 25%;">
                    <form method="GET" action="{{ route('items.index') }}">
                        <div class="form-group">
                            <div class="input-group" style="width: 75%;">
                                <input type="text" name="search" id="search" class="form-control" placeholder="商品名を入力">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">検索</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- 検索結果件数を表示 -->
                    @if (count($items) === 0)
                        <p>該当の商品は見つかりませんでした</p>
                    @else
                    <p>{{ count($items) }} 件の商品が見つかりました</p>
                    @endif
                </div>
                
                <!-- 商品登録ボタン -->
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <div class="input-group-append">
                            <a href="{{ url('items/add') }}" class="btn btn-success">商品登録</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
            <th><a href="{{ route('items.index', ['sort' => 'id', 'order' => 'asc']) }}">ID <i class="fas fa-arrow-up"></i></a></th>
            <th><a href="{{ route('items.index', ['sort' => 'name', 'order' => 'asc']) }}">名前 <i class="fas fa-arrow-up"></i></a></th>
            <th><a href="{{ route('items.index', ['sort' => 'type_id', 'order' => 'asc']) }}">種別 <i class="fas fa-arrow-up"></i></a></th>
            <th>詳細</th>
            <th>画像(クリックで拡大表示)</th>
            <th>操作</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->type->name }}</td>
                    <td>{{ $item->detail }}</td>

                    <!-- モーダル機能実装 -->
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" style="width: 25%; height: auto; border: none; background-color: #fff;" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}" >
                            @if ($item->image)
                                <a href="data:image/png;base64,{{ $item->image }}" data-lightbox="item-images">
                                    <img src="data:image/png;base64,{{ $item->image }}" style="width: auto; height: 75px; float:left;">
                                </a>
                            @endif
                        </button>
                    
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel{{ $item->id }}">プレビュー</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if ($item->image)
                                    <a href="data:image/png;base64,{{ $item->image }}" data-lightbox="item-images">
                                        <img src="data:image/png;base64,{{ $item->image }}" style="width: 100%;">
                                    </a>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    </td>

                    <td>
                        <!-- 編集ボタン -->
                        <a href="/items/edit/{{ $item->id }}" class="edit-button btn btn-primary">編集</a>

                        <!-- 削除ボタン -->
                        <form action="{{ url('items/delete') }}" method="post"
                            onsubmit="return confirm('削除します。よろしいですか？');">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="submit" value="削除" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
            <!-- csv出力 -->
            <div class="csv-area">
                <form action="/items/csv" method="get">

                    <button type="submit">CSV出力</button>
                </form>
            </div>
    </table>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
