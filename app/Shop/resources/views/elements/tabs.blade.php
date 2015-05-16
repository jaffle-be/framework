<div class="tab-v5">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#description" role="tab" data-toggle="tab">Description</a></li>
        <li><a href="#reviews" role="tab" data-toggle="tab">Reviews (1)</a></li>
    </ul>

    <div class="tab-content">
        <!-- Description -->
        <div class="tab-pane fade in active" id="description">
            <div class="row">
                <div class="col-md-7">
                    <p>Morbi non semper est, eget tincidunt turpis. Vivamus sollicitudin sodales nisi, et venenatis turpis Vivamus sollicitudin ultricies eget. Fusce vitae neque blandit lectus faucibus aliquet nec vel ipsum. Integer mattis lacinia felis vel sollicitudin molestie.</p>
                    <br>

                    <h3 class="heading-md margin-bottom-20">Specifies</h3>

                    <div class="row">
                        <div class="col-sm-6">
                            <ul class="list-unstyled specifies-list">
                                <li><i class="fa fa-caret-right"></i>Brand Name: <span>Lacoste</span></li>
                                <li><i class="fa fa-caret-right"></i>Technics: <span>Computer</span> Knitted
                                </li>
                                <li><i class="fa fa-caret-right"></i>Sleeve Length: <span>Full</span></li>
                                <li><i class="fa fa-caret-right"></i>Sleeve Style: <span>Regular</span></li>
                                <li><i class="fa fa-caret-right"></i>Pattern Type: <span>PAID</span></li>
                                <li><i class="fa fa-caret-right"></i>Style: <span>Casual</span></li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled specifies-list">
                                <li><i class="fa fa-caret-right"></i>Material: <span>Cotton,Nylon</span></li>
                                <li><i class="fa fa-caret-right"></i>Item Type: <span>Pullovers</span></li>
                                <li><i class="fa fa-caret-right"></i>Thickness: <span>Thin</span></li>
                                <li><i class="fa fa-caret-right"></i>Model Number: <span>TM-11013 </span></li>
                                <li><i class="fa fa-caret-right"></i>Gender: <span>Men</span></li>
                                <li><i class="fa fa-caret-right"></i>MATERIAL: <span>80%COTTON+10%NYLON</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="responsive-video">
                        <iframe src="//player.vimeo.com/video/72343553" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Description -->

        <!-- Reviews -->
        <div class="tab-pane fade" id="reviews">
            <div class="product-comment margin-bottom-40">
                <div class="product-comment-in">
                    <img class="product-comment-img rounded-x" src="{{ asset('/assets/img/team/01.jpg') }}" alt="">

                    <div class="product-comment-dtl">
                        <h4>Mickel
                            <small>22 days ago</small>
                        </h4>
                        <p>I like the green colour, it's very likeable and reminds me of Hollister. A little loose though but I am very skinny</p>
                        <ul class="list-inline product-ratings">
                            <li class="reply"><a href="#">Reply</a></li>
                            <li class="pull-right">
                                <ul class="list-inline">
                                    <li><i class="rating-selected fa fa-star"></i></li>
                                    <li><i class="rating-selected fa fa-star"></i></li>
                                    <li><i class="rating-selected fa fa-star"></i></li>
                                    <li><i class="rating fa fa-star"></i></li>
                                    <li><i class="rating fa fa-star"></i></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <h3 class="heading-md margin-bottom-30">Add a review</h3>

            <form action="{{ asset('/assets/php/demo-contacts-process.php') }}" method="post" id="sky-form3" class="sky-form sky-changes-4">
                <fieldset>
                    <div class="margin-bottom-30">
                        <label class="label-v2">Name</label>
                        <label class="input">
                            <input type="text" name="name" id="name">
                        </label>
                    </div>

                    <div class="margin-bottom-30">
                        <label class="label-v2">Email</label>
                        <label class="input">
                            <input type="email" name="email" id="email">
                        </label>
                    </div>

                    <div class="margin-bottom-30">
                        <label class="label-v2">Review</label>
                        <label class="textarea">
                            <textarea rows="7" name="message" id="message"></textarea>
                        </label>
                    </div>
                </fieldset>

                <footer class="review-submit">
                    <label class="label-v2">Review</label>

                    <div class="stars-ratings">
                        <input type="radio" name="stars-rating" id="stars-rating-5">
                        <label for="stars-rating-5"><i class="fa fa-star"></i></label>
                        <input type="radio" name="stars-rating" id="stars-rating-4">
                        <label for="stars-rating-4"><i class="fa fa-star"></i></label>
                        <input type="radio" name="stars-rating" id="stars-rating-3">
                        <label for="stars-rating-3"><i class="fa fa-star"></i></label>
                        <input type="radio" name="stars-rating" id="stars-rating-2">
                        <label for="stars-rating-2"><i class="fa fa-star"></i></label>
                        <input type="radio" name="stars-rating" id="stars-rating-1">
                        <label for="stars-rating-1"><i class="fa fa-star"></i></label>
                    </div>
                    <button type="button" class="btn-u btn-u-sea-shop btn-u-sm pull-right">Submit</button>
                </footer>
            </form>
        </div>
        <!-- End Reviews -->
    </div>
</div>