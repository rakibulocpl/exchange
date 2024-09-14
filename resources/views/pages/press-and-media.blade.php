@extends('layouts.user')

@section('content')
    <style>
        ul{
            list-style: none;
            padding: 0px;
        }
        .news-papter-logo{
            height: 60px;
            width: 100%;
        }
        .card{
            min-height: 230px;
            margin-bottom: 5px;
        }

    </style>
    <div class="container">
        <div class="col-md-12 ">
            <h1 class="text-center bg-exchange mb-5" style="padding:20px" >
                Press Coverage
            </h1>
          <div class="row">
              @foreach($allMedia as $media)
                  <div class="col-md-3">
                      <div class="card">
                          <div class="card-body">
                              <div class="mb-1">
                                  <img class="news-papter-logo" src="{{$media->logo}}">
                              </div>
                              <div>
                                  <ul>
                                      <?php
                                          $news = json_decode($media->news);
                                          ?>
                                      @foreach($news as $singleNews)
                                          <li>
                                              <a href="{{$singleNews->link}}" target="_blank">
                                                  <i class="fa fa-angle-right"></i> {{$singleNews->title}}
                                              </a>
                                          </li>
                                      @endforeach
                                  </ul>
                              </div>
                          </div>
                      </div>
                  </div>
              @endforeach

          </div>
        </div>
    </div>
@endsection