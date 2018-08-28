@extends('layouts.portal')
@section('content')
    <div class="row">
        <div class="col-sm-9">
            <h3><i>Publicações</i></h3>
            @isset($findMessage)
                <div class="alert alert-primary" role="alert">
                    {{$findMessage}}
                </div>
            @endisset
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-sm-4 post-col">
                        <div class="card post">
                            <div class="card-body">
                                <a href="{{route('post',['id'=>$post->id])}}">
                                    <img class="card-img-top post-img" src="
                                        @isset($post->img_path)
                                            {{asset($post->imgUrl())}}
                                        @else
                                            {{asset('img/news.png')}}
                                        @endisset
                                         " alt="Card image cap"/>

                                    <p class="card-title post-link" style="height: 50px">{{$post->title}}</p>

                                </a>
                                @foreach($post->tags as $tag)
                                    <span class="badge-primary" style="color: #FFFFFF;padding: 5px;border-radius: 5px;">{{$tag->name}}</span>
                                @endforeach
                                <br/><br/>
                                <div class="row">
                                    <div class="col post-date"><i class="fa fa-calendar"></i> {{$post->updated_at->format('d/m/Y')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <br />
            {{$posts->links()}}
        </div>
        <div class="col-sm-3 aux-col">
            <h2>&nbsp;</h2>
            <div class="card aux-card">
                <div class="card-body">
                    <h5 class="card-title">Busca</h5>
                    <div class="form-group">
                        <p action="#" method="post">
                            <form method="post" action="{{route('find')}}">
                                @csrf
                                <div class="form-group">
                                    <label>Texto:</label>
                                    <input type="text" name="text" class="form-control" required/>
                                </div>
                                <button type="submit" class="btn btn-primary hover-btn btn-right" type="submit">
                                    <i class="fa fa-search"></i>Buscar
                                </button>
                                <!--
                                <br/><br/><p style="float: right;"><a href="#">Busca avançada</a></p>
                                -->
                            </form>
                        </form>
                    </div>
                </div>
            </div>
            <br/>
            <div class="card aux-card">
                <div class="card-body">
                    <h4 class="card-title">Tags</h4>
                    <form id="form_tag" method="post" action="{{route('tags')}}">
                        @csrf
                        <input id="hidden_tag" type="hidden" name="id" />
                    </form>
                    @foreach($tags as $tag)
                        <button onclick="findTag({{$tag->id}})" class="btn btn-primary hover-btn tag">{{$tag->name}}</button>
                    @endforeach
                </div>
            </div>
            <div class="card aux-card" style="margin-top: 15px;">
                <div class="card-body">
                    <button id="btn_message" class="btn btn-primary hover-btn btn-block"><i class="fa fa-comments"></i>&nbsp;Fale conosco</button>
                </div>
            </div>
        </div>
    </div>
    @include('modals.contact')
@endsection
@push('scripts')
    <script type="text/javascript">
        function findTag(tag) {
            document.getElementById('hidden_tag').value = tag;
            document.getElementById('form_tag').submit();
        }
        function checkMail(mail){
            var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
            if(typeof(mail) == "string"){
                if(er.test(mail)){
                    return true; }
            }else if(typeof(mail) == "object"){
                if(er.test(mail.value)){
                    return true;
                }
            }else{
                return false;
            }
        }
        function verifyForm(id){
            switch (id){
                case "input_email": verifyEmail(); break;
                case "input_subject": verifySubject(); break;
                case "input_content": verifyContent(); break;
            }
            var email = document.getElementById("input_email").value;
            if (email == ""){
                document.getElementById("btn_send").disabled = true;
                return;
            }else if (!checkMail(email)){
                document.getElementById("btn_send").disabled = true;
                return;
            }
            var subject = document.getElementById("input_subject").value;
            if (subject == ""){
                document.getElementById("btn_submit").disabled = true;
                return;
            }
            var content = document.getElementById("input_content").value;
            if (content == ""){
                document.getElementById("btn_send").disabled = true;
                return;
            }
            document.getElementById("btn_send").disabled = false;
        }

        function verifyEmail(){
            var email = document.getElementById("input_email").value;
            if (email == "") {
                document.getElementById("span_email_empty").style.display = "block";
                document.getElementById("span_email_invalid").style.display = "none";
            }else if(!checkMail(email)){
                document.getElementById("span_email_empty").style.display = "none";
                document.getElementById("span_email_invalid").style.display = "block";
            }else{
                document.getElementById("span_email_empty").style.display = "none";
                document.getElementById("span_email_invalid").style.display = "none";
            }
        }
        function verifySubject(){
            var subject = document.getElementById("input_subject").value;
            if (subject == ""){
                document.getElementById("span_subject_empty").style.display = "block";
            }else{
                document.getElementById("span_subject_empty").style.display = "none";
            }
        }
        function verifyContent(){
            var content = document.getElementById("input_content").value;
            if (content == ""){
                document.getElementById("span_content_empty").style.display = "block";
            }else{
                document.getElementById("span_content_empty").style.display = "none";
            }
        }

        $(document).ready(function(){
            $("#btn_message").click(function(){
                $("#modal_message").modal();
            });
        });
    </script>
@endpush