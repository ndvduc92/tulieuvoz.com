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
            <div class="col-md-6">
            <h3>Quản lý link</h3>
            </div>
            <div class="col-md-6">
            <h3 class="btn btn-success" onclick="copyLink()">Copy link trang cá nhân</h3>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="mytable" class="table table-bordred table-striped">
                  <thead>
                    <th>Tiêu đề</th>
                    <th>View</th>
                    <th>Ngày thêm vào</th>
                    <th>Lần xem gần nhất</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                      @foreach ($links as $link)
                    <tr>
                      <td> <a href="/link/{{ $link->id }}">{{ $link->name ?  $link->name : substr($link->link, 0, 25).'...' }}</a></td>
                      <td>{{ $link->viewed }}</td>
                      <td>{{ $link->created_at }}</td>
                      <td>{{ get_time_ago( strtotime($link->updated_at) ) }}</td>
                      <th>
                          <a href="/manage/{{ $link->id }}/edit" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                          <a href="/manage/{{ $link->id }}/delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                      </th>
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

      <script>
          function copyLink() {
            const userId = '{!! Auth::user()->id !!}'
            navigator.clipboard.writeText('https://tulieumvga.com/user/' + userId)
            alert('Đã copy !')
          }
      </script>
@endsection
