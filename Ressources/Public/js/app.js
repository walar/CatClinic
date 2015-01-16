// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();

tinymce.init({
    selector: "form #contenu",
    language_url : "/Ressources/Public/js/tinymce-lang.fr_FR.js",
    plugins: "textcolor",
    //toolbar: "forecolor backcolor"
    toolbar: "undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | forecolor backcolor"

});
