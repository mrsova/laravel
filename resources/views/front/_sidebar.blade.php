<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">

        <aside class="widget news-letter">
            <h3 class="widget-title text-uppercase text-center">Get Newsletter</h3>

            <form action="#">
                <input type="email" placeholder="Your email address">
                <input type="submit" value="Subscribe Now" class="text-uppercase text-center btn btn-subscribe">
            </form>

        </aside>
        <aside class="widget">
            <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>
            @foreach($popularPosts as $post)
                <div class="popular-post">
                <a href="{{route('post.show', $post->slug)}}" class="popular-img">
                    <img src="{{$post->getImage()}}" alt="">
                    <div class="p-overlay"></div>
                </a>
                <div class="p-content">
                    <a href="{{route('post.show', $post->slug)}}" class="text-uppercase">{{$post->title}}</a>
                    <span class="p-date">{{$post->getDate()}}</span>

                </div>
            </div>
            @endforeach
        </aside>
        <aside class="widget">
            <h3 class="widget-title text-uppercase text-center">Featured Posts</h3>

            <div id="widget-feature" class="owl-carousel">
                <div class="item">
                    <div class="feature-content">
                        <img src="/images/p1.jpg" alt="">

                        <a href="#" class="overlay-text text-center">
                            <h5 class="text-uppercase">Home is peaceful</h5>

                            <p>Lorem ipsum dolor sit ametsetetur sadipscing elitr, sed </p>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="feature-content">
                        <img src="/images/p2.jpg" alt="">

                        <a href="#" class="overlay-text text-center">
                            <h5 class="text-uppercase">Home is peaceful</h5>

                            <p>Lorem ipsum dolor sit ametsetetur sadipscing elitr, sed </p>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="feature-content">
                        <img src="/images/p3.jpg" alt="">

                        <a href="#" class="overlay-text text-center">
                            <h5 class="text-uppercase">Home is peaceful</h5>

                            <p>Lorem ipsum dolor sit ametsetetur sadipscing elitr, sed </p>
                        </a>
                    </div>
                </div>
            </div>
        </aside>
        <aside class="widget pos-padding">
            <h3 class="widget-title text-uppercase text-center">Recent Posts</h3>

            <div class="thumb-latest-posts">


                <div class="media">
                    <div class="media-left">
                        <a href="#" class="popular-img"><img src="/images/r-p.jpg" alt="">
                            <div class="p-overlay"></div>
                        </a>
                    </div>
                    <div class="p-content">
                        <a href="#" class="text-uppercase">Home is peaceful Place</a>
                        <span class="p-date">February 15, 2016</span>
                    </div>
                </div>
            </div>
            <div class="thumb-latest-posts">


                <div class="media">
                    <div class="media-left">
                        <a href="#" class="popular-img"><img src="/images/r-p.jpg" alt="">
                            <div class="p-overlay"></div>
                        </a>
                    </div>
                    <div class="p-content">
                        <a href="#" class="text-uppercase">Home is peaceful Place</a>
                        <span class="p-date">February 15, 2016</span>
                    </div>
                </div>
            </div>
            <div class="thumb-latest-posts">


                <div class="media">
                    <div class="media-left">
                        <a href="#" class="popular-img"><img src="/images/r-p.jpg" alt="">
                            <div class="p-overlay"></div>
                        </a>
                    </div>
                    <div class="p-content">
                        <a href="#" class="text-uppercase">Home is peaceful Place</a>
                        <span class="p-date">February 15, 2016</span>
                    </div>
                </div>
            </div>
            <div class="thumb-latest-posts">


                <div class="media">
                    <div class="media-left">
                        <a href="#" class="popular-img"><img src="/images/r-p.jpg" alt="">
                            <div class="p-overlay"></div>
                        </a>
                    </div>
                    <div class="p-content">
                        <a href="#" class="text-uppercase">Home is peaceful Place</a>
                        <span class="p-date">February 15, 2016</span>
                    </div>
                </div>
            </div>
        </aside>
        <aside class="widget border pos-padding">
            <h3 class="widget-title text-uppercase text-center">Categories</h3>
            <ul>
                <li>
                    <a href="#">Food & Drinks</a>
                    <span class="post-count pull-right"> (2)</span>
                </li>
                <li>
                    <a href="#">Travel</a>
                    <span class="post-count pull-right"> (2)</span>
                </li>
                <li>
                    <a href="#">Business</a>
                    <span class="post-count pull-right"> (2)</span>
                </li>
                <li>
                    <a href="#">Story</a>
                    <span class="post-count pull-right"> (2)</span>
                </li>
                <li>
                    <a href="#">DIY & Tips</a>
                    <span class="post-count pull-right"> (2)</span>
                </li>
                <li>
                    <a href="#">Lifestyle</a>
                    <span class="post-count pull-right"> (2)</span>
                </li>
            </ul>
        </aside>
    </div>
</div>