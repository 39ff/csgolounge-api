<?php
/*  ...theme code ... */
$custom_fields = get_post_meta( $post->ID , 'csgolmid' , true );
if(empty( $custom_fields ) === false){ ?>
    <script>
        jQuery.fn.exists = function(){return Boolean(this.length > 0);}

        $(document).ready(function(){
            if ($(selector).exists()) {
                $('.loading').show();
                $.getJSON("lounge_subapi.php?mid="<?php echo $custom_fields; ?>, function (json) {
                    //console.log(json);
                    $('.progress-wrap').data('progress-percent', json.data[0].Value);
                    $('.pct1_hidden').text(json.data[0].Value);
                    $('.pct2_hidden').text(json.data[1].Value);
                    //$('.pct2').text(json.data[1].Value);
                    $('.t1').text(json.data[1].Name);
                    $('.t2').text(json.data[0].Name);
                    $('.loading').hide();
                    $('.csgochart').show();

                    // on page load...
                    moveProgressBar();
                    // on browser resize...
                    $(window).resize(function () {
                        moveProgressBar();
                    });

                    // SIGNATURE PROGRESS
                    function moveProgressBar() {
                        console.log("moveProgressBar");
                        var getPercent = ($('.progress-wrap').data('progress-percent') / 100);
                        var getProgressWrapWidth = $('.progress-wrap').width();

                        var progressTotal = getPercent * getProgressWrapWidth;
                        console.log(progressTotal);
                        var animationLength = 2500;
                        //$('.pc1').css('margin-left','30');

                        $('.progress-bar').stop().animate({
                            left: progressTotal
                        }, animationLength);

                        $(".pct").stop().animate({
                            'marginLeft': progressTotal / 2
                        }, animationLength);

                        $(".pct2").stop().animate({
                            'marginLeft': progressTotal / 3
                        }, animationLength);

                        var pct1 = $('.pct1_hidden').text();
                        $({count: 0}).animate({count: pct1}, {
                            duration: 1000,
                            easing: 'linear',
                            progress: function () {
                                $('.pct').text(Math.ceil(this.count));
                            }
                        });


                        var pct2 = $('.pct2_hidden').text();
                        $({count: 0}).animate({count: pct2}, {
                            duration: 1000,
                            easing: 'linear',
                            progress: function () {
                                $('.pct2').text(Math.ceil(this.count));
                            }
                        });


                    }


                });
            }
        });
    </script>

    <div class="loading" style="display: none;">Loading</div>
    <div style="display: none;" class="csgochart">

        <div class="progress-wrap progress" data-progress-percent="0">
            <span class="pct"></span>
            <div styple="margin-left:100px;" class="progress-bar progress">
                <span class="pct2" style="margin-left:200px;"></span>
            </div>
        </div>

        <div style="float:left" class="t1"></div>
        <div style="float:right" class="t2"></div>
    </div>

    <span style="display: none;" class="pct1_hidden"></span>
    <span style="display: none;" class="pct2_hidden"></span>



<?php } ?>