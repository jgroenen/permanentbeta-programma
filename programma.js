var hearts = JSON.parse(localStorage.getItem("hearts")) || {};
// Loop hearts and toggle on.
$(".heart_5617cae9ce5d0").each(function () {
    $(this).toggleClass("hearted", (function ($el) {
        return !!hearts[$el.data("presentatieid")];
    })($(this)));
});
// Loop the blocks and shift to the first hearted column.
$(".blok").each(function () {
    var $ruimte = $(this).find(".heart_5617cae9ce5d0.hearted").first().closest(".ruimte");
    if ($ruimte.position()) $(this).scrollLeft($ruimte.position().left + -10);
});
// Bind click to toggle on and save.
$(".heart_5617cae9ce5d0").click(function (e) {
    e.stopPropagation();
    var $el = $(this);
    $el.toggleClass("hearted");
    hearts[$el.data("presentatieid")] = $el.hasClass("hearted");
    localStorage.setItem("hearts", JSON.stringify(hearts));
});

//FIXME bit ugly :)
$(".ruimte").click(function () {
    $details = $(this).clone();
    $(".details").append($details);
    $details.find(".indicator").remove();
    $("html").css("overflow", "hidden");
    $details.click(function () {
        $(this).remove();
        $("html").css("overflow", "auto");
    });
});

// For testing
$(".bar").each(function () {
    var fill = Math.random();
    //FIXME fill = hearts / spots
    if (fill > 1) {
        fill = 1;
    }
    $(this).find(".fill").css("width", (fill * 100) + "%");
    if (fill > 0.9) {
        $(this).find(".fill").css("background", "#f00");
    }
});