//AJAX BLOCK//
$(document).on('click','.ajaxLink', function(event){
    event.preventDefault();
    let $url = $(this).attr('href');
    ajaxLoad($url);
    history.pushState(null, '', $url);
});
window.onpopstate = function(event) {
    //console.log("location: " + document.location + ", state: " + JSON.stringify(event.state));
    let $stateUrl = document.location.href;
    console.log($stateUrl);
    ajaxLoad($stateUrl);
};

function ajaxLoad($url){
    $.ajax({
        url: $url,
        type: "GET",
        context: $('#ajaxWrapper'),
        success: function (data) {
            if (!data) throw '';
            console.log("ajax");
            let $extracted = null;
            let $html = null;
            $extracted = $(data).find(".contentBlock");
            $html = $extracted.html();
            // console.log($html);
            $("#menu").addClass('white');

            $(this).html("");
            $(this).html("<div class='contentBlock currentContent'>"+$html+"</div>");
            show_jq_hidden();
            if ($extracted.find("#indexSlider").length > 0) {
                $("#menu").removeClass('white');
                initSlider();
            }
            if ($extracted.find("#pressCenterContent").length > 0) {
                if (ias) {
                    ias.reinitialize();
                    console.log("reinit");
                }
                else{
                    iasNews();
                    console.log("bind");
                }

            } else {
                if (ias) {ias.unbind(); console.log("unbind");}
            }
            if ($extracted.find("#map").length > 0) {initialize();}

            // $(this).append($html);
            // $popUpIngrCont.html(data);
            // console.log( $popUpIngrCont.filter('.catBlock').offset().top);
            // let pageNext = $(data).filter('.catBlock').data('next');
            // popUp($popUpIngr);
        },
        error: function () {
            alert("Ошибка AJAX!");
        }
    });
}
function popUp(block){
    block.addClass('active');
    block.css({
        "opacity" : 1,
        "visibility" : "visible"
    });
    // $mainBlock.addClass("unscroll");
}
//END AJAX BLOCK //