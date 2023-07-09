$("#transformation").change(function () {
    if (this.value === "memeGen") {
        $(".memeTextContainer").removeClass("memeTextContainer--hidden");
    } else {
        $(".memeTextContainer").addClass("memeTextContainer--hidden");
    }
});
