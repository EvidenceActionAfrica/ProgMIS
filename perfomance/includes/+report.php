<!-- CSS -->
<link rel="stylesheet" href="css/+report.css" type="text/css" media="screen" />

<!-- this places a background on the values on the points on the line graph, changes the font of the numbers in the graph, and adds the legend. I edited the font-family attributes in this file to: "Courier New", monospace.-->
<link class="include" rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css" />

<!-- JS -->
<!-- use this for the animated horizontal and vertical bargraphs -->
<script src="js/jquery-1.10.2.min.js"></script>

<!-- highcharts for the animated pie graph. highcharts is a charting library written in pure JavaScript. -->
<script src="js/highcharts.js"></script>

<!-- jqplot for the animated line graph. jqPlot is a plotting and charting plugin for the jQuery Javascript framework. -->
<!-- <script class="include" type="text/javascript" src="js/jquery.min.js"></script> this conflicts with "highcharts.js". I suspect that it has some common keywords so both the line-graph and pie-chart disappear. It is for this reason that I think the line-graph can work without it. -->
<script class="include" type="text/javascript" src="js/jquery.jqplot.min.js"></script>
<script class="include" type="text/javascript" src="js/jqplot.dateAxisRenderer.js"></script>

<!-- this places the numbers on the points on the line graphs -->
<script class="include" type="text/javascript" src="js/jqplot.highlighter.min.js"></script>
<!-- this turns the cursor to a "+" so that you can zoom in on any area on the graph -->
<script class="include" type="text/javascript" src="js/jqplot.cursor.min.js"></script>