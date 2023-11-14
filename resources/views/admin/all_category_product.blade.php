@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê danh mục sản phẩm
    </div>

    <div class="table-responsive">
        <?php
                        $message = Session::get('message');
                            if($message){
                                echo '<span class ="text-alert">'.$message.' </span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>

            <th>Tên Danh Mục</th>
            <th>Hình Ảnh</th>

            <th>Hiển Thị</th>
            <th>Ngày Thêm</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach($all_category_product as $key => $cate_pro)
          <tr>
            <td>{{ $cate_pro ->tendanhmuc }}</td>
            <td>{{ $cate_pro ->hinhanh }}</td>

            <td><span class="text-ellipsis">
                <?php
                if($cate_pro->status ==1){
                ?>
                <a href ="{{ URL::to('/unactive-category/'.$cate_pro -> id)}}"><span class = "fa-thumb-styling fa fa-thumbs-up"></span></a>
                <?php
                }else{
                ?>
                <a href = "{{ URL::to('/active-category/'.$cate_pro -> id) }}"><span class = "fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php
                }

                ?>
            </span></td>
            <td>
                <a href="{{ URL::to('/edit-category-product/'.$cate_pro->id) }}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a onclick="return confirm('Bạn muốn xóa danh mục này không?')" href="{{ URL::to('/delete-category-product/'.$cate_pro->id) }}"  class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</div>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        border-bottom: 3px solid #000000;
        padding: 3px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

@endsection
