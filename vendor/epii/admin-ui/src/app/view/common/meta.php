<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $_ui_["site_title"]; ?></title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo $_ui_["static_url_pre"]; ?>js/plugins/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="<?php echo $_ui_["static_url_pre"]; ?>css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo $_ui_["static_url_pre"]; ?>css/adminlte_ws.css">
<link rel="stylesheet" href="<?php echo $_ui_["static_url_pre"]; ?>js/plugins/bootStrap-addTabs/bootstrap.addtabs.css"
      type="text/css"
      media="screen"/>
<link rel="stylesheet" href="<?php echo $_ui_["static_url_pre"]; ?>css/epii.css">

<style>
    @font-face {
        font-family: 'FontAwesome';
        src: url('<?php echo $_ui_["fontawesome_fonts_url_pre"]; ?>/fontawesome-webfont.eot?v=4.7.0');
        src: url('<?php echo $_ui_["fontawesome_fonts_url_pre"]; ?>/fontawesome-webfont.eot?#iefix&v=4.7.0') format('embedded-opentype'), url('<?php echo $_ui_["fontawesome_fonts_url_pre"]; ?>/fontawesome-webfont.woff2?v=4.7.0') format('woff2'), url('<?php echo $_ui_["fontawesome_fonts_url_pre"]; ?>/fontawesome-webfont.woff?v=4.7.0') format('woff'), url('<?php echo $_ui_["fontawesome_fonts_url_pre"]; ?>/fontawesome-webfont.ttf?v=4.7.0') format('truetype'), url('<?php echo $_ui_["fontawesome_fonts_url_pre"]; ?>/fontawesome-webfont.svg?v=4.7.0#fontawesomeregular') format('svg');
        font-weight: normal;
        font-style: normal;
    }

</style>

<?php if (isset($_ui_["css"])) {
    foreach ($_ui_["css"] as $css) {

        ?>
        <link rel="stylesheet" href="<?php echo $css; ?>">
    <?php };
} ?>

<script>
    var Args = window.Args = <?php echo $_ui_["epiiargs_data"]; ?>;
    window.onEpiiInit = function (callback) {
        if (!window.epiiInitFunctions) {
            window.epiiInitFunctions = [];
        }
        window.epiiInitFunctions.push(callback);
    };

</script>