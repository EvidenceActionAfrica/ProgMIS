function codeAddress() {
    var Event = YAHOO.util.Event,
        Dom   = YAHOO.util.Dom,
        lang  = YAHOO.lang,
        slider,
        bg = "slider-bg",
        thumb = "slider-thumb";

    var leftConstraint = 0;//The slider can move 0 pixels left
    var rightConstraint = 200;//The slider can move 200 pixels right
    var tickSize = 20;
    var imgWidth = {
        min: 800,
        max: 4096
    };
    var m =  (imgWidth.max - imgWidth.min)  / rightConstraint;//slope m in y = mx c;

    
    Event.onDOMReady(function() {
        slider = YAHOO.widget.Slider.getHorizSlider(bg, thumb, leftConstraint, rightConstraint, tickSize);
        slider.getCalculatedValue = function() {
            return Math.round(m * this.getValue() + imgWidth.min);////linear interpolation; y = mx + c;
        }
        var zoom_img = YAHOO.util.Dom.get('z_img');//Find the DOM node for the target image
        slider.subscribe('change', function (offsetFromStart) {
            zoom_img.style.width = this.getCalculatedValue() + 'px'; //browser looks after height, maintaining image's aspect ratio.
        });
        slider.setValue ( 0, true, false, false );//initialise the slider position and book size
        //parameters: setValue (newOffset ,     skipAnim , force , silent)
    });
}

// function codeAddress() {
//             alert('ok');
//         }
        window.onload = codeAddress;
