    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var langs = <?= $airports ?>;
            $('#airport-to').autocomplete({
                source: langs
            });
            $('#airport-from').autocomplete({
                source: langs
            });
           $('#submitRoute').click(function () {
               sendAjaxForm('form-result', 'form-route', '/')
               return false;
           });
        });

        // Функция отправки ajax.
        function sendAjaxForm (resultDiv, form, url) {
            $.ajax({
                url: url,
                type: "POST",
                dataType: "html",
                data: $('#' + form).serialize(),
                success: function (response) {
                    console.log($('#' + form).serialize()),
                    console.log(response);
                    $('#' + resultDiv).html(response);
                },
                error: function (response) {
                    console.log(response);
                    $('#' + resultDiv).html(response);
                }
            });
        }
    </script>
</body>
</html>