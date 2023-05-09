@extends('layout')
@section('content')
<?php

function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'Vừa xong'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'giờ',
                60                      =>  'phút',
                1                       =>  'giây'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return $t . ' ' . $str. ' trước';
        }
    }
}
?>

?>
<div class="container" style="margin-top:50px">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              @if (\Request::route()->getName() == 'user')
              <h3>Bộ sưu tập của <span style="color:red; font-weight:bold">{{ $user->name }}</span></h3>
              @else
              <h3>Link sưu tầm</h3>
              @endif
              <hr />
              @if (\Request::route()->getName() != 'user')
              <div class="col-sm">
                <a class="btn btn-sm btn-success" href="/links?sort=view"><i class="fa fa-fire"></i> Top view</a>
                <a class="btn btn-sm btn-info" href="/links"><i class="fa fa-bell"></i> Link mới nhất</a>
                <a class="btn btn-sm btn-primary" href="/links?sort=vote"><i class="fa fa-thumbs-up"></i> Top vote</a>
              </div>
              @endif
              <br>
              <div class="table-responsive">
                <table id="mytable" class="table table-bordred table-striped">
                  <thead>
                    <th>Tiêu đề</th>
                    <th>View</th>
                    <th>
                        Like/Dislike
                    </th>
                    <th>Ngày thêm vào</th>
                    <th>Lần xem gần nhất</th>
                    <th>Người đăng</th>
                  </thead>
                  <tbody>
                      @foreach ($links as $link)
                      <?php 
                        $colors = ['success', 'primary', 'danger', 'warning', 'info']; 
                        $text = (strpos($link->link, 'spankbang') !== false) ? 'red' : 'green'; 
                      ?>
                    <tr>
                      <td> <a style="color:{{ $text }}" href="/link/{{ $link->id }}">{{ $link->name ?  $link->name : substr($link->link, 0, 25).'...' }}</a></td>
                      <td>{{ $link->viewed }}</td>
                      <td><span style="color:green"
                    ><i class="fa fa-thumbs-up"></i
                  > {{ $link->vote }}</span> <span style="color:red"
                    ><i class="fa fa-thumbs-down"></i
                  > {{ $link->dislike }}</span></td>
                      <td>{{ $link->created_at }}</td>
                      <td>{{ get_time_ago( strtotime($link->updated_at) ) }}</td>
                      <td>
                          @if ($link->user_id)
                          <a class="label label-{{ $colors[array_rand($colors)] }}" href="/user/{{ $link->user_id }}">{{ $link->user->name }}</a>
                          @else
                          <span>Guest</span>
                          @endif
                    </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="clearfix"></div>
                {!! $links->withQueryString()->links() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
