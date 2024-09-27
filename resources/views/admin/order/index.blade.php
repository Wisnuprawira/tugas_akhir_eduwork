@extends('admin.admin')

@section('header', 'Order')

@section('css')
    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
    <div id="controller">
        <div class="row">
            <div class="col-md-5 offset-md-3">
                <div class="input-group-prepend" data-widget="sidebar-search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search from amount"
                        v-model="search">
                    <div class="col-md-3">
                        <button class="btn btn-sm btn-primary " @click="addData">Create New
                            Orders</button>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12" v-for="order in filteredList" :key="order.id">
                <div class="info-box" v-on:click="editData(order)">
                    <div class="info-box-content">
                        <span class="info-box-text h3">@{{ order.or_id }}(@{{ order.or_pd_id }})</span>
                        <span class="info-box-number">Rp.<small>@{{ numberWithSpaces(order.or_amount) }}</small></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" autocomplete="off" @submit.prevent="submitForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Order</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Order Product ID</label>
                                    <select name="or_pd_id" class="form-control" :value="order.or_id" required="">
                                        @foreach ($products as $product)
                                            <option :selected="order.or_pd_id == {{ $product->pd_id }}"
                                                value="{{ $product->pd_id }}">{{ $product->pd_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Order Amount</label>
                                    <input type="text" name="or_amount" class="form-control"
                                        placeholder="Enter Order Amount" required="" :value="order.or_amount">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"
                                @click="deleteData(order.or_id)" v-if="editStatus">Delete</button>
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
        var actionUrl = '{{ url('orders') }}';
        var apiUrl = '{{ url('api/orders') }}';

        var app = new Vue({
            el: '#controller',
            data: {
                orders: [],
                search: '',
                order: {},
                editStatus: false,
            },
            mounted() {
                this.get_orders();
            },
            methods: {
                get_orders() {
                    const _this = this;
                    $.ajax({
                        url: apiUrl,
                        method: 'GET',
                        success: function(data) {
                            _this.orders = JSON.parse(data);
                        },
                        error: function(error) {
                            console.log(error);
                        },
                    })
                },
                addData() {
                    this.order = {};
                    this.editStatus = false;
                    this.actionUrl = "{{ url('orders') }}";
                    $('#modal-default').modal();
                },
                editData(order) {
                    this.order = order;
                    this.actionUrl = "{{ url('orders') }}" + "/" + order.or_id;
                    this.editStatus = true;
                    $('#modal-default').modal();
                },
                deleteData(or_id) {
                    if (confirm("Are You Sure?")) {
                        axios.delete('{{ url('orders') }}' + '/' +
                                or_id) // Pastikan hanya ada satu parameter or_id
                            .then(response => {
                                alert('Order has been removed');
                                this.get_orders(); // Refresh daftar order setelah penghapusan
                            })
                            .catch(error => {
                                console.log(error.response.data); // Log error untuk debugging
                            });
                    }
                },
                numberWithSpaces(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    // 1650000 to 1 650 000
                },
                submitForm(event) {
                    let form = event.target.closest('form');
                    let formData = new FormData(form);

                    axios.post(this.actionUrl, formData).then(response => {
                        $('#modal-default').modal('hide');
                        location.reload();
                    }).catch(error => {
                        console.log(error);
                    });
                },
            },
            computed: {
                filteredList() {
                    return this.orders.filter(order => {
                        return order.or_amount.toLowerCase().includes(this.search.toLowerCase())
                    })
                }
            }
        })
    </script>
@endsection
