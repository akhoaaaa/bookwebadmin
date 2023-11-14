@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê sản phẩm
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

            <th>Tên sản phẩm</th>
              <th>Giá sản phẩm</th>
            <th>Hình Ảnh</th>
            <th>Số lượng tồn kho</th>
              <th>Thể Loại</th>
            <th>Trạng Thái</th>
              <th>Edit</th>
              <th>Delete</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach($all_product as $key => $pro)
          <tr>
            <td>{{ $pro ->tensp }}</td>
              <td>{{ $pro ->giasp }}</td>
            <td><img src="public/uploads/product/{{ $pro ->hinhanh }}" height="75" width="75" ></td>

            <td>{{ $pro ->soluongtonkho }}</td>
              <td>{{ $pro ->tentheloai }}</td>

            <td><span class="text-ellipsis">
                <?php
                if($pro->status ==1){
                ?>
                <a href ="{{ URL::to('/unactive-product/'.$pro -> id)}}"><span>Hiển Thị</span></a>
                <?php
                }else{
                ?>
                <a href = "{{ URL::to('/active-product/'.$pro -> id) }}"><span> Ẩn</span></a>
                <?php
                }
                ?>
            </span></td>
              <td> <button  onclick="window.location.href='{{ URL::to('/edit-product/'.$pro->id) }}'" style="background: green;color: white">Edit</button></td>
            <td>
                <button onclick="confirmDelete('{{ URL::to('/delete-product/'.$pro->id) }}')" style="background: red; color: white">Delete</button>

                <script>
                    function confirmDelete(url) {
                        if (confirm('Bạn muốn xóa sản phẩm này không?')) {
                            window.location.href = url;
                        }
                    }
                </script>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">

        <div class="col-sm-5 text-center">
        </div>

      </div>
    </footer>
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
