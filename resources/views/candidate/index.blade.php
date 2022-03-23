<<style>
    #user_apps {
        border: 4px solid gray; 
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
    table > tbody > tr:hover > td {
        background-color: lightblue;
        color: black;
    }

    table > thead > tr > th {
        background-color:#151A48; 
        color:white;
    }
    #btnAddUser {
        background-color: #151A48;
        color: white;
        font-weight: 600;
        border: 2px solid white;
    }
    #btnAddUser:hover {
        background-color: white;
        color: #151A48;
        font-weight: 700;
        border: 2px solid #151A48;
        outline: none;
    }
    #btnAddUser:focus:hover {
        background-color: white;
        color: #151A48;
        font-weight: 700;
        border: 2px solid #151A48;
        outline: none;
    }
    #btnAddRole {
        background-color: #151A48;
        color: white;
        font-weight: 600;
        border: 2px solid white;
    }
    #btnAddRole:hover {
        background-color: white;
        color: #151A48;
        font-weight: 700;
        border: 2px solid #151A48;
        outline: none;
    }
    #btnAddRole:focus:hover {
        background-color: white;
        color: #151A48;
        font-weight: 700;
        border: 2px solid #151A48;
        outline: none;
    }
    #btnAddPic {
        background-color: #151A48;
        color: white;
        font-weight: 600;
        border: 2px solid white;
    }
    #btnAddPic:hover {
        background-color: white;
        color: #151A48;
        font-weight: 700;
        border: 2px solid #151A48;
        outline: none;
    }
    #btnAddPic:focus:hover {
        background-color: white;
        color: #151A48;
        font-weight: 700;
        border: 2px solid #151A48;
        outline: none;
    }
    .modal-header {
        border-bottom:1px solid #eee;
        background-color: #151A48;
        color: white;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        margin-left: -1px;
        margin-top: -5px;
        width: auto;
    }
    .form-group > .form-control:focus {
        border: 2px solid #151A48;
    }
    .modal-footer > button {
        background-color: #151A48;
        color: white;
        font-weight: 600;
        border: 2px solid white;
        outline: none;
    }
    .modal-footer > button:hover {
        background-color: white;
        color: #151A48;
        font-weight: 600;
        border: 2px solid #151A48;
        outline: none;
    }
    .modal-footer > button:focus {
        background-color: #151A48;
        color: white;
        font-weight: 600;
        border: 2px solid white;
        outline: none;
    }
    .modal-footer > button:focus:hover {
        background-color: white;
        color: #151A48;
        font-weight: 700;
        border: 2px solid #151A48;
        outline: none;
    }
</style>
@extends('layout.master')

