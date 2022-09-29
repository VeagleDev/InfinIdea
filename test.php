<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script>
        // make a function which detect if user press ctrl + v
        function ctrlV(e) {
            if (e.ctrlKey && e.keyCode == 86) {
                // if user press ctrl + v, alert a message
                getClipboardData(e);
                // prevent the default action
                e.preventDefault();
            }
        }
        // call function ctrlV when user press a key
        document.getElementById("comment").addEventListener("keydown", ctrlV);

        // make a function to get clipboard data
        function getClipboardData(e) {
            // get clipboard data
            var clipboardData = e.clipboardData || window.clipboardData;
            // get text from clipboard
            var text = clipboardData.getData('text');
            // if text is not empty
            alert('Voici le texte que vous avez copié : ' + text);
        }
    </script>
</head>
<body>
<!-- make a textarea for the comment -->
<form method="post">
    <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
    <input type="submit" value="Envoyer">
</form>


</body>