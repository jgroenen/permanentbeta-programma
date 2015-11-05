var hearts = JSON.parse(localStorage.getItem("hearts")) || {};
var deviceId = localStorage.getItem("deviceId") || "";
if (!deviceId) {
    deviceId = (Math.floor(Math.random() * 1000000000)).toString(10);
    localStorage.setItem("deviceId", deviceId);
}

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
    else $(this).scrollLeft('100');
});

// Bind click to toggle on and save.
$(".heart_5617cae9ce5d0").click(function (e) {
    e.stopPropagation();
    var $el = $(this);
    $el.toggleClass("hearted");
    var presentatieId = $el.data("presentatieid");
    var hearted = $el.hasClass("hearted")
    hearts[presentatieId] = hearted;
    localStorage.setItem("hearts", JSON.stringify(hearts));
    $.post("/hearts.php", {
        deviceId: deviceId,
        presentatieId: presentatieId,
        hearted: hearted
    }, fillCapacities);
});

// Click to enlarge.
$(".ruimte").click(function () {
    $details = $(this).clone(); // FIXME memory leak?
    $(".details").append($details);
    $details.find(".indicator").remove();
    $("html").css("overflow", "hidden");
    $details.click(function () {
        $(this).remove(); // FIXME memory leak?
        $("html").css("overflow", "auto");
    });
});

// Calculate capacities.
function updateHeartCounts() {
    $.get("/hearts.php", fillCapacities);
}

// Fill capacities.
function fillCapacities(data) {
    data.forEach(function (entry) {
        var $bar = $(".bar[data-presentatieId=" + entry.presentatieId + "]");
        var capaciteit = $bar.data("capaciteit");
        var fill = 0.8 * (entry.count / capaciteit) + 0.2; // Always show a bit, and there's always room for a bit more.
        if (fill > 1) {
            fill = 1;
        }
        var $fill = $bar.find(".fill");
        $fill.css({
            width: (fill * 100) + "%",
            background: 
                fill > 0.9 ? "#f00" :
                fill > 0.8 ? "#f90" :
                fill > 0.5 ? "#ff0" :
                "#0f0"
        });
    });
}

// Update hearts.
updateHeartCounts();
setInterval(updateHeartCounts, 60000);