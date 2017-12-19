
<script src="../lib/flot/flotr2.js"></script>
<style>
#editor-render-0 {
  width: 340px;
  height: 220px;
  margin: 24px auto;
}
</style>
<div id="editor-render-0" style="width:500px;height:800px;"></div>
<script>
$(function () {
(function bars_stacked(container, horizontal) {

    var
    d1 = [],
        d2 = [],
        d3 = [],
        graph, i;

    for (i = 0; i < 10; i++) {
        if (horizontal) {
            d1.push([Math.random(), i]);
            d2.push([Math.random(), i]);
            d3.push([Math.random(), i]);
        } else {
            d1.push([i, Math.random()]);
            d2.push([i, Math.random()]);
            d3.push([i, Math.random()]);
        }
    }

    graph = Flotr.draw(container, [{
        data: d1,
        label: 'Serie 1'
    }, {
        data: d2,
        label: 'Serie 2'
    }, {
        data: d3,
        label: 'Serie 3'
    }], {
        legend: {
            backgroundColor: '#D2E8FF', // Light blue 
			position : 'ne'
        },
		tooltip: {
		},
        bars: {
            show: true,
            stacked: true,
            horizontal: horizontal,
            barWidth: 0.6,
            lineWidth: 1,
            shadowSize: 0
        },
        grid: {
            verticalLines: horizontal,
            horizontalLines: !horizontal
        }
    });
})(document.getElementById("editor-render-0"),true);
});
</script>