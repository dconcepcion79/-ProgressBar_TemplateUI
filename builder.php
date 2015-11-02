<?php
require_once(dirname(__FILE__).'/class-builder.php');


$dzsprg_builder = new DZSprg_Builder();

$struct_item_default = str_replace(array("\r","\r\n","\n"),'',$dzsprg_builder->generate_layer_item());
$struct_item_text = str_replace(array("\r","\r\n","\n"),'',$dzsprg_builder->generate_layer_item(array('type' => 'text','background_color' => 'transparent','text' => 'insert text here','height' => 'auto')));
$struct_item_circ = str_replace(array("\r","\r\n","\n"),'',$dzsprg_builder->generate_layer_item(array('type' => 'circ','background_color' => 'transparent','height' => '{{width}}')));
?><!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Progress Bars DZS - Source Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
        <link href="./bootstrap/bootstrap.css" rel="stylesheet">
        <link rel='stylesheet' type="text/css" href="style/style.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>

        <script>
            var dzsprg_builder_settings = {
                struct_layer: '<?php echo $struct_item_default; ?>'
                , struct_layer_text: '<?php echo $struct_item_text; ?>'
                , struct_layer_circ: '<?php echo $struct_item_circ; ?>'
                , currSkin: '<?php echo $dzsprg_builder->currSkin; ?>'
                , thepath: ''
            }
        </script>
        <!--[if lt IE 9]><script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    </head>
    <body>


        <section class="mcon-mainmenu" style="position: absolute; z-index: 5;">

            <!--
            -->
            <div class="container">
                <div class="row">
                    <div class="logo-con col-md-3">
                        <img src="img/dzsplugins.png" alt="wordpress video gallery" style="margin:0 auto"/>
                    </div>
                    <div class="main-menu-con">
                        <ul class="main-menu">
                            <li class=" "><a href="index.html">Home</a></li>
                            <li class=" "><a href="builder.html">Builder</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--===end mainmenu
        -->


        <section class="mcon-maindemo" style="position: relative; padding-top:100px; padding-bottom:50px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <br/>
                        <br/>
                        <?php
                        foreach ($dzsprg_builder->frontend_errors as $err) {
                            echo $err;
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <h3 style="margin-top: 0; padding-top: 0;">Customize <strong>skin-<?php echo $dzsprg_builder->currSkin; ?></strong> - <span class='btn-preview'>preview</span></h3>
                    </div>
                    <div class="col-md-6">
                        <div class="super-select float-right">
                            <span class="btn-show-select"><span class='arrow-symbol'>↳</span> Current Skin <strong>skin-<?php echo $dzsprg_builder->currSkin; ?></strong> </span>
                            <div class="super-select--inner">
                                <div class='scroller-con super-select--options'>
                                    <div class="inner">
                                        <div class='skin-option button-secondary'><a href="builder.php?skin=custom">skin-custom</a></div><?php
                                        foreach ($dzsprg_builder->db_skins as $skin) {
                                            echo '<div class="skin-option button-secondary"><a href="builder.php?skin='.$skin.'">skin-'.$skin.'</a></div>';
                                        }
                                        ?><div class='skin-option button-secondary'>skin-<form id='create-custom-skin' method="POST" action="builder.php?skin=" style="display: inline-block; opacity: 0.5; width: 90px;"><input class="subtile" type="text" name="builder_skin_name" placeholder="skin name" style="width: 100%;"/></form></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form name="builder-form" class="builder-form">

                    <div class="row">
                        <div class="dzsprg-builder-con">
                            <div class="col-md-8">
                                <div class="dzsprg-builder-con--canvas-area dzs-progress-bar" style="opacity: 0;"></div>
                                <div class="dzsprg-builder-con--add-area">
                                    <span class="dzs-button builder-add-rect">
                                        Add Rectangle
                                    </span>
                                    <span class="dzs-button builder-add-circ">
                                        Add Circle
                                    </span>
                                    <span class="dzs-button builder-add-text">
                                        Add Text
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dzsprg-builder-con--layers-area"><!--begin layers area-->
                                    <?php
                                    if (isset($dzsprg_builder->db_skin_data['bars'])) {
                                        $bars = $dzsprg_builder->db_skin_data['bars'];
//                                    print_r($bars);
                                        foreach ($bars as $lab_bar => $val_bar) {
                                            if ($lab_bar !== 0 && $lab_bar == 'mainsettings') {
                                                continue;
                                            }
//                                        print_r($val_bar);
                                            $aux = $val_bar;
                                            echo $dzsprg_builder->generate_layer_item($aux);
                                        }
                                    }
                                    ?>
                                <!--end layers area--></div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $mainsettings = array(
                                'position_type' => 'relative',
                                'index' => '0',
                                'width' => '100%',
                                'height' => 'auto',
                                'animation_time' => '2000',
                                'maxperc' => '100',
                                'margin_top' => '0',
                                'margin_right' => '0',
                                'margin_bottom' => '0',
                                'margin_left' => '0',
                                'color' => '#eeeeee',
                                'background_color' => '#285e8e',
                                'type' => 'rect',
                                'initon' => 'scroll',
                                'maxnr' => '100',
                            );

                            $mainsettings_fromdb = array();

                            if (isset($dzsprg_builder->db_skin_data['bars']['mainsettings'])) {
                                $mainsettings_fromdb = $dzsprg_builder->db_skin_data['bars']['mainsettings'];
                            }
                            $mainsettings = array_merge($mainsettings,$mainsettings_fromdb);

//                        $mainsettings = array_merge();
                            ?>
                            <div id="tabs-mainsettings" class="dzs-tabs skin-box">

                                <div class="dzs-tab-tobe">
                                    <div class="tab-menu with-tooltip">
                                        Position
                                    </div>
                                    <div class="tab-content">

                                        <div class="one-half">
                                            <div class="setting-label">Width</div>
                                            <div class="setting"><input class="builder-field" type="text" name="bars[mainsettings][width]" value="<?php echo $mainsettings['width']; ?>">
                                            </div>
                                        </div>
                                        <div class="one-half">
                                            <div class="setting-label">Height</div>
                                            <div class="setting"><input class="builder-field" type="text" name="bars[mainsettings][height]" value="<?php echo $mainsettings['height']; ?>">
                                            </div>
                                        </div>
                                        <div class="clear"></div>


                                        <hr>
                                        <div class="one-half" style="float:none; margin: 0 auto;">
                                            <div class="setting-label">Margin Top</div>
                                            <div class="setting"><input class="builder-field" type="text" name="bars[mainsettings][margin_top]" value="<?php echo $mainsettings['margin_top']; ?>">
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="one-half">
                                            <div class="setting-label">Margin Left</div>
                                            <div class="setting"><input class="builder-field" type="text" name="bars[mainsettings][margin_left]" value="<?php echo $mainsettings['margin_left']; ?>">
                                            </div>
                                        </div>
                                        <div class="one-half">
                                            <div class="setting-label">Margin Right</div>
                                            <div class="setting"><input class="builder-field" type="text" name="bars[mainsettings][margin_right]" value="<?php echo $mainsettings['margin_right']; ?>">
                                            </div>
                                        </div>
                                        <div class="clear"></div>

                                        <div class="one-half" style="float:none; margin: 0 auto;">
                                            <div class="setting-label">Margin Bottom</div>
                                            <div class="setting"><input class="builder-field" type="text" name="bars[mainsettings][margin_bottom]" value="<?php echo $mainsettings['margin_bottom']; ?>">
                                            </div>
                                        </div>
                                        <div class="clear"></div>

                                    </div>


                                </div>


                                <div class="dzs-tab-tobe">
                                    <div class="tab-menu with-tooltip">
                                        Animation
                                    </div>
                                    <div class="tab-content">
                                        <div class="setting">
                                            <div class="setting-label">Animation Time</div>
                                            <input class="builder-field" type="text" name="bars[mainsettings][animation_time]" value="<?php echo $mainsettings['animation_time']; ?>">
                                            <div class="sidenote">Animation Time in ms - 1000 ms = 1 second</div>    
                                        </div>
                                        <div class="setting">
                                            <div class="setting-label">Percent</div>
                                            <input class="builder-field" type="text" name="bars[mainsettings][maxperc]" value="<?php echo $mainsettings['maxperc']; ?>">

                                            <div class="jqueryui-slider for-perc"></div>
                                            <div class="sidenote">Percent on which the animation goes - from 1 to 100</div>    
                                        </div>
                                        <div class="setting">
                                            <div class="setting-label">Animation Number</div>
                                            <input class="builder-field" type="text" name="bars[mainsettings][maxnr]" value="<?php echo $mainsettings['maxnr']; ?>">
                                            <div class="sidenote">You can have a progress number which increments as the progress goes on. You insert it via {{percmaxnr}} in the text block ideally.</div>    
                                        </div>
                                        <div class="setting">
                                            <div class="setting-label">Animation Starts on ...</div>
                                            <?php
                                            $lab = 'initon';
                                            echo DZSHelpers::generate_select('bars[mainsettings]['.$lab.']',array('options' => array('init','scroll'),'class' => 'styleme builder-field','seekval' => $mainsettings[$lab]));
                                            ?><div class="sidenote">init - page load, scroll - when the page scrolls to it's location.</div>    
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <br>
                            <div class="sidenote"><p>You can have variables that are replaced dinamically while the progress bars animate. 
                                    Might be overwhelming to understand them all but you can search 
                                    the examples for easily understanding. A cheatsheet can be found below</p>
            {{perc}} - outputs the current percentage, for example if the progress is at 47% it will output 47%
            <br>{{perc-decimal}} - outputs the current percentage in decimal form, for example if the progress is at 47% it will output 0.47
            <br>{{perc100-decimal}} - it's the same as perc-decimal but the difference is it will go up until 1 even if the <strong>Percent</strong> is set to lower then 100%
            <br>{{center}} - it will center the element, currently available only for the <strong>Top</strong> property
            <br>{{percmaxnr}} - outputs the current number relative the percent, you set the number in the <strong>Animation Number</strong> field. 
            For example if progress is at 47% and the Animation Number is 500 - the output will be <strong>235</strong>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br/>
                        <br/>
                        <div class="col-md-6">
                            <button class="button-primary btn-save-skin">Save Changes</button>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                            version 1.0
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <h3>Output / <span style='opacity: 0.5; '>you can include this in your html</span></h3>
                            <div class="dzsprg-output-div">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <h3>Preview Examples</h3>
                        </div>
                        <br>
                        <div class="col-md-2">
                            <a href='?skin=prev1'>
                                <div class='divimage preview-example' style='background-image: url(img/skin1.png);'></div>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href='?skin=prev2'>
                                <div class='divimage preview-example' style='background-image: url(img/skin2.png);'></div>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href='?skin=prev3'>
                                <div class='divimage preview-example' style='background-image: url(img/skin3.png);'></div>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href='?skin=prev4'>
                                <div class='divimage preview-example' style='background-image: url(img/skin4.png);'></div>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href='?skin=prev5'>
                                <div class='divimage preview-example' style='background-image: url(img/skin5.png);'></div>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href='?skin=prev6'>
                                <div class='divimage preview-example' style='background-image: url(img/skin6.png);'></div>
                            </a>
                        </div>
                        
                    </div>
                </form>
            </div>
        </section>
        <div class="saveconfirmer active" style=""><img alt="" style="" id="save-ajax-loading2" src="./img/wpspin_light.gif"/></div>

        <link rel="stylesheet" href="fontawesome/font-awesome.min.css">
        <script src="./tinymce/tinymce.min.js"></script>
        <script src="./tinymce/jquery.tinymce.min.js"></script>

        <script src="dzsscroller/scroller.js" type="text/javascript"></script>
        <link rel='stylesheet' type="text/css" href="dzsscroller/scroller.css"/>

        <link rel='stylesheet' type="text/css" href="jqueryui/jquery-ui.min.css"/>
        <script src="jqueryui/jquery-ui.min.js" type="text/javascript"></script>
        <link rel='stylesheet' type="text/css" href="dzstabsandaccordions/dzstabsandaccordions.css"/>
        <script src="dzstabsandaccordions/dzstabsandaccordions.js"></script>
        <link rel='stylesheet' type="text/css" href="colorpicker/farbtastic.css"/>
        <script src="colorpicker/farbtastic.js"></script>

        <link rel='stylesheet' type="text/css" href="dzsprogressbars/dzsprogressbars.css"/>
        <script src="dzsprogressbars/dzsprogressbars.js" type="text/javascript"></script>
        <script src="js/builder.js" type="text/javascript"></script>

        <link rel='stylesheet' type="text/css" href="style/builder.css"/>
    </body>
</html>