var page = require('webpage').create();
var system = require('system');
var address = system.args[1];   // 截图页面地址
var output = system.args[2];    // 保存路径
var widths = system.args[3];    // 图片宽度
var heights = system.args[4];    // 图片高度
var zoomFactors = system.args[5];    // 放大倍数
var time = system.args[6];    // 渲染时间
var autoheight = 0;

page.viewportSize = { width: widths, height: 5000 }; // 页面初始高度
page.zoomFactor=zoomFactors;
page.open(decodeURIComponent(address), function (status) { // 打开页面
    if (status === "success") { // 加载完成
        // 通过在JS获取页面的渲染高度
        var rect = page.evaluate(function () {
            return document.getElementsByTagName('html')[0].getBoundingClientRect();
        });
        if(heights==0)
        {
            autoheight = rect.bottom * zoomFactors;
        }else{
            autoheight = heights;
        }
        // 按照实际页面的高度，设定渲染的宽高
        page.clipRect = {
            top:    rect.top,
            // left:   rect.left,
            left:   0,
            width:  widths,
            height: autoheight,
        };

        // 预留一定的渲染时间
        window.setTimeout(function () {
            page.render(output,{format:'jpeg',quality:100});
            //var base64 = page.renderBase64({format:'jpeg',quality:'100'});
            page.close();
            //console.log(base64);
            console.log('success');
            phantom.exit();
        }, time);
    }
});
