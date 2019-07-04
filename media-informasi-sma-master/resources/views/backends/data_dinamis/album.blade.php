@extends('backends.layouts.master')
@section('content')
          <div class="row">
            <div class="col-md-12 col-md-12 col-xs-12 col-sm-12">
              <div id="content" class="col-md-12 clearfix">
                <div class="flat-top flat-aqua"></div>
                 <!-- Modal add-->
                    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog modal-xs" role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-aqua">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Form Album</h4>
                          </div>
                            <!-- form Edit start -->
                            {!! Form::open(array('action' => 'Admin\DataDinamisController@addNewAlbum')) !!}
                              <div id="agenda" class="modal-body">
                                <div class="row">
                                  <div class="form-group col-md-3 col-lg-3 col-xs-12">
                                    <label for="nama_menu">Nama album : </label>
                                  </div>
                                  <div class="form-group col-md-9 col-lg-9 col-xs-12">
                                    <input type="text" id="album" name="album" class="form-control" placeholder="Nama Album" autocomplete="off">
                                    @if($errors->has('album'))<small class="reds"><i>* {!!$errors->first('album')!!}</i></small>@endif
                                  </div>
                                </div>
                            </div>
                              <div class="modal-footer bg-aqua padding-teen">
                                <button type="button" class="btn btn-sm btn-defaulty" data-dismiss="modal">Close</button>
                                <button type="submit" id="btn-album" class="btn btn-sm btn-green">Save</button>
                              </div>
                            {!! Form::close() !!}
                      </div>
                    </div>
                  </div>
                    <!-- /modal -->
                    <div class="row">
                      <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-aqua" data-toggle="modal" data-target="#modal-create">Tambah</button>
                      </div>
                    </div>
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                      <div class="box-body">
                        @foreach($albums as $album)
                        <div id="nama_album" class="col-lg-3 col-md-3 col-xs-12 center" data-id="{{ $album->id_album }}">
                          <div class="title-album">
                            <span>{{ ucwords($album->nama_album )}}</span>
                          </div>
                          <div class="outer-album">
                            <a href="{{ URL('gallery') }}/{{ $album->id_album }}"><img class="album" src="{{ asset('asset-sma/OxigGn/avatar/album.png') }}"></a>
                          </div>
                              @if(auth()->user()->hasRole('super-admin'))
                          <a type="button" id="hapus-album" data-id="{{ $album->id_album }}"><i class="fa fa-trash col-flat-red fa-2x"></i></a>
                          @else
                          @endif
                        </div>
                        @endforeach
                      </div><!-- /.box-body -->
                    </div>
                     <div class="pull-right right">{{ $albums->links() }}</div>
                  </div>
              </div>
            </div>
          </div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){

      $(function(){
        $.ajaxSetup({
          type : "post",
          cache : false,
          datatype : "json"
        });
        $(document).on("click", "#hapus-album", function(){
          var id = ($(this).attr('data-id'));
            var url = APP_URL+'/'+'gallery/album-delete';
          swal({   
            title: "Apakah Anda yakin?",   
            text: "Tetap menghapus data ini !",   
            type: "warning",
            html: true,   
            showCancelButton: true,   
            // confirmButtonColor: "#DD6B55",   
            confirmButtonColor: "#3edc81",
            confirmButtonText: "Delete",    
            cancelButtonText: "Cancel",   
            closeOnConfirm: false,   
            closeOnCancel: false 
            }, 
            function(isConfirm){   
              if (isConfirm) { 
                  $.ajax({
                    url :url +'/'+id,
                    data : { id:id },
                        beforeSend:function(xhr){
                          var token = $('meta[name="csrf_token"]').attr('content');

                          if(token){
                            return xhr.setRequestHeader('X-CSRF-TOKEN',token);
                          }
                        },
                    success : function(data){
                     if(data.success == 'true'){
                       $("#nama_album[data-id='"+id+"']").fadeOut("fast", function(){
                        $(this).remove();
                      });
                     }
                    }
                  });
                //}     
              swal("Terhapus!", "Data berhasil dihapus !", "success");   
            } else {     
              swal("Dibatalkan!", "Data batal dihapus !", "error");   
            } 
          });
        });
      });
    });
</script>
@endsection