@extends('admin_layout')
@section('admin_content')
    <div class="container-fluid">
        <style type="text/css">
            p.title-thongke {
                text-align: center;
                font-size: 20px;
                font-weight: bold;
            }

        </style>

        <div class="row">
            <p class="title-thongke">Thống kê đơn hàng doanh số</p>
            <form autocomplete="off">
                @csrf
                <div class="col-md-2">
                    <p>Từ ngày: <input type="text" id="datepicker" class="form-control"></p>
                    <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả">
                </div>
                <div class="col-md-2">
                    <p>Đến ngày: <input type="text" id="datepicker2" class="form-control"></p>
                </div>

                <div class="col-md-2">
                    <p>
                        Lọc theo:
                        <select class="dashboard-filter form-control">
                            <option>--Chọn--</option>
                            <option value="7ngay">7 ngày qua</option>
                            <option value="thangtruoc">Tháng trước</option>
                            <option value="thangnay">Tháng này</option>
                            <option value="365ngayqua">365 ngày qua</option>
                        </select>
                    </p>
                </div>
            </form>

            <div class="col-md-12">
                <div id="chart" style="height: 250px"></div>
            </div>
        </div>

        <div class="row">
            <style type="text/css">
                table.table.table-bordered.table-dark {
                    background: #32383e;
                }

                table.table.table-bordered.table-dark tr th {
                    color: #fff;
                }

            </style>
            <p class="title-thongke">Thống kê truy cập</p>
            <table class="table table-bordered table-dark">
                <thead>
                    <tr>
                        <th>Đang online</th>
                        <th>Tổng tháng trước</th>
                        <th>Tổng tháng này</th>
                        <th>Tổng một năm</th>
                        <th>Tổng truy cập</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="col">{{ $visitor_count }}</td>
                        <td scope="col">{{ $visitor_last_month_count }}</td>
                        <td scope="col">{{ $visitor_this_month_count }}</td>
                        <td scope="col">{{ $visitor_year_count }}</td>
                        <td scope="col">{{ $visitors_total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-4 col-xs-12">
                <p class="title-thongke">Thống kê tổng sản phẩm bài viết đơn hàng</p>
                <div id="donut"></div>
            </div>

            {{-- <div class="col-md-4 col-xs-12">
                <h3>Bài viết xem nhiều</h3>
                <ol class="list_views">
                    @foreach ($post_views as $key => $post)
                        <li>
                            <a href="{{ url('bai-viet/' . $post->post_slug) }}">{{ $post->post_title }} | <span
                                style="color: #000">{{$post->post_views}}</span></a>
                        </li>
                    @endforeach
                </ol>
            </div> --}}

            {{-- <div class="col-md-4 col-xs-12">
                <style type="text/css">
                    ol.list_views {
                        margin: 10px 0;
                        color: #fff
                    }
                    ol.list_views a {
                        color: orange;
                        font-weight: 400
                    }
                </style>
            </div> --}}
        </div>
    </div>
@endsection
