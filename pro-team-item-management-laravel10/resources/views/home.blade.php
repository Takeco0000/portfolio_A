@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>商品管理システムへようこそ</h1>
@stop

@section('content')
    <br>
    <p>左サイドバー「商品一覧」をクリック</p>
    <p>※userの場合、登録・編集・削除はご利用いただけません</p>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
