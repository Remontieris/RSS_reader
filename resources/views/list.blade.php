@extends('layouts.app')

@section('content')
        <list-component :list= "{{ json_encode($list) }}"></list-component>
@endsection
