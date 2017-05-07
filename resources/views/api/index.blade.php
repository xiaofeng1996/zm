<!DOCTYPE html>
<html>
    <head>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <div id="app"></div>
        <script src="{{ elixir('js/api/app.js') }}"></script>
    </body>
</html>