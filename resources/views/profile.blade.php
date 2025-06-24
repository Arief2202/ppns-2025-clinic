@extends('layouts.main')

@section('body')
    @include('layouts.cardOpen')
        @if(isset($errorMessage))
            <div class="alert alert-danger mt-1 p-2">{{ $errorMessage }}</div>
        @endif
        @if(isset($successMessage))
            <div class="alert alert-success mt-1 p-2">{{ $successMessage }}</div>
        @endif
        {{-- @if(isset($reload))
            <script>
                setTimeout(function() {
                    window.location.href = "/profile";
                }, 1000);
            </script>
        @endif --}}

        <div class="row mt-2 mb-3">
          <div class="col-6">
            <div class="col">
              <h5 class="card-title">Profile</h5>
            </div>
          </div>
        </div>

        <div style="max-height: 100vh; overflow-y:auto;">
            <div class="card-text me-3">
                <div style="max-height: 68vh; overflow-y:auto;">
                    <div class="card-text me-3">

                        <form action="/profile/edit" method="POST">@csrf
                            <input type="hidden" id="idEdit" name="id">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nipEdit" name="nip" value="{{Auth::user()->nip}}">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nameEdit" name="name" value="{{Auth::user()->name}}">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="password2" class="form-label">Password Confirmation</label>
                                <input type="password" class="form-control" id="password2" name="password2">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @include('layouts.cardClose')
@endsection


@section('script')
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable({

            });
        });

        function changeModal(id){
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                const res = JSON.parse(this.responseText);
                document.getElementById('idEdit').value=res.id;
                document.getElementById('nipEdit').value=res.nip;
                document.getElementById('nameEdit').value=res.name;
                document.getElementById('roleEdit').options[res.role_id-1].setAttribute('selected', true);
            }
            xhttp.open("GET", "/api/user/get?id="+id, true);
            xhttp.send();
        }
        function del(){
            $.ajax({
                url: "/users/delete",
                type:"POST",
                data:{
                    id: document.getElementById('idEdit').value,
                    _token: document.getElementsByTagName("meta")[3].content
                }
            });
            setTimeout(function() {
                window.location.href = "/users";
            }, 200);
        }
    </script>
@endsection
