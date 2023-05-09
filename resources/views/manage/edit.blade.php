@extends('layout')
@section('content')
<div class="container signup-form" style="margin-top:100px">
<form class="form-horizontal" method="post" action="/manage/{{ $link->id}}/edit">
            @csrf
            <div class="form-group">
                <label for="hex" class="col-sm-2 control-label">Tiêu đề</label>
                <div class="col-sm-8">
                    <input class="form-control" name="name" required value="{{ $link->name }}"></input>
                </div>
            </div>

            <div class="form-group">
                <label for="text" class="col-sm-2 control-label">Link</label>
                <div class="col-sm-8">
                    <input class="form-control" name="link" type="url" required value="{{ $link->link }}"/>
                </div>
            </div>

            <div class="form-group">
                <label for="text" class="col-sm-2 control-label"></label>
                <div class="col-sm-8">
                    <button class="btn btn-success" @click="save()" type="submit">Update</button>
                </div>
            </div>
        </form>

    </div>
@endsection
