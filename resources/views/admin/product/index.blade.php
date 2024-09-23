@extends('admin.admin')

@section('header', 'Product')

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
                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Number Product</th>
                                        <th>Product Category</th>
                                        <th>Product Name</th>
                                        <th>Price Product</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" :action="actionUrl" autocomplete="off" @submit="submitForm($event,data.id)">
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
                                    <label>Number Product</label>
                                    <input type="number" name="pd_code" class="form-control"
                                        placeholder="Enter Code Category" :value="data.pd_code" required="">
                                </div>
                                <div class="form-group">
                                    <label>Produk Category</label>
                                    <input type="text" name="pd_ct_id" class="form-control"
                                        placeholder="Enter Produk Category" :value="data.pd_ct_id" required="">
                                </div>
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" name="pd_name" class="form-control"
                                        placeholder="Enter Price Category" :value="data.pd_name" required="">
                                </div>
                                <div class="form-group">
                                    <label>Product Price</label>
                                    <input type="text" name="pd_price" class="form-control"
                                        placeholder="Enter Price Category" :value="data.pd_price" required="">
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
            $("#datatable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
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
    <script type="text/javascript">
        var actionUrl = "{{ url('products') }}";
        var apiUrl = "{{ url('api/products') }}";

        var columns = [{
                data: 'pd_id',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'pd_code',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'pd_ct_id',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'pd_name',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'pd_price',
                class: 'text-center',
                orderable: true
            },
            {
                render: function(index, row, data, meta) {
                    return `
                    <a href="#" onclick="controller.editData(event, ${meta.row})" class="btn btn-sm btn-warning pull-right btn-block md-2">Edit</a>
                    <a href="#" onclick="controller.deleteData(event, ${data.id})" class="btn btn-sm btn-danger pull-right btn-block md-2">Delete</a>`;
                },
                orderable: false,
                width: '200px',
                class: 'text-center'
            },
        ];

        var controller = new Vue({
            el: '#controller',
            data: {
                datas: [],
                data: {},
                actionUrl,
                apiUrl,
                editStatus: false,
            },
            mounted: function() {
                console.log("Vue.js mounted successfully");
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#datatable').DataTable({
                        ajax: {
                            url: _this.apiUrl,
                            type: 'GET',
                        },
                        columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    });
                },
                addData() {
                    this.data = {};
                    this.editStatus = false;
                    $('#modal-default').modal('show');
                },
                editData(event, row) {
                    this.data = this.datas[row];
                    this.editStatus = true;
                    $('#modal-default').modal('show');
                },
                deleteData(event, id) {
                    if (confirm("Are You Sure?")) {
                        axios.post(this.actionUrl + '/' + id, {
                            _method: "DELETE"
                        }).then(response => {
                            location.reload();
                        });
                    }
                },
                submitForm(event, id) {
                    event.preventDefault();
                    const _this = this;

                    var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
                    var methodType = this.editStatus ? 'PUT' : 'POST';

                    axios({
                            method: methodType,
                            url: actionUrl,
                            data: new FormData($(event.target)[0])
                        })
                        .then(response => {
                            console.log("Response:", response.data);
                            $('#modal-default').modal('hide');
                            _this.table.ajax.reload(); // Reload DataTable setelah operasi berhasil
                        })
                        .catch(error => {
                            console.error("Error:", error);
                        });
                }

            }
        });
    </script>
@endsection
