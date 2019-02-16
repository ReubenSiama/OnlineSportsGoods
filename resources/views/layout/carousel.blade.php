<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>
                    
                    <div class="carousel-inner">
                        @php $count = 0; @endphp
                        @foreach($advertisements as $advertisement)
                        <div class="item {{ $count == 0 ? 'active' : '' }}">
                            <div class="col-sm-6">
                                <h1><span>OS</span>-GOODS</h1>
                                <h2>{{ $advertisement->title }}</h2>
                                <p>{{ $advertisement->description }}</p>
                                <!-- <button type="button" class="btn btn-default get">Get it now</button> -->
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ Voyager::image($advertisement->banner_image) }}" class="girl img-responsive" alt="" />
                            </div>
                        </div>
                        @php $count++ @endphp
                        @endforeach
                    </div>
                    
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</section><!--/slider-->