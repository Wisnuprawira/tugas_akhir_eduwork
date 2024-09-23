@extends('admin.admin')

@section('header', 'Category')

@section('css')
    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
@section('content')
    <div id="controller">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="#" @click="addData" class="btn btn-sm btn-primary pull-right">Create New
                                Category</a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Code Category</th>
                                        <th>Name Category</th>
                                        <th>Price Category</th>
                                        <th>Created At</th>
                                        <th>Update At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->ct_id }}</td>
                                            <td>{{ $category->ct_code }}</td>
                                            <td>{{ $category->ct_name }}</td>
                                            <td>{{ $category->ct_price }}</td>
                                            <td>{{ $category->created_at }}</td>
                                            <td>{{ $category->updated_at }}</td>
                                            <td><a href="#" @click="editData({{ $category }})"
                                                    class="btn btn-sm btn-warning pull-right btn-block md-2">Edit</a>
                                                <a href="#" @click="deleteData({{ $category->ct_id }})"
                                                    class="btn btn-sm btn-danger pull-right btn-block md-2">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" :action="actionUrl" autocomplete="off">
                        <div class="modal-header">
                            <h4 class="modal-title">Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Code Category</label>
                                    <input type="number" name="ct_code" class="form-control"
                                        placeholder="Enter Code Category" :value="data.ct_code" required="">
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="ct_name" class="form-control" placeholder="Enter Name"
                                        :value="data.ct_name" required="">
                                </div>
                                <div class="form-group">
                                    <label>Price Category</label>
                                    <input type="text" name="ct_price" class="form-control" placeholder="Price Category"
                                        :value="data.ct_price" required="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Data Table Plugins -->
    <script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <!-- Panggil Plugins dan CSS Data Table -->
    <script type="text/javascript">
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            // $('#example2').DataTable({
            //     "paging": true,
            //     "lengthChange": false,
            //     "searching": false,
            //     "ordering": true,
            //     "info": true,
            //     "autoWidth": false,
            //     "responsive": true,
            // });
        });
    </script>
    <!-- Crud Vue Js -->
    <script type="text/javascript">
        var controller = new Vue({
            el: '#controller',
            data: {
                data: {},
                actionUrl: "{{ url('categories') }}",
                editStatus: false

            },
            mounted: function() {
                console.log("Vue.js mounted successfully");
            },
            methods: {
                addData() {
                    this.data = {};
                    this.actionUrl = "{{ url('categories') }}";
                    this.editStatus = false;
                    $('#modal-default').modal('show');
                },
                editData(data) {
                    this.data = data;
                    this.actionUrl = "{{ url('categories') }}" + '/' + data.ct_id;
                    this.editStatus = true;
                    $('#modal-default').modal('show');
                },
                deleteData(id) {
                    this.actionUrl = "{{ url('categories') }}" + '/' + id;
                    if (confirm("Are You Sure?")) {
                        axios.post(this.actionUrl, {
                            _method: "DELETE"
                        }).then(response => {
                            location.reload();
                        });
                    }

                }
            }
        });
    </script>
@endsection
