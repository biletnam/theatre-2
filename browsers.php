<?php
        $nav = ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) ? strtolower( $_SERVER['HTTP_USER_AGENT'] ) : '';
         if (stristr($nav, "opera")) {
            echo "styles_op.css";
         }
         else if (stristr($nav, "IE")) {
            echo "styles_ie.css";
         }
         else if (stristr($nav, "Firefox")) {
            echo "styles_moz.css";
         }
         else {
            echo "styles.css";
         }
?>