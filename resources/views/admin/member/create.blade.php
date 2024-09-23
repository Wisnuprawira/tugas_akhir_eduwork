@extends('admin.admin')

@section('header', 'Member')

@section('content')
    <div class="row">

        <div class="col-md-12">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New Member</h3>
                </div>


                <form action="{{ url('members') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="ms_name" class="form-control" placeholder="Enter Name"
                                required="">
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="ms_email" class="form-control" placeholder="Enter email"
                                required="">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="ms_password" class="form-control" placeholder="Password"
                                required="">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="ms_phone_number" class="form-control" placeholder="Phone Number"
                                required="">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="ms_address" class="form-control" placeholder="Address"
                                required="">
                        </div>
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        @endsection
