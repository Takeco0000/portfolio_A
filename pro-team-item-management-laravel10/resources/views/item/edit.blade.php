@extends('adminlte::page')

@section('title', '商品情報編集')

@section('content_header')
<h1>商品情報編集</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-primary">
            <form method="POST" action="{{ url('items/update', ['id' => $item->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">商品名</label>
                        <input type="text" name="name" id="name" value="{{ $item->name }}" class="form-control" placeholder="商品名">
                    </div>
                    <div class="form-group">
                        <label for="type_id">種別</label>
                        <select name="type_id" id="type_id" class="form-control">
                            @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ $item->type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="detail">詳細</label>
                        <textarea name="detail" id="detail" class="form-control" placeholder="詳細説明">{{ $item->detail }}</textarea>
                    </div>
                    <!-- 写真表示 -->
                    <div class="form-group">
                        <!-- 画像表示&クリックして拡大表示機能 -->
                        <!-- Lightbox CSS -->
                        <link href="{{ asset('css/lightbox.min.css') }}" rel="stylesheet">
                        <!-- Lightbox JavaScript -->
                        <script src="{{ asset('js/lightbox.min.js') }}"></script>
                        @if ($item->image)
                        <td>
                            <a href="data:image/png;base64,{{ $item->image }}" data-lightbox="item-images">
                                <img src="data:image/png;base64,{{ $item->image }}" style="width: 40%;">
                            </a>
                        </td>
                        @endif
                    </div>
                    <!-- 写真選択 -->
                    <div class="form-group" style="padding-top: 15px;">
                        <label for="image">画像</label>
                        <br>
                        <input type="file" name="image" id="image">
                        <p style="font-weight: bold;">
                            ※新たにファイルを選択して更新すると、<br>
                            　上記の写真は消えてしまいます。<br>
                        </p>
                            ※画像ファイルのみ<br>※サイズ50MB以下必須
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">更新</button>
                    </div>
                    
                </div>
                
            </form>
        </div>
    </div>
</div>
@stop