@extends('layouts.app')

@section('content')
<div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Edit</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                    <form >
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="username">username:</label>
                            <input type="hidden" id="id">
                            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                        </div>
                        <div class="form-group">
                          <label for="email">Email:</label>
                          <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                        </div>
                        
                        <div class="form-group" id="pass">
                          <label for="password">password:</label>
                          <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                        </div>             
                        <button type="button" id="edit" class="btn btn-primary" data-dismiss="modal">Save</button>
                      </form>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            
          </div>
        </div>
    </div>
    <button data-toggle="modal" data-target="#myModal" class="dataform btn btn-primary" >ADD</button>
    <hr>

    <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Edit / Delet</th>
            </tr>
        </thead>
    </table>
@stop

@push('scripts')
<script>
$(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{url('display')}}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data:null,
             defaultContent: '<button data-token="{{ csrf_token() }}" class="delet" >Delet</button> <button data-toggle="modal" data-target="#myModal" class="dataform" >Edit</button>',  // with no content ...
             "orderable" : false,
             "searchable": false
            }
        ]
    });
});
$(document).on("click",".delet",function(){
       
        var id= $(this).parents("tr").children("td");
        var deleteable = id[0].textContent;
        var token = $(this).data('token');
       
        $.ajax({
            url:"{!!url('datatables/')!!}"+"/"+deleteable ,
            type: 'delete',
            //type: 'post',
            headers:{ 'X-CSRF-TOKEN' :token},
            success:function(result){
                var table =  $('#users-table').DataTable();
 
               
                table.draw();
                alert(result.code +":"+result.messsage);
                
            },
        
            error:function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                alert(jqXHR.status+":"+textStatus+":"+errorThrown);
            }
        });

    });
    $(document).on("click",".dataform",function(){

        alert("You can  change only name and email by edit user");
        
         var id= $(this).parents("tr").children("td");
         if(id[0]){
            var editable = id[0].textContent;

        
               $.ajax({
            url:"{!!url('datatables/')!!}"+"/"+editable +"/edit",
            method:"get",
            success:function(user){
                $('#username').val(user.name)
                $('#id').val(user.id)
                $('#email').val(user.email)
                $('#pass').hide();
                console.log(user);
                //var table = $('#users-table').DataTable();
                //table.draw();
                //alert("row updated");
                
                
            }
        

        });
    }
    else
    {
        $('#username').val('')
        $('#id').val('')
        $('#email').val('')
        $('#pass').show();
    }
    });
    $(document).on("click","#edit",function(){
        
                var id=$('#id').val();
				var name=$('#username').val();
                var email=$('#email').val();
                if(id){
               $.ajax({
            url:"{!!url('datatables')!!}"+"/"+id,
			data:{'id':id,'name':name,'email':email},
            method:"PATCH",
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
           success:function(result){
                var table =  $('#users-table').DataTable();
 
               
                table.draw();
                alert(result.code +":"+result.messsage);
                
            },
        
            error:function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                alert(jqXHR.status+":"+textStatus+":"+errorThrown);
            }

                //console.log(user.name);
                
                
        });
    }
    else{
				var name=$('#username').val();
                var email=$('#email').val();
                var password=$('#password').val();
         $.ajax({
            url:"{!!url('datatables')!!}",
			data:{'name':name,'email':email,'password':password},
            method:"POST",
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
           success:function(result){
                var table =  $('#users-table').DataTable();
 
               
                table.draw();
                alert(result.code +":"+result.messsage);
                console.log(result);
                
            },
        
            error:function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                alert(jqXHR.status+":"+textStatus+":"+errorThrown);
            }

                //console.log(user.name);
                
                
        });

    }

        });
</script>
@endpush