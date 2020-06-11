<?php
// remove post_meta
add_filter('tc_meta_utility_text', fn($val) => '', 50);
