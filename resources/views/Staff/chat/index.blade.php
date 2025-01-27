@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff_dashboard') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">Staff Dashboard</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('chatManager') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">Chat Manager</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container box">
        <h2>User Chat Statuses</h2>

        <button class="btn btn-primary" data-toggle="modal" data-target="#addChatStatus">Add New Chat Status</button>
        {{--Add Chatroom Modal--}}
        <div id="addChatStatus" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header" style="text-align: center;">
                        <h3>Add Chat Status</h3>
                    </div>

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('addChatStatus') }}">
                        @csrf
                        <div class="modal-body"  style="text-align: center;">
                            <h4>Please fill in all fields for the chat status you would like to create.</h4>
                            <label for="chatstatus_name"> Name:</label> <label for="name"></label><input style="margin:0 auto; width:300px;" type="text" class="form-control" name="name" id="name" placeholder="Enter Name Here..." required>
                            <label for="chatstatus_color"> Color:</label> <label for="color"></label><input style="margin:0 auto; width:300px;" type="text" class="form-control" name="color" id="color" placeholder="Enter Hex Color Code Here..." required>
                            <label for="chatstatus_icon"> Icon:</label> <label for="icon"></label><input style="margin:0 auto; width:300px;" type="text" class="form-control" name="icon" id="icon" placeholder="Enter Font Awesome Code Here..." required>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-md btn-default" data-dismiss="modal" >Cancel</button>
                            <input class="btn btn-md btn-primary" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--/Add Chatroom Modal--}}

        <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Color</th>
                    <th>Icon</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($chatstatuses as $chatstatus)
                    <tr>
                        <td>
                            {{ $chatstatus->id }}
                        </td>
                        <td>
                            <a href="#">
                                {{ $chatstatus->name }}
                            </a>
                        </td>
                        <td>
                            <i class="{{ config('other.font-awesome') }} fa-circle" style="color: {{ $chatstatus->color }};"></i> {{ $chatstatus->color }}
                        </td>
                        <td>
                            <i class="{{ $chatstatus->icon }}"></i> [{{ $chatstatus->icon }}]
                        </td>
                        <td>
                            <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editChatStatus-{{ $chatstatus->id }}">
                                <i class="{{ config('other.font-awesome') }} fa-pen-square"></i>
                            </button>
                            <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteChatStatus-{{ $chatstatus->id }}">
                                <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                            </button>
                            @include('Staff.chat.chatstatuses_modals', ['chatstatus' => $chatstatus])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="container box">
        <h2>Chat Rooms</h2>

        <button class="btn btn-primary" data-toggle="modal" data-target="#addChatroom">Add New Chatroom</button>
        {{--Add Chatroom Modal--}}
        <div id="addChatroom" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header" style="text-align: center;">
                        <h3>Add Chatroom</h3>
                    </div>

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('addChatroom') }}">
                    @csrf
                    <div class="modal-body"  style="text-align: center;">
                        <h4>Please enter the name of the chatroom you would like to create.</h4>
                        <label for="chatroom_name"> Name:</label> <label for="name"></label><input style="margin:0 auto; width:300px;" type="text" class="form-control" name="name" id="name" placeholder="Enter Name Here..." required>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-md btn-default" data-dismiss="modal" >Cancel</button>
                        <input class="btn btn-md btn-primary" type="submit">
                    </div>
                    </form>
                </div>
            </div>
        </div>
        {{--/Add Chatroom Modal--}}

        <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($chatrooms as $chatroom)
                    <tr>
                        <td>
                            {{ $chatroom->id }}
                        </td>
                        <td>
                            <a href="#">
                                {{ $chatroom->name }}
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editChatroom-{{ $chatroom->id }}">
                                <i class="{{ config('other.font-awesome') }} fa-pen-square"></i>
                            </button>
                            <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteChatroom-{{ $chatroom->id }}">
                                <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                            </button>
                            @include('Staff.chat.chatroom_modals', ['chatroom' => $chatroom])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
