<!-- <div class="card col-3 my-4 px-5 mx-5 flex-wrap">
        <?php if(get_the_post_thumbnail( get_the_id(), 'thumbnail' ) != null ){
            echo get_the_post_thumbnail( get_the_id(), 'thumbnail', array( 'class' => 'card-img-top rounded-0' ) );
        }else{ 
        ?>
        <img src="<?php echo esc_url( TLPLUGIN_URL . 'assets/images/default-placeholder.png') ?>" class="card-img-top rounded-0" alt="">
        <?php } ?>
        <div class="card-body">
            <h3 class="card-title"><?php echo the_title() ?></h3>
            <p class="card-text" style="font-family: 'lato' !important;font-size: medium !important;"><?php if($meta_Service['insapp_service_price'] != null){echo $meta_Service['insapp_service_price'] ;}else{(_e(0)) ;} ?>FCFA - <?php if($meta_Service['insapp_service_cap'] != null){echo $meta_Service['insapp_service_cap'].' Personnes' ;}else{echo('Accès non autorisé') ;} ?></p>
            <a href="<?php echo esc_url( get_permalink( get_the_id() ) ); ?>" class="btn btn-primary">Voir</a>
        </div>
    </div>   -->

<!-- Content
================================================== -->
<!-- <div class="container-fluid">
    <div class="row">
        <?php
$args = array(
 	'post_type' => 'service',
);

$services = new WP_Query( $args );

// The Loop
while ( $services->have_posts() ) {
$services->the_post();
$meta_Service = get_post_meta(get_the_id());
$meta_Service = array_combine(array_keys($meta_Service), array_column($meta_Service, '0'));
$service_datas = get_post(get_the_id());
// var_dump( get_the_post_thumbnail( get_the_id(), 'thumbnail' ) );
?>
        <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
                <div class="position-relative">
                    <a href="javascript:void(0)">
                        <?php if(get_the_post_thumbnail( get_the_id(), 'thumbnail' ) != null ){
            echo get_the_post_thumbnail( get_the_id(), 'thumbnail', array( 'class' => 'card-img-top rounded-0' ) );
        }else{ 
        ?>
                        <img src="<?php echo esc_url( TLPLUGIN_URL . 'assets/images/default-placeholder.png') ?>"
                            class="card-img-top rounded-0" alt="">
                        <?php } ?>
                    </a>
                    <a href="javascript:void(0)"
                        class="bg-secondary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i
                            class="ti ti-heart fs-4"></i></a>
                </div>
                <div class="card-body pt-3 p-4">
                    <h6 class="fw-semibold fs-4">
                        <?php echo the_title() ?>
                    </h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-semibold fs-4 mb-0">
                            <?php if($meta_Service['insapp_service_price'] != null){echo $meta_Service['insapp_service_price'] ;}else{(_e(0)) ;} ?>FCFA
                        </h6>
                        <ul class="list-unstyled d-flex align-items-center mb-0">
                            <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a>
                            </li>
                            <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a>
                            </li>
                            <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a>
                            </li>
                            <li><a class="me-1" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a>
                            </li>
                            <li><a class="" href="javascript:void(0)"><i class="ti ti-star text-warning"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div> -->
<section id="courses-part" class="pt-120 pb-120 gray-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="courses-top-search">
                    <ul class="nav float-left" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="active" id="courses-grid-tab" data-toggle="tab" href="#courses-grid" role="tab"
                                aria-controls="courses-grid" aria-selected="true"><i class="fa fa-th-large"></i></a>
                        </li>
                        <li class="nav-item">
                            <a id="courses-list-tab" data-toggle="tab" href="#courses-list" role="tab"
                                aria-controls="courses-list" aria-selected="false"><i class="fa fa-th-list"></i></a>
                        </li>
                        <li class="nav-item">Showning 4 0f 24 Results</li>
                    </ul> <!-- nav -->

                    <div class="courses-search float-right">
                        <form action="#">
                            <input type="text" placeholder="Search">
                            <button type="button"><i class="fa fa-search"></i></button>
                        </form>
                    </div> <!-- courses search -->
                </div> <!-- courses top search -->
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="courses-grid" role="tabpanel" aria-labelledby="courses-grid-tab">
                <div class="row">
                    <?php
                    $args = array(
                     	'post_type' => 'service',
                    );

                    $services = new WP_Query( $args );

                    // The Loop
                    while ( $services->have_posts() ) {
                    $services->the_post();
                    $meta_Service = get_post_meta(get_the_id());
                    $meta_Service = array_combine(array_keys($meta_Service), array_column($meta_Service, '0'));
                    $service_datas = get_post(get_the_id());
                    // var_dump( get_the_post_thumbnail( get_the_id(), 'thumbnail' ) );
                    ?>

                    <div class="col-lg-4 col-md-6">
                        <div class="singel-course mt-30">
                            <div class="thum">
                                <div class="image">
                                    <?php if(get_the_post_thumbnail( get_the_id(), 'thumbnail' ) != null ){
                                    echo get_the_post_thumbnail( get_the_id(), 'thumbnail' );
                                    }else{ 
                                    ?>

                                    <img src="<?php echo esc_url( TLPLUGIN_URL . 'assets/images/default-placeholder.png') ?>"
                                        alt="Course">
                                    <?php } ?>
                                </div>
                                <div class="price">
                                    <span>
                                        <i class="fa fa-heart"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="cont">
                                <ul>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <span>(20 Votes)</span>
                                <a href="courses-singel.html"><h4><?php echo the_title() ?></h4></a>
                                <a><h6><?php if($meta_Service['insapp_service_price'] != null){echo $meta_Service['insapp_service_price'].'FCFA' ;}else{(_e('Free')) ;} ?></h6></a>
                                <div class="course-teacher">
                                    <div class="thum">
                                        <?php
                                        $author_id = get_the_author_ID();
                                        $author = get_user_by('id', $author_id);

                                        ?>
                                        <a href="#"><img src="<?php echo($author->user_url);?>" alt="Photographe"></a>
                                    </div>
                                    <div class="name">
                                        <a href="#">
                                            <h6>
                                                <?php echo get_the_author() ?>
                                            </h6>
                                        </a>
                                    </div>
                                    <div class="admin">+
                                        <ul>
                                            <li><a href="#"><i class="fa fa-user"></i><span>31</span></a></li>
                                            <li><a href="#"><i class="fa fa-heart"></i><span>10</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- singel course -->
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>