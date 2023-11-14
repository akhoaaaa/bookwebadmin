@extends('admin_layout')
@section('admin_content')

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa thể loại
                </header>
                <div class="panel-body">
                    @foreach($edit_type as $key => $type)

                        <div class="position-center">
                            <form role="form" action="{{ URL::to('/update-type/'.$type->idtheloai) }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Loại</label>
                                    <select name="idloai" class="form-control input-sm m-bot15" >
                                        @foreach([1 => 'Sách', 2 => 'Truyện'] as $value => $label)
                                            <option value="{{ $value }}" {{ $type->idloai == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Thể Loại</label>
                                    <input type="text" name = "tentheloai" class="form-control" id="exampleInputEmail1" value="{{ $type->tentheloai }}">
                                </div>

                                <button type="submit" name = "add_category_product" class="btn btn-info">Cập nhật thể loại</button>
                            </form>
                        </div>
                    @endforeach

                </div>
            </section>

        </div>
@endsection
