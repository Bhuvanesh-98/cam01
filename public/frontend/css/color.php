<?php

header("Content-Type:text/css");

$color = '#'.$_GET['color'];
$color2 = '#'.$_GET['color2'];
?>


.header-area,.home-button a,.case-item .case-content h4:before,.subscribe-area:before,.faq-header button.faq-button:before,.faq-header button.faq-button.collapsed,.blog-page .blog-author,.contact-info-item.bg2,.contact-form .btn,.btn-base,#option-1:checked:checked~.option-1, #option-2:checked:checked~.option-2,.option .dot::before,.sidebar-item ul li.active a, .sidebar-item ul li a:hover,.event-detail-tab ul,.service-widget-contact,.event-form .btn,.comment-form .btn,.team-detail-social ul li a{
    background:<?php echo $color; ?> !important;
}
.counter-section{
    background-color:<?php echo $color; ?> !important;
}
.home-button a,.contact-form .btn,.event-form .btn,.comment-form .btn{
    border:1px solid <?php echo $color;?>
}
#option-1:checked:checked~.option-1, #option-2:checked:checked~.option-2{
    border-color:<?php echo $color;?> !important;
}
.v-mid-content .heading h2,.testi-info h4,.blog-author span i,.blog-item .sm_btn,.mobile-menuicon .menu-bar{
    color:<?php echo $color;?>
}



.case-item .case-image .overlay{
    background:<?php echo $color.'80';?>
}

.brand-item:before{
    border-right:3px solid <?php echo $color; ?>
}
.brand-item:before{
    border-left:3px solid <?php echo $color; ?>
}

.brand-item:after{
    border-top:3px solid <?php echo $color; ?>
}
.brand-item:after{
    border-bottom:3px solid <?php echo $color; ?>
}

.brand-colume:after{
    border-bottom: 25px solid <?php echo $color;?>
}


.doc-search-section .doc-search-button button,.scroll-top,.case-item .case-content h4:after,.subscribe-form .btn-sub,.faq-header button.faq-button,.faq-header button.faq-button.collapsed:before,.contact-info-item.bg1,.contact-info-item.bg3,.contact-form .btn:hover,.empty-state .empty-state-icon,.wh-table .sch,.team-exp-area .event-detail-content #contact .item,.expert-sevice .service-list .photo .cat,.booking-widget .book a{
    background:<?php echo $color2; ?> !important;
}

.testimonial-item:before,.team-text span,.blog-item h3 a:hover,ul.nav-menu li:hover > a,.banner-text ul li span,.team-text a:hover,.total-job,.comment-list .c-number,.comment-list .com-text span.date i{
    color:<?php echo $color2 ;?>
}
.owl-carousel.team-carousel .owl-dots .owl-dot.active,.owl-carousel.blog-carousel .owl-dots .owl-dot.active{
    border:5px solid <?php $color2; ?>
}

.blog-page .blog-author{
    border-left:5px solid <?php echo $color2; ?>
}
.blog-page .blog-author{
    border-right:5px solid <?php echo $color2; ?>
}

.contact-form .btn:hover,.comment-form .btn:hover,.event-form .btn:hover{
    border:1px solid <?php echo $color2 ?> !important;
}
