@extends('layout')
@section('content')
        <h3 class="text-center" style="margin-top:100px">Tạo Link</h3>
        <form class="form-horizontal" method="post" action="/links">
            @csrf
            <div class="form-group">
                <label for="hex" class="col-sm-2 control-label">Tiêu đề</label>
                <div class="col-sm-8">
                    <input class="form-control" name="name" required></input>
                </div>
            </div>

            <div class="form-group">
                <label for="text" class="col-sm-2 control-label">Link</label>
                <div class="col-sm-8">
                    <input class="form-control" name="link" type="url" required/>
                </div>
                
            </div>
            <div class="form-group">
                <label for="text" class="col-sm-2 control-label">Mô tả</label>
                <div class="col-sm-8">
                    <textarea class="form-control" name="description" rows="6"></textarea>
                </div>
                
            </div>
            <div class="form-group">
                <label for="text" class="col-sm-2 control-label"></label>
                <div class="col-sm-8" style="color:gray">
                    <p>* Mô tả có thể có hoặc không</p>
                </div>
                
            </div>
            <div class="form-group">
                <label for="text" class="col-sm-2 control-label"></label>
                <div class="col-sm-8">
                    <button class="btn btn-success" @click="save()" type="submit">Save</button>
                </div>
            </div>
        </form>
@endsection
