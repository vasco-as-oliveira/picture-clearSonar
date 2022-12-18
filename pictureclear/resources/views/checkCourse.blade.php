@extends('layouts.app')


@section('content')

<link rel="stylesheet" href="{{asset('css/stylecheckCourse.css?v=').time()}}">
@if($checkCourse)
@if(count($checkCourse)==1)




<!-- Apresentação página do curso -->

<section class="section about-section gray-bg" id="about">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-lg-6">
                        <div class="about-text go-to">
                        @if(Auth::user()->id == $checkUser[0]->id)
                        <form method="POST" action="{{ url('/checkCourse/update', ['id'=>$checkCourse[0]->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @endif

                        @if(Auth::user()->id == $checkUser[0]->id)

                        @else
                            <h3 class="dark-color">{{$checkCourse[0]->title}}</h3>
                        @endif
                            <h6 class="theme-color lead">Rating: {{$checkCourse[0]->rating}}</h6>
                            <p>I <mark>Descrição: </mark>
                            
                            
                            @if(Auth::user()->id == $checkUser[0]->id)
                            <textarea maxlength="150" name="description" class="text" placeholder="{{$checkCourse[0]->description}}"></textarea>
                            @else
                            {{$checkCourse[0]->description}}
                            @endif
                                
                            
                            </p>
                            <div class="row about-list">
                                <h6 class="theme-color lead">Informação Sobre o Professor</h6>
                                <div class="col-md-6">
                                    <div class="media">
                                        <label>Nome</label>
                                        <p>{{$checkUser[0]->firstname}} {{$checkUser[0]->lastname}}</p>
                                    </div>
                                    <div class="media">
                                        <label>Biografia</label>
                                        <p>{{$checkUser[0]->description}}</p>
                                    </div>
                                    
                                    
                                </div>
                                <div class="col-md-6">
                                    <!-- Exemplo para adicionar em col/row -->
                                    <div class="media">
                                        <label>E-mail</label>
                                        <p>{{$checkUser[0]->email}}</p>
                                    </div>
                                    
                                   
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                            <div class="about-avatar">
                                @if(Auth::user()->id == $checkUser[0]->id)
                                <div class="overlay-container">
                                    <div class="overlay">
                                        <div class="overlay-panel overlay-right">
                                            <div class="profilepicture">
                                                <br>
                                                <img src="{{ $checkCourse[0]->image != null ? 'storage/images/'.$checkCourse[0]->image : 'images/default-profilepicture.png' }}" alt="default-profilepicture" id="profilepicture">
                                                <input type="file" id="file" style="display: none;"  name="inputImage">
                                                <label for="file"><button class="button"style="heigth:50%; width:200px;" >Carregar Imagem</button></label>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="overlay-container">
                                    <div class="overlay">
                                        <div class="profilepicture">
                                            <img src="{{ $checkCourse[0]->image != null ? 'storage/images/'.$checkCourse[0]->image : 'images/default-profilepicture.png' }}" alt="default-profilepicture" id="profilepicture">
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                    </div>
                    @if(Auth::user()->id == $checkUser[0]->id)
                    <div class="profilepicture">
                        <button name="done" type="submit" class="button" style="heigth:50%; width:200px; text-align:center;">Concluído</button>
                    </div>    
                    </form>
                    @endif
                </div>
                <div class="counter">
                    <div class="row">
                        <div class="col-6 col-lg-3">
                            <div class="count-data text-center">
                                <h6 class="count h2" data-to="500" data-speed="500">{{$checkCourse[0]->total_hours}}</h6>
                                <p class="m-0px font-w-600">Hora(s) de curso</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="count-data text-center">
                                <h6 class="count h2" data-to="150" data-speed="150">150</h6>
                                <p class="m-0px font-w-600">Project Completed</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="count-data text-center">
                                <h6 class="count h2" data-to="850" data-speed="850">850</h6>
                                <p class="m-0px font-w-600">Photo Capture</p>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="count-data text-center">
                                <h6 class="count h2" data-to="190" data-speed="190">190</h6>
                                <p class="m-0px font-w-600">Telephonic Talk</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>















@elseif(count($checkCourse)>1)
@php($i=0)
<div class="container">
@csrf
@forelse ($checkCourse as $course)
    @if($i==0)   
        <div class="row">
    @endif  
            <div class="col-4">

                <!-- Cada Container -->

                <div class="container-register">

                        <h1>{{$course->title}}</h1>
                        <h5>Rating: {{$course->rating}}</h5>
                        <h5>Linguagem: {{$course->language}}</h5>
                        <h5>Recebe certificado?: @if($course->has_certificate) 
                                &#10003;
                            @else
                                &#x2717; 
                            @endif
                        </h5>

                        <form method="GET" action="{{ url('/checkCourse/search') }}">
                        <input type="text" name="selectCourse" value="{{$course->id}}" hidden>
                        <button type="submit" id="selectCourse" class="btn btn-success">Ver Mais</button>
                        </form>

                    </div>
                <!-- Cada Container -->

            </div>
        @php($i++)
    @if($i==3)   
        </div>
        @php($i=0)
    @endif  
@empty
    <p>Não existem cursos</p>
@endforelse
    </div>
</div>
@endif
@else
<p>Não existem cursos</p>
@endif

<script>
        const div_pfp = document.querySelector('.profilepicture');
        const img_profilepicture = document.querySelector('#profilepicture');
        const input_profilepictureInput = document.querySelector('#profilepictureInput');
        const button_upload = document.querySelector('#upload');
        const h1_photo = document.querySelector('#photo');

        input_profilepictureInput.addEventListener('change', function() {
            const chosenPhoto = this.files[0];
            if (chosenPhoto) {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    img_profilepicture.setAttribute('src', reader.result);
                });
                reader.readAsDataURL(chosenPhoto);
                const i = Math.floor(Math.random() * 2);
                if (i == 1) {
                    document.getElementById("photo").innerHTML = "Wow, estás compremetid@?"
                }
                h1_photo.style.display = "contents";
            }
        });
    </script>
@endsection