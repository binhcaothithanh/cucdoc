<!DOCTYPE html>
<html>
    <head>
        <title>MeoCung.com</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="AUTHOR" content="MeoCung.com"/>
        <meta name="description" content="God will answer every your question" />
        <meta name="title" content="THIS IS GOD OF DECISION" />
        <meta name="keywords" content="<?php echo $seo['meta_keyword']; ?>" />
        <!-- <link href="/assets/user/images/favi.png" rel="shortcut icon" /> -->
        <!--FB-->
        <meta property="og:url" content="<?php echo $current_url; ?>" />
        <meta property="og:type"   content="website" />
        <meta property="og:site_name" content="MeoCung.com"/>
        <meta property="og:title" content="THIS IS GOD OF DECISION" />
        <meta property="og:description" content="God will answer every your question" />
        <meta property="og:image" content="http://MeoCung.com/assets/user/images/logo.png"/>
        <!-- <meta property="fb:app_id" content="335793634896268"/> -->


            <link href="/assets/user/css/bootstrap.min.css?t=<?php echo time(); ?>" rel="stylesheet">

            <link href="/assets/user/css/form.css?t=<?php echo (time());?>" rel="stylesheet" type="text/css">
            <link href="/assets/user/css/style.css?t=<?php echo (time());?>" rel="stylesheet" type="text/css">


            <script src="/assets/user/js/jquery-1.12.1.min.js?t=<?php echo time(); ?>" ></script>

            <script src="/assets/user/js/popper.min.js?t=<?php echo time(); ?>" ></script>
            <script src="/assets/user/js/bootstrap.min.js?t=<?php echo time(); ?>" ></script>
            <script
              src="https://www.paypal.com/sdk/js?client-id=BAAsaQu-ugi7cXWTs2e1inX3irP7--OyiO5DBC5EWHds_chsDAiFQbSUVDVER1nYIHgjE1b-DUuRE5xHMc&components=hosted-buttons&disable-funding=venmo&currency=USD">
            </script>
    </head>
    <body>
        <div class="wrapper">

            <div class="container">
                <div class="top-menu-bar">
                  <?php
                  if(!$is_mobile): ?>
                    <a class="w-50 logo-brand" href="/">MeoCung.com</a>
                  <?php else: ?>
                    <a class="w-50 logo-brand" href="/">MC</a>
                  <?php endif; ?>
                    <div class="w-50" style="display: flex; justify-content: flex-end; padding-right: 20px;">
                      <a href="/contact.html" class=" a-menu-wolf a-menu-button">Contact</a>
                      <a href="https://buymeacoffee.com/meocung" class=" a-menu-cat a-menu-button">Donate</a>
                      <a href="/about.html" class=" a-menu-dolphin a-menu-button">About</a>
                    </div>
                  </div>
              </div>
            </div>

                <div class="content" >
                  <div class="top-bar">
                  </div>
                  <View id="contentDisplay" name="contentDisplay">
                    <?php echo $content_block; ?>
                  </View>
                </div>
            <div class="footer-area">
                <div class="container">
                    <div class="footer-menu" style="padding-left: 0; border-right: solid 1px #444;">
                        <ul>
                            <li>
                                <a href="https://buymeacoffee.com/meocung">
                                  <h3>Donate</h3>
                                </a>
                            </li>
                            <li>
                              <a href="/terms-and-conditions.html">Terms and Conditions</a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-menu">
                        <ul>
                            <li>
                                <h3>Information</h3>
                            </li>
                            <li>
                              <a href="/privacy-policy.html">Privacy Policy</a>
                            </li>
                            <li><a href="/contact.html">Contact</a></li>
                        </ul>
                    </div>
                    <div class="footer-address">
                        <?php
                        if(isset($footer)){
                          echo($footer['content']);
                        }
                         ?>
                    </div>
                </div>
            </div>

        </div>
		        <script src="/assets/user/js/main.js?t=111"></script>
    </body>
</html>
