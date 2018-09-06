@extends('layouts.portal')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card post" style="min-height: 400px;">
                <div class="row">
                    <div class="col-sm-10" style="margin: 10px 60px 10px 60px;">
                        <h2 class="card-title" style="margin: 25px;">{{$page->title}}</h2>
                        <hr/>
                        @if(strlen(trim($page->content))>0)
                            <div class="card-body row">
                                <div class="col-sm-12">
                                    <p><?=$page->content?></p>
                                </div>
                            </div>
                        @endif
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10" style="margin: 10px 80px 10px 80px;">
                            @if(sizeof($page->photos) > 0)
                                @if(strlen(trim($page->content))>0)
                                    <h4>Fotos</h4>
                                    <hr />
                                @endif
                                <div class="row">
                                    @foreach($page->photos as $pagePhoto)
                                        <div class="col-sm-3" style="margin: 30px;text-align: center;">
                                            <a href="{{asset($pagePhoto->url())}}"
                                               data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                                                <img style="height: 150px" src="{{asset($pagePhoto->thumbUrl())}}"  />
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    @if(sizeof($page->files) > 0)
                        <div class="row">
                            <div class="col-sm-10" style="margin: 10px 80px 10px 80px;">
                                <h4>Anexos</h4>
                                <hr/>
                                <!-- Post attachments  -->
                                @foreach($page->files as $pageFile)
                                    <p>
                                        <a target="_blank" href="{{$pageFile->url()}}">{{$pageFile->description}}</a>
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