@extends('admin.admin')

@section('header', 'Member')

@section('content')
    <div class="row">

        <div class="col-md-12">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Member</h3>
                </div>
                <form action="{{ url('members/' . $member->ms_id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Menambahkan method spoofing PUT -->


                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="ms_name" class="form-control" placeholder="Enter Name" required=""
                                value="{{ $member->ms_name }}">
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="ms_email" class="form-control" placeholder="Enter email"
                                required="" value="{{ $member->ms_email }}">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="ms_password" class="form-control" placeholder="Password"
                                required="" value="{{ $member->ms_password }}">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="ms_phone_number" class="form-control" placeholder="Phone Number"
                                required="" value="{{ $member->ms_phone_number }}">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="ms_address" class="form-control" placeholder="Address"
                                required="" value="{{ $member->ms_address }}">
                        </div>
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        @endsection
