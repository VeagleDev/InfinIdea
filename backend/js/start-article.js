document.onload = () => {
    $(document).ready(function () {
        $('code').addClass('prettyprint');
    });
    $(document).ready(function () {
        $('pre').addClass('prettyprint');
    });

    PR.prettyPrint();
}