@section('content')
<div class="main-grid">
    <div class="agile-grids">
        <!--alert success -->
        @if (session('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{{ session('status') }}</strong>
            </div> 
        @endif
        <!--alert success -->
        
        <!--validasi form-->
            @if (count($errors)>0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <ul>
                        <li><strong>Saved Data Failed !</strong></li>
                        @foreach ($errors->all() as $error)
                            <li><strong>{{ $error }}</strong></li>
                        @endforeach
                    </ul>
                </div>   
            @endif
        <!--end validasi form-->

        <div class="buttons-heading">
            <h2>Candidates</h2>
        </div>

        @if ( auth()->user()->is_admin=='1')
            <!-- Button trigger modal-->
            <div class="bs-component mb20">
                <button type="button" class="btn btn-primary" data-toggle="modal" id="btnAddCandidate" data-target="#myModalCandidate">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Add Candidate
                </button>
            </div>
            <!-- Button trigger modal-->    
        @endif
        

        <!-- table-->
            <table id="hr" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Education</th>
                        <th>Birthday</th>
                        <th>Applied Position</th>
                        <th>Email/Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($candidates as $data)
                    <tr>
                        <td>{{ $data->candidate_name }}</td>
                        <td>{{ $data->candidate_edu }}</td>
                        <td>{{ $data->candidate_birthday }}</td>
                        <td>{{ $data->candidate_appliedposition }}</td>
                        <td>
                            <b>{{ $data->candidate_email }}</b><br>
                            <i>{{ $data->candidate_phone }}</i>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#detailCandidate{{ $data->id }}">
                                Detail
                            </button>
                            @if ( auth()->user()->is_admin=='1')
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editCandidate{{ $data->id }}">
                                    Edit
                                </button>
                                <a href="{{ url('/candidates/delete/'.$data->id) }}" class="btn btn-danger btn-xs">Delete</a>
                            @endif
                        </td>
                    </tr>
                    <!-- Modal Edit-->
                    <div class="modal fade" id="editCandidate{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel"><b>Edit Candidate</b>
                                    <button type="button" class="close" data-dismiss="modal" id="closeModalUser" aria-label="Close" style=" margin-top : 1px;">
                                        <span aria-hidden="true" style="color:white"><i class="fa fa-times"></i></span>
                                    </button>
                                </h4>
                            </div>
                            <form action="{{url('/candidates/update')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <input type="hidden" name="cd_id" class="form-control" value="{{ $data->id }}">
                                            <label>Candidate Name</label>
                                            <input type="text" name="cd_name" class="form-control" value="{{ $data->candidate_name }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Education</label>
                                            <input type="text" name="cd_edu" class="form-control" value="{{ $data->candidate_edu }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Birthday</label>
                                            <input type="date" name="cd_birth" class="form-control" value="{{ $data->candidate_birthday }}">
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xs-4">
                                                <label>Experience in Year</label>
                                                <input type="number" min="0" lenght="10" name="cd_exp" class="form-control" value="{{ $data->candidate_exp }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Last Position</label>
                                            <input type="text" name="cd_lp" class="form-control" value="{{ $data->candidate_lastposition }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Applied Position</label>
                                            <input type="text" name="cd_ap" class="form-control" value="{{ $data->candidate_appliedposition }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Skills</label>
                                            <textarea class="form-control" rows="5" id="comment" name="cd_skill">{{ $data->candidate_skills }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="cd_email" class="form-control" value="{{ $data->candidate_email }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" name="cd_phone" class="form-control" value="{{ $data->candidate_phone }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Upload Resume</label>
                                            <span style="color: red">* file must : pdf | max : 10 MB</span>
                                            <input type="file" name="doc" id="doc" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btnResetModalUser"><i class="fa fa-refresh"></i> Reset</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->

                    <!-- Modal Detail-->
                    <div class="modal fade" id="detailCandidate{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel"><b>Edit Candidate</b>
                                    <button type="button" class="close" data-dismiss="modal" id="closeModalUser" aria-label="Close" style=" margin-top : 1px;">
                                        <span aria-hidden="true" style="color:white"><i class="fa fa-times"></i></span>
                                    </button>
                                </h4>
                            </div>
                            <form action="{{url(''.$data->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label><p>Candidate Name: </p></label>{{ $data->candidate_name }}
                                        </div>
                                        <div class="form-group">
                                            <label><p>Education: </p></label>{{ $data->candidate_edu }}
                                        </div>
                                        <div class="form-group">
                                            <label><p>Birthday: </p></label>{{ $data->candidate_birthday }}
                                        </div>
                                        <div class="form-group">
                                            <label><p>Experience: </p></label>{{ $data->candidate_exp }}
                                        </div>
                                        <div class="form-group">
                                            <label><p>Last Position: </p></label>{{ $data->candidate_lastposition }}
                                        </div>
                                        <div class="form-group">
                                            <label><p>Applied Position: </p></label>{{ $data->candidate_appliedposition }}
                                        </div>
                                        <div class="form-group">
                                            <label><p>Skills: </p></label>{{ $data->candidate_skills }}
                                        </div>
                                        <div class="form-group">
                                            <label><p>Email: </p></label>{{ $data->candidate_email }}
                                        </div>
                                        <div class="form-group">
                                            <label><p>Phone: </p></label>{{ $data->candidate_phone }}
                                        </div>
                                        <div class="form-group">
                                            <label><p>Created At: </p></label>{{ $data->created_at }}
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    @endforeach
                </tbody>
            </table>
        <!-- table-->
    </div>
</div>

<!-- Modal Add-->
<div class="modal fade" id="myModalCandidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><b>Add Candidate</b>
                <button type="button" class="close" data-dismiss="modal" id="closeModalUser" aria-label="Close" style=" margin-top : 1px;">
                    <span aria-hidden="true" style="color:white"><i class="fa fa-times"></i></span>
                </button>
            </h4>
        </div>
        <form action="{{url('/candidates/store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-body">
                    <div class="form-group">
                        <label>Candidate Name</label>
                        <input type="text" name="cd_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Education</label>
                        <input type="text" name="cd_edu" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Birthday</label>
                        <input type="date" name="cd_birth" class="form-control">
                    </div>
                    <div class="form-group row">
                        <div class="col-xs-4">
                            <label>Experience in Year</label>
                            <input type="number" min="0" lenght="10" name="cd_exp" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Last Position</label>
                        <input type="text" name="cd_lp" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Applied Position</label>
                        <input type="text" name="cd_ap" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Skills</label>
                        <textarea class="form-control" rows="5" id="comment" name="cd_skill"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="cd_email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="cd_phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Upload Resume</label>
                        <span style="color: red">* file must : pdf | max : 10 MB</span>
                        <input type="file" name="doc" id="doc" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- Modal -->



<script>
    $(document).ready(function() {
        var table = $('#hr').DataTable( {
            "order": [],
            responsive: true
        });
    
    } );
</script>
@endsection