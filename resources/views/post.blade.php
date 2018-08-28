@extends('layouts.portal')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card post" style="min-height: 400px;">
                <div class="row">
                    <div class="col-sm-10" style="margin: 10px 80px 10px 80px;">
                        <h2 class="card-title" style="margin: 25px;">{{$post->title}}</h2>
                        <div class="row">
                            <div class="col post-date"><i class="fa fa-calendar"></i> 01/08/2018</div>
                        </div>
                        <hr/>
                        <div class="card-body row">
                            @isset($post->img_path)
                                <div class="col-sm-4">
                                    <img class="card-img-top post-img" src="{{asset($post->imgUrl())}}"/>
                                </div>
                                <div class="col-sm-8">
                            @else
                                <div class="col-sm-12">
                            @endisset
                                    <p><?=$post->content?></p>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10" style="margin: 10px 80px 10px 80px;">
                        @if(sizeof($post->photos) > 0)
                            <h4>Fotos</h4>
                            <hr />
                            <div class="row">
                                @foreach($post->photos as $postPhoto)
                                    <div class="col-sm-3" style="margin: 15px; text-align: center;">
                                        <a href="{{asset($postPhoto->url())}}"
                                           data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                                            <img style="height: 150px" src="{{asset($postPhoto->thumbUrl())}}"  />
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @if(sizeof($post->files) > 0)
                <div class="row">
                    <div class="col-sm-10" style="margin: 10px 80px 10px 80px;">
                    <h4>Anexos</h4>
                    <hr/>
                    <!-- Post attachments  -->
                    @foreach($post->files as $postFile)
                        <p>
                            <a target="_blank" href="{{$postFile->url()}}">{{$postFile->description}}</a>
                        </p>
                    @endforeach
                    </div>
                </div>
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('libs')
    <link href="{{asset('css/ekko-lightbox.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{asset('js/tether.min.js')}}"></script>
    <script src="{{asset('js/ekko-lightbox.min.js')}}"></script>
    <script type="text/javascript">
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
@endpush