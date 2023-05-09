@extends('layout')
@section('content')
<div class="container">
        <h3>Make VOZ Great Again</h3>
        <hr />
        @if (!$link)
          <div class="alert alert-warning" role="alert">Không tìm thấy !</div>
        @else
        <div>

        @if (\Session::has('success'))
    <div class="alert alert-success">
       <p>{{ \Session::get('success') }}</p>
    </div>
@endif

          <div class="panel panel-default">
            <div class="panel-heading">Chi tiết link</div>
            @if (\Auth::check())
            @if (!$isLike)
                <a class="btn btn-sm btn-primary" style="margin:5px 10px" href="/link/{{ $link->id }}/like">Thêm yêu thích</a>
            @else
                <a class="btn btn-sm btn-danger" style="margin:5px 10px" href="/link/{{ $link->id }}/like">Bỏ yêu thích</a>
            @endif

            @endif
            <div class="panel-body">

              <ul>
                <li>Tiêu đề: <span style="color:blue">{{ $link->name ? $link->name : 'Chưa cập nhật' }}</span></li>
                @if ($link->user_id)
                <li>Người đăng: <a class="label label-success" href="/user/{{ $link->user_id }}">{{ $link->user->name }}</a></li>
                @else
                    <li>Người đăng: Khách vãng lai</li>
                @endif
                <li>Mô tả: <span style="color:green">{{ $link->description ? $link->description : 'Chưa cập nhật' }}</span></li>
                <li>Số lượt xem: {{ $link->viewed }}</li>
                <li>Like/Dislike: <span style="color:green"
                    ><i class="fa fa-thumbs-up"></i
                  > {{ $link->vote }}</span> <span style="color:red"
                    ><i class="fa fa-thumbs-down"></i
                  > {{ $link->dislike }}</span></li>
                <li><b style="color:red">Nhấn vào con mắt lấy link: <i style="
      cursor: pointer;
  " class="fa fa-eye" onclick="showLink()"></i></b></li>
                <li>Ngày thêm vào: {{ $link->created_at }}</li>
              </ul>
              <div id="showLink" style="display:none">
                <p>
                    @if(!$iframe)
                    <a class="btn btn-sm btn-danger" href="{{ $link->link }}" target="_blank">Open Link</a>
                    @else
                    Mật khẩu (* 4 chữ viết tắt của group) : <input id="mk" /> <button onclick="showVideo()" class="btn btn-sm btn-danger">Xem video</button>
                    <br/>
                    <br>
                    <div style="display:none" id="video">
                        <a class="btn btn-sm btn-danger" href="/iframe?src={{ $link->link }}" target="_blank">Mở trong cửa sổ mới</a>
                        <br><br>
                       <iframe sandbox="allow-forms allow-pointer-lock allow-same-origin allow-scripts allow-top-navigation" referrerpolicy="no-referrer|no-referrer-when-downgrade|origin|origin-when-cross-origin|same-origin|strict-origin-when-cross-origin|unsafe-url" src="/iframe?src={{ $link->link }}" height="300px" width="100%" allowfullscreen=""></iframe>
                    </div>
                    @endif

                  <span class="btn btn-sm btn-success" onclick="copy()">Copy Link</span>
                </p>
                <p v-if="showVoteBtn">
                 Đánh giá tư liệu này
                  <span class="btn btn-success" onclick="vote()"
                    ><i class="fa fa-thumbs-up"></i
                  > {{$link->vote}}</span> - <span class="btn btn-danger" onclick="unvote()"
                    ><i class="fa fa-thumbs-down"></i
                  > {{$link->dislike}}</span>
                </p>

              </div>
            </div>
          </div>
        </div>
        @endif
        <hr>
        <form method="post" action="/link/{{$link->id}}/comment" style="display:none" id="showCmt">
            @csrf
          <input name="name" class="form-control" placeholder="Tên của bạn..." value="<?= (Auth::check()) ? Auth::user()->name : '' ?>" <?php if(Auth::check()) { echo 'readonly';} ?>>
          <br>
          <textarea name="comment" class="form-control" placeholder="Nội dung..." required></textarea><br/>
          <button class="btn btn-primary" type="submit">Bình luận</button>
          <hr>
        </form>
        <div class="panel panel-default widget">
          <div class="panel-heading">
            <div class="row">
              <div class="col-md-4 text-left panel-title">
                <h3 class="panel-title"><i class="glyphicon glyphicon-comment"></i> Bình luận gần đây <span class="label label-success">{{ count($link->comments) }}</span></h3>
              </div>
              <div class="col-md-8 text-right">
                <button class="btn btn-primary" onclick="showCmt()">Thêm bình luận</button>
              </div>
            </div>
          </div>
          <div class="panel-body">
            <ul class="list-group">
                @foreach ($link->comments as $comment)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-1 col-md-1">
                            <img src="/assets/images/comment.png" class="img-circle img-responsive" alt="" width="50px"/>
                        </div>
                        <div class="col-xs-11 col-md-11">
                            <div>
                                <span style="color: red">{{ $comment->comment }}</span>
                                <div class="mic-info">
                                    By: <a>{{ $comment->name ? $comment->name : 'Vozer nào đó' }}</a> on {{ $comment->created_at }}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
          </div>

      </div>
      </div>

      <script>


          function showLink() {
              document.getElementById('showLink').style.display = "block";
          }

          function showVideo() {
              const pass = document.getElementById("mk").value
              if (pass.toLowerCase() === 'mvga') document.getElementById('video').style.display = "block";
              else {
                  document.getElementById('video').style.display = "none"
                  alert('Mật khẩu sai, vui lòng nhập lại!')
              }
          }
          function showCmt() {
              document.getElementById('showCmt').style.display = "block";
          }
          function copy() {
            const link = '{!! $link->link !!}'
            navigator.clipboard.writeText(link)
            alert('Đã copy !')
          }
          function vote() {
            const linkId = '{!! $link->id !!}'
            location.href = "/link/" + linkId + '/vote?type=like';
          }
          function unvote() {
            const linkId = '{!! $link->id !!}'
            location.href = "/link/" + linkId + '/vote?type=dislike';
          }
      </script>
@endsection
