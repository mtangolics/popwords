<!DOCTYPE HTML>
<html>
    <head>
    <script type="text/javascript" src="protovis-d3.2.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.js"></script>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript">
	$(function() {
		var wordCache;
		
		$( "#slider-range" ).slider({
			range: true,
			min: 2000,
			max: 2011,
			values: [ 2010, 2011 ],
			slide: function( event, ui ) {
				$( "#amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
				updateCache(ui.values[0],ui.values[1]);
			}
		});
		$( "#amount" ).val($( "#slider-range" ).slider( "values", 0 ) + " - " + $( "#slider-range" ).slider( "values", 1 ) );
		
		var updateCache = function(min,max) {
			for(var i = min; i <= max; i++)
			{
				if(eval(/*"wordCache[" + i + "]"*/true))
				{
					console.log(i + " needs to be downloaded");
					jQuery.getJSON('lyrics.php?year=2010', function(data) {
						wordCache = data;
						renderCloud(wordCache.Attribute);
					});
					
				}
			}
		};
	});


  </script>
  </head>
  <body>
    <script type="text/javascript+protovis">
	//var test = pv.flatten(flare).leaf(Number).array();
	/* Produce a flat hierarchy of the Flare classes. */
	function renderCloud(array)
	{
		var classes = pv.nodes(array);

		var vis = new pv.Panel()
			.width(600)
			.height(600);

		vis.add(pv.Layout.Pack)
			.top(-50)
			.bottom(-50)
			.nodes(classes)
			.size(function(d) d.nodeValue.Value)
			.spacing(0)
			.order(null)
		  .node.add(pv.Dot)
			.fillStyle(pv.Colors.category20().by(function(d) d.nodeValue.Name))
			.strokeStyle(function() this.fillStyle().darker())
			.visible(function(d) d.parentNode)
			.title(function(d) d.nodeValue.Value)
		  .anchor("center").add(pv.Label)
			.text(function(d) d.nodeValue.Name);

		vis.render();
	}

</script> 
    </head>
    <body>
		<div id="slider-range"></div>
    </body>
</html>