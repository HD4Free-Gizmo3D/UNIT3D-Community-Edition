{{--Edit Chatroom--}}
<div id="editChatStatus-{{ $chatstatus->id }}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header" style="text-align: center;">
                <h3>Edit Chat Status ({{ $chatstatus->name }})</h3>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="{{ route('editChatStatus', ['id' => $chatstatus->id]) }}">
                @csrf
                <div class="modal-body"  style="text-align: center;">
                    <h4>Please enter the new settings you want to use for {{ $chatstatus->name }}</h4>
                    <label for="chatstatus_name"> Name:</label> <label for="name"></label><input style="margin:0 auto; width:300px;" type="text" class="form-control" name="name" id="name" placeholder="Enter Name Here..." value="{{ $chatstatus->name }}" required>
                    <label for="chatstatus_color"> Color:</label> <label for="color"></label><input style="margin:0 auto; width:300px;" type="text" class="form-control" name="color" id="color" placeholder="Enter Hex Color Code Here..." value="{{ $chatstatus->color }}" required>
                    <label for="chatstatus_icon"> Icon:</label> <label for="icon"></label><input style="margin:0 auto; width:300px;" type="text" class="form-control" name="icon" id="icon" placeholder="Enter Font Awesome Code Here..." value="{{ $chatstatus->icon }}" required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-md btn-default" data-dismiss="modal" >Cancel</button>
                    <input class="btn btn-md btn-primary" type="submit">
                </div>
            </form>
        </div>
    </div>
</div>
{{--/Edit Chatroom--}}

{{--Delete Chatroom--}}
<div id="deleteChatStatus-{{ $chatstatus->id }}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Delete Chat Status ({{ $chatstatus->name }}) Permanently</h4>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="{{ route('deleteChatStatus', ['id' => $chatstatus->id]) }}">
                @csrf
                <div class="modal-body">
                    <p>Are you sure about this ?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Cancel</button>
                    <input class="btn btn-md btn-danger" type="submit">
                </div>
            </form>
        </div>
    </div>
</div>
{{--/Delete Chatroom--}